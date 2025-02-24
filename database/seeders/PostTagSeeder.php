<?php

namespace Database\Seeders;

use App\Models\Admin\Blog\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PostTag::truncate();
        Schema::enableForeignKeyConstraints();

        PostTag::factory()->count(10)->create();
    }
}
