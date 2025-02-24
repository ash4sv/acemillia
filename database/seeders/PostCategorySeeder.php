<?php

namespace Database\Seeders;

use App\Models\Admin\Blog\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PostCategory::truncate();
        Schema::enableForeignKeyConstraints();

        PostCategory::factory()->count(10)->create();
    }
}
