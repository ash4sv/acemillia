<?php

namespace Database\Seeders;

use App\Models\Admin\CarouselSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CarouselSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CarouselSlider::truncate();
        Schema::enableForeignKeyConstraints();

        $carouselSlider = [
            [
                'image' => 'assets/upload/ffd900.png',
                'url' => '#!',
                'status' => strtoupper('active'),
            ],
            [
                'image' => 'assets/upload/ffd900.png',
                'url' => '#!',
                'status' => strtoupper('active'),
            ],
            [
                'image' => 'assets/upload/ffd900.png',
                'url' => '#!',
                'status' => strtoupper('active'),
            ],
        ];

        foreach ($carouselSlider as $carousel) {
            CarouselSlider::create(
                [
                    'image' => $carousel['image'],
                    'url' => $carousel['url'],
                    'status' => $carousel['status'],
                ]
            );
        }
    }
}
