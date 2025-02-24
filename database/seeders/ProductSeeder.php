<?php

namespace Database\Seeders;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\SubCategory;
use App\Services\SlugGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // Provided menu setup (used only as reference for category/subcategory linking)
        $menuSetups = [
            [
                'name' => 'Pharmaceuticals',
                'status' => 'active',
                'categories' => [
                    [
                        'name' => 'Pharmaceuticals',
                        'status' => 'active',
                        'sub_categories' => [
                            ['name' => 'Isolation wear', 'status' => 'active'],
                            ['name' => 'Face masks', 'status' => 'active'],
                            ['name' => 'Face masks accessories', 'status' => 'active'],
                            ['name' => 'Face shield/goggles', 'status' => 'active'],
                            ['name' => 'Sanitizations/sterilizations/disinfectants', 'status' => 'active'],
                            ['name' => 'Oxygen concentrator devices', 'status' => 'active'],
                            ['name' => 'Gloves', 'status' => 'active'],
                        ],
                    ],
                    [
                        'name' => 'First Aid Kit',
                        'status' => 'active',
                        'sub_categories' => [
                            ['name' => 'Abs plastic', 'status' => 'active'],
                            ['name' => 'As transparent plastic', 'status' => 'active'],
                            ['name' => 'Pvc', 'status' => 'active'],
                            ['name' => 'Soft transparent pvc', 'status' => 'active'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Marketing',
                'status' => 'active',
                'categories' => [
                    [
                        'name' => 'Bag',
                        'status' => 'active',
                        'sub_categories' => [
                            ['name' => 'Laptop backpack', 'status' => 'active'],
                            ['name' => 'Backpack', 'status' => 'active'],
                            ['name' => 'Food delivery bag', 'status' => 'active'],
                            ['name' => 'Sling cooler bag', 'status' => 'active'],
                            ['name' => 'Multipurpose duffel bag', 'status' => 'active'],
                            ['name' => 'Travelling bag', 'status' => 'active'],
                            ['name' => 'Multipurpose bag', 'status' => 'active'],
                            ['name' => 'Toiletry bag', 'status' => 'active'],
                            ['name' => 'Batiq clutch bag', 'status' => 'active'],
                            ['name' => 'Batiq multipurpose pouch', 'status' => 'active'],
                            ['name' => 'Batiq comfort pillow', 'status' => 'active'],
                            ['name' => 'Batiq casual carrier', 'status' => 'active'],
                            ['name' => 'Batiq business traveller bag', 'status' => 'active'],
                            ['name' => 'Batiq laptop back pack', 'status' => 'active'],
                        ],
                    ],
                    [
                        'name' => 'Apparel',
                        'status' => 'active',
                        'sub_categories' => [
                            ['name' => 'Microfiber', 'status' => 'active'],
                            ['name' => 'Cotton', 'status' => 'active'],
                            ['name' => 'Lacoste', 'status' => 'active'],
                            ['name' => 'Denim', 'status' => 'active'],
                            ['name' => 'F1 Uniform', 'status' => 'active'],
                            ['name' => 'Jacket', 'status' => 'active'],
                            ['name' => 'Accessories', 'status' => 'active'],
                            ['name' => 'Clearance', 'status' => 'active'],
                        ],
                    ],
                    [
                        'name' => 'Souvenir',
                        'status' => 'active',
                        'sub_categories' => [
                            ['name' => 'Metal Pen', 'status' => 'active'],
                            ['name' => 'Foldable Nylon Bag', 'status' => 'active'],
                            ['name' => 'Foldable Duffle Bag', 'status' => 'active'],
                            ['name' => 'Foldable Backpack', 'status' => 'active'],
                            ['name' => 'Foldable Travelling bag', 'status' => 'active'],
                            ['name' => 'Drawstring Bag', 'status' => 'active'],
                            ['name' => 'Non Woven Bag', 'status' => 'active'],
                            ['name' => 'Canvas Bag', 'status' => 'active'],
                            ['name' => 'Lanyard', 'status' => 'active'],
                            ['name' => 'Eco stainless steel straw', 'status' => 'active'],
                            ['name' => 'Stationeries', 'status' => 'active'],
                            ['name' => 'Drinkwares Bottles', 'status' => 'active'],
                            ['name' => 'Mug', 'status' => 'active'],
                            ['name' => 'Umbrella', 'status' => 'active'],
                            ['name' => 'Collection award', 'status' => 'active'],
                        ],
                    ],
                ],
            ],
        ];

        // Loop through each menu, category, and subcategory.
        foreach ($menuSetups as $menu) {
            foreach ($menu['categories'] as $categoryData) {
                // Assume categories are already seeded; fetch by name.
                $category = Category::where('name', $categoryData['name'])->first();
                if (!$category) {
                    continue;
                }

                foreach ($categoryData['sub_categories'] as $subCategoryData) {
                    $subCategory = SubCategory::where('name', $subCategoryData['name'])->first();
                    if (!$subCategory) {
                        continue;
                    }

                    // Create a random number (6 to 15) of products for this subcategory.
                    $numProducts = rand(6, 15);

                    for ($i = 0; $i < $numProducts; $i++) {
                        DB::beginTransaction();
                        try {
                            // ----------------------------
                            // PRODUCT DATA GENERATION
                            // ----------------------------
                            $name = $category->name . ' ' . $subCategory->name . ' Product ' . ($i + 1);
                            $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.';
                            $price = rand(80, 1000);
                            $sku = 'SKU-' . rand(100000, 999999);
                            $weight = rand(280, 1000);
                            $stock = rand(10, 100);
                            $status = 'active';
                            $stock_status = true;

                            // Generate unique slug using your helper.
                            $slug = SlugGenerator::generateUniqueSlug($name, Product::class, null);

                            // Main image placeholder.
                            $mainImage = 'assets/images/fff.png';

                            // Mimic updateOrCreateProduct logic.
                            $product = Product::updateOrCreate(
                                ['id' => null],
                                [
                                    'merchant_id'         => null,
                                    'name'                => $name,
                                    'slug'                => $slug,
                                    'product_description' => $lorem,
                                    'description'         => $lorem,
                                    'information'         => $lorem,
                                    'price'               => $price,
                                    'sku'                 => $sku,
                                    'weight'              => $weight,
                                    'stock'               => $stock,
                                    'image'               => $mainImage,
                                    'stock_status'        => $stock_status,
                                    'status'              => $status,
                                ]
                            );

                            // ----------------------------
                            // ADDITIONAL IMAGES
                            // ----------------------------
                            // Simulate additional image uploads.
                            $numAdditionalImages = rand(1, 2);
                            for ($j = 0; $j < $numAdditionalImages; $j++) {
                                $product->images()->create([
                                    'image_path' => 'assets/images/fff.png'
                                ]);
                            }

                            // ----------------------------
                            // PRODUCT OPTIONS & OPTION VALUES
                            // ----------------------------
                            // Create 2 or 3 product options.
                            $numOptions = rand(2, 3);
                            for ($opt = 0; $opt < $numOptions; $opt++) {
                                $optionName = 'Option ' . ($opt + 1);
                                $optionImage = 'assets/images/fff.png';

                                $productOption = $product->options()->updateOrCreate(
                                    ['id' => null],
                                    [
                                        'merchant_id' => $product->merchant_id,
                                        'name'        => $optionName,
                                        'image_path'  => $optionImage,
                                    ]
                                );

                                // For each option, create 4 to 5 option values.
                                $numOptionValues = rand(4, 5);
                                for ($val = 0; $val < $numOptionValues; $val++) {
                                    $valueName = 'Value ' . ($val + 1);
                                    $valueImage = 'assets/images/fff.png';
                                    $optionValueStock = rand(20, 40);

                                    $productOption->values()->updateOrCreate(
                                        ['id' => null],
                                        [
                                            'merchant_id'      => $product->merchant_id,
                                            'product_id'       => $product->id,
                                            'value'            => $valueName,
                                            'additional_price' => null,
                                            'stock'            => $optionValueStock,
                                            'image_path'       => $valueImage,
                                        ]
                                    );
                                }
                            }

                            // ----------------------------
                            // ASSOCIATE CATEGORIES & SUBCATEGORIES
                            // ----------------------------
                            // Sync the product with its parent category and subcategory.
                            $product->categories()->sync([$category->id]);
                            $product->sub_categories()->sync([$subCategory->id]);

                            // Tags are not specified for dummy data.
                            // $product->tags()->sync([]);

                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            throw $e;
                        }
                    }
                }
            }
        }
    }
}
