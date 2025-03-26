<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Tag;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class ProductBaseController extends Controller
{
    protected $categories;
    protected $tags;

    public function __construct()
    {
        // Load shared properties.
        $this->categories = Category::active()->get();
        $this->tags = Tag::active()->get();
    }

    /**
     * Retrieve a product with its options or fail.
     */
    protected function findOrFailProduct(string $id): Product
    {
        return Product::with(['options', 'options.values'])->findOrFail($id);
    }

    /**
     * Save or update a product.
     *
     * If a merchant is logged in, getMerchantId() should return the merchant's id.
     */
    protected function updateOrCreateProduct(Request $request, string $id = null): Product
    {
        DB::beginTransaction();
        try {
            // ----------------------------------------------------------
            // DATA EXTRACTION & PRODUCT CREATION
            // ----------------------------------------------------------
            $data = $request->only([
                'name',
                'product_description',
                'description',
                'information',
                'price',
                'sku',
                'weight',
                'stock'
            ]);

            $productData = $id !== null ? $this->findOrFailProduct($id) : null;
            $imageFilePath = $request->file('main_image')
                ? ImageUploader::uploadSingleImage($request->file('main_image'), 'assets/upload/', 'product_main_image')
                : ($productData->image ?? null);

            // Map additional fields.
            $data['status']       = $request->input('publish', 'Draft');
            $data['stock_status'] = $request->input('stock_status', 'in_stock');
            $data['price']        = preg_replace('/^MYR\s*/', '', $data['price']);

            $slugProduct = SlugGenerator::generateUniqueSlug($data['name'], Product::class, $id);

            $product = Product::updateOrCreate(
                ['id' => $id],
                [
                    // Use getMerchantId() to inject the merchant's id if applicable.
                    'merchant_id'         => $this->getMerchantId(),
                    'name'                => $data['name'],
                    'slug'                => $slugProduct,
                    'product_description' => $data['product_description'],
                    'description'         => $data['description'],
                    'information'         => $data['information'],
                    'price'               => $data['price'],
                    'sku'                 => $data['sku'],
                    'weight'              => $data['weight'],
                    'stock'               => $data['stock'],
                    'image'               => $imageFilePath,
                    'stock_status'        => true,
                    'status'              => $data['status'],
                ]
            );

            // ----------------------------------------------------------
            // IMAGE PROCESSING
            // ----------------------------------------------------------
            if ($request->has('existing_image_ids')) {
                $submittedImageIds = collect($request->input('existing_image_ids'));
                $product->images()->whereNotIn('id', $submittedImageIds)->delete();
            } else {
                $product->images()->delete();
            }

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $imagePath = ImageUploader::uploadSingleImage($file, 'assets/upload/', 'product-images');
                    $product->images()->create([
                        'image_path' => $imagePath
                    ]);
                }
            }

            // ----------------------------------------------------------
            // OPTIONS AND OPTION VALUES PROCESSING
            // ----------------------------------------------------------
            if ($request->has('options')) {
                $submittedOptions = $request->input('options');

                if (empty($submittedOptions)) {
                    $product->options()->delete();
                } else {
                    $requestedOptionsIds = collect($submittedOptions)
                        ->filter(fn($option) => !empty($option['name']))
                        ->pluck('id')
                        ->filter();

                    if ($requestedOptionsIds->isEmpty()) {
                        $product->options()->delete();
                    } else {
                        $product->options()->whereNotIn('id', $requestedOptionsIds)->delete();
                    }

                    foreach ($submittedOptions as $optionIndex => $optionData) {
                        if (empty($optionData['name'])) {
                            continue;
                        }

                        if ($request->hasFile("options.$optionIndex.image_path")) {
                            $uploadedOptionImagePath = ImageUploader::uploadSingleImage(
                                $request->file("options.$optionIndex.image_path"),
                                'assets/upload/',
                                'option-images'
                            );
                        } else {
                            $uploadedOptionImagePath = null;
                        }

                        $optionDataToUpdate = [
                            'merchant_id' => $this->getMerchantId(),
                            'name'        => $optionData['name'],
                        ];
                        if ($uploadedOptionImagePath !== null) {
                            $optionDataToUpdate['image_path'] = $uploadedOptionImagePath;
                        }

                        $productOption = $product->options()->updateOrCreate(
                            ['id' => $optionData['id'] ?? null],
                            $optionDataToUpdate
                        );

                        if (isset($optionData['values']) && is_array($optionData['values'])) {
                            $submittedValues = $optionData['values'];

                            $requestedValuesIds = collect($submittedValues)
                                ->filter(fn($value) => !empty($value['value']))
                                ->pluck('id')
                                ->filter();

                            if ($requestedValuesIds->isEmpty()) {
                                $productOption->values()->delete();
                            } else {
                                $productOption->values()->whereNotIn('id', $requestedValuesIds)->delete();
                            }

                            foreach ($submittedValues as $valueIndex => $valueData) {
                                if (empty($valueData['value'])) {
                                    continue;
                                }

                                if ($request->hasFile("options.$optionIndex.values.$valueIndex.image_path")) {
                                    $uploadedValueImagePath = ImageUploader::uploadSingleImage(
                                        $request->file("options.$optionIndex.values.$valueIndex.image_path"),
                                        'assets/upload/',
                                        'value-images'
                                    );
                                } else {
                                    $uploadedValueImagePath = null;
                                }

                                $valueDataToUpdate = [
                                    'merchant_id'      => $this->getMerchantId(),
                                    'product_id'       => $product->id,
                                    'value'            => $valueData['value'],
                                    'additional_price' => $valueData['additional_price'],
                                    'stock'            => $valueData['stock'],
                                ];
                                if ($uploadedValueImagePath !== null) {
                                    $valueDataToUpdate['image_path'] = $uploadedValueImagePath;
                                }

                                $productOption->values()->updateOrCreate(
                                    ['id' => $valueData['id'] ?? null],
                                    $valueDataToUpdate
                                );
                            }
                        }
                    }
                }
            } else {
                $product->options()->delete();
            }

            // ----------------------------------------------------------
            // RELATIONSHIPS
            // ----------------------------------------------------------
            $product->categories()->sync($request->input('categories'));
            if ($request->has('sub_category')) {
                $subCategoryId = $request->input('sub_category');
                $product->sub_categories()->sync($subCategoryId ? [$subCategoryId] : []);
            }
            $product->tags()->sync($request->input('tags'));

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get the merchant's ID.
     *
     * Return null by default (admin) and override in the merchant controller.
     */
    protected function getMerchantId()
    {
        return null;
    }
}
