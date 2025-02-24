<?php

namespace Database\Seeders;

use App\Models\Admin\MenuSetup;
use App\Models\Shop\Category;
use App\Models\Shop\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MenuSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        MenuSetup::truncate();
        Category::truncate();
        SubCategory::truncate();
        DB::table('category_relations')->truncate();
        DB::table('sub_category_relations')->truncate();
        Schema::enableForeignKeyConstraints();

        $menuSetups = [
            [
                'name' => 'Pharmaceuticals',
                'status' => 'active',
                'categories' => [
                    [
                        'name' => 'Pharmaceuticals',
                        'status' => 'active',
                        'sub_categories' => [
                            [
                                'name' => 'Isolation wear',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Face masks',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Face masks accessories',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Face shield/goggles',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Sanitizations/sterilizations/disinfectants',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Oxygen concentrator devices',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Gloves',
                                'status' => 'active',
                            ],
                        ],
                    ],
                    [
                        'name' => 'First Aid Kit',
                        'status' => 'active',
                        'sub_categories' => [
                            [
                                'name' => 'Abs plastic',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'As transparent plastic',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Pvc',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Soft transparent pvc',
                                'status' => 'active',
                            ],
                        ]
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
                            [
                                'name' => 'Laptop backpack',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Backpack',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Food delivery bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Sling cooler bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Multipurpose duffel bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Travelling bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Multipurpose bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Toiletry bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq clutch bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq multipurpose pouch',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq comfort pillow',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq casual carrier',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq business traveller bag',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Batiq laptop back pack',
                                'status' => 'active',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Apparel',
                        'status' => 'active',
                        'sub_categories' => [
                            [
                                'name' => 'Soft transparent pvc',
                                'status' => 'active',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Souvenir',
                        'status' => 'active',
                        'sub_categories' => [
                            [
                                'name' => 'Soft transparent pvc',
                                'status' => 'active',
                            ],
                        ]
                    ],
                ],
            ],
        ];

        // Wrap the seeding process in a transaction for atomicity
        DB::beginTransaction();
        try {
            foreach ($menuSetups as $menuSetupData) {
                // Create or update the menu setup
                $menu = MenuSetup::updateOrCreate(
                    ['name' => $menuSetupData['name']],
                    [
                        'slug'   => Str::slug($menuSetupData['name']),
                        'status' => $menuSetupData['status']
                    ]
                );

                foreach ($menuSetupData['categories'] as $categoryData) {
                    Log::info(['category' => $categoryData]);
                    // Create or update the category
                    $category = Category::updateOrCreate(
                        ['name' => $categoryData['name']],
                        [
                            'slug'   => Str::slug($categoryData['name']),
                            'status' => $categoryData['status']
                        ]
                    );

                    // Sync the many-to-many relationship between menu and category
                    // Using syncWithoutDetaching so that multiple menus can share categories without overwriting relationships
                    $menu->categories()->syncWithoutDetaching($category->id);

                    foreach ($categoryData['sub_categories'] as $subCategoryData) {
                        Log::info(['subCategory' => $subCategoryData]);
                        // Create or update the subcategory
                        $subCategory = SubCategory::updateOrCreate(
                            ['name' => $subCategoryData['name']],
                            [
                                'slug'   => Str::slug($subCategoryData['name']),
                                'status' => $subCategoryData['status']
                            ]
                        );

                        // Sync the many-to-many relationship between category and subcategory
                        $subCategory->categories()->sync($category->id);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error seeding menu data: ' . $e->getMessage());
        }
    }
}
