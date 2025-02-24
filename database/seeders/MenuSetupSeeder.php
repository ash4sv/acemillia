<?php

namespace Database\Seeders;

use App\Models\Admin\MenuSetup;
use App\Models\Shop\Category;
use App\Models\Shop\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        foreach ($menuSetups as $menuSetup) {
            $menu = MenuSetup::updateOrCreate([
                'name' => $menuSetup['name'],
                'slug' => Str::slug($menuSetup['name']),
                'status' => $menuSetup['status'],
            ]);

            foreach ($menuSetup['categories'] as $category) {
                $category = Category::updateOrCreate([
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'status' => $category['status'],
                ]);
                $category->menus()->sync($menu->id);

                foreach ($category['sub_categories'] as $subCategory) {
                    $subCategory = SubCategory::updateOrCreate([
                        'name' => $subCategory['name'],
                        'slug' => Str::slug($subCategory['name']),
                        'status' => $subCategory['status'],
                    ]);
                    $subCategory->categories()->sync($category->id);
                }
            }
        }
    }
}
