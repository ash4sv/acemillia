<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProductAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Tag;
use App\Services\ImageUploader;
use App\Services\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ProductAdminController extends Controller
{
    protected string $view = 'apps.admin.shop.products.';
    private $categories, $tags;

    public function __construct()
    {
        $this->categories = Category::active()->get();
        $this->tags = Tag::active()->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductAdminDataTable $dataTable)
    {
        $title = 'Delete Tag!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'product' => null,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateProduct($request);
        Alert::success('Successfully Create!', 'Sub Category has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'product' => $this->findOrFailProduct($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'product' => $this->findOrFailProduct($id),
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->all();
        $this->updateOrCreateProduct($request, $id);
        Alert::success('Successfully Update!', 'Sub Category has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->findOrFailProduct($id);
        $product->images()->delete();
        $product->options()->delete();
        $product->options()->values()->delete();
        $product->delete();
        Alert::success('Successfully Deleted!', 'Sub Category has been deleted!');
        return redirect()->back();
    }


    /**
     * Fetch Event by ID or fail.
     */
    private function findOrFailProduct(string $id): Product
    {
        return Product::with(['options', 'options.values'])->findOrFail($id);
    }

    /**
     * Save or update a product.
     */
    private function updateOrCreateProduct(Request $request, string $id = null): Product
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
            $data['stock_status'] = $request->input('stock_status', 'in_stock'); // Example default
            $data['price'] = preg_replace('/^MYR\s*/', '', $data['price']);

            $slugProduct = SlugGenerator::generateUniqueSlug($data['name'], Product::class, $id);

            $product = Product::updateOrCreate(
                ['id' => $id],
                [
                    'merchant_id'         => null,
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
            // If the form submits "existing_image_ids", remove any images whose IDs are not present.
            // If no hidden inputs are present (user removed all images), delete them all.
            if ($request->has('existing_image_ids')) {
                $submittedImageIds = collect($request->input('existing_image_ids'));
                $product->images()->whereNotIn('id', $submittedImageIds)->delete();
            } else {
                $product->images()->delete();
            }

            // Process new image uploads.
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
                    // Remove options not present in the submitted data.
                    $requestedOptionsIds = collect($submittedOptions)
                        ->filter(function ($option) {
                            return !empty($option['name']);
                        })
                        ->pluck('id')
                        ->filter();

                    if ($requestedOptionsIds->isEmpty()) {
                        $product->options()->delete();
                    } else {
                        $product->options()->whereNotIn('id', $requestedOptionsIds)->delete();
                    }

                    // Loop through each submitted option.
                    foreach ($submittedOptions as $optionIndex => $optionData) {
                        // Skip options without a valid name.
                        if (empty($optionData['name'])) {
                            continue;
                        }

                        // Process option file upload, if available.
                        if ($request->hasFile("options.$optionIndex.image_path")) {
                            $uploadedOptionImagePath = ImageUploader::uploadSingleImage(
                                $request->file("options.$optionIndex.image_path"),
                                'assets/upload/',
                                'option-images'
                            );
                        } else {
                            $uploadedOptionImagePath = null;
                        }

                        // Build the update data conditionally.
                        $optionDataToUpdate = [
                            'merchant_id' => $product->merchant_id,
                            'name'        => $optionData['name'],
                        ];
                        if ($uploadedOptionImagePath !== null) {
                            $optionDataToUpdate['image_path'] = $uploadedOptionImagePath;
                        }

                        // Update or create the option.
                        $productOption = $product->options()->updateOrCreate(
                            ['id' => $optionData['id'] ?? null],
                            $optionDataToUpdate
                        );

                        // Process option values if provided.
                        if (isset($optionData['values']) && is_array($optionData['values'])) {
                            $submittedValues = $optionData['values'];

                            // Remove option values not in the submitted data.
                            $requestedValuesIds = collect($submittedValues)
                                ->filter(function ($value) {
                                    return !empty($value['value']);
                                })
                                ->pluck('id')
                                ->filter();

                            if ($requestedValuesIds->isEmpty()) {
                                $productOption->values()->delete();
                            } else {
                                $productOption->values()->whereNotIn('id', $requestedValuesIds)->delete();
                            }

                            // Loop through each submitted option value.
                            foreach ($submittedValues as $valueIndex => $valueData) {
                                // Skip values without a valid "value" field.
                                if (empty($valueData['value'])) {
                                    continue;
                                }

                                // Process option value file upload, if available.
                                if ($request->hasFile("options.$optionIndex.values.$valueIndex.image_path")) {
                                    $uploadedValueImagePath = ImageUploader::uploadSingleImage(
                                        $request->file("options.$optionIndex.values.$valueIndex.image_path"),
                                        'assets/upload/',
                                        'value-images'
                                    );
                                } else {
                                    $uploadedValueImagePath = null;
                                }

                                // Build update data for the option value.
                                $valueDataToUpdate = [
                                    'merchant_id'      => $product->merchant_id,
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
                // If no options were sent at all, delete all existing options.
                $product->options()->delete();
            }

            $product->categories()->sync($request->input('categories'));
            $product->tags()->sync($request->input('tags'));

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
