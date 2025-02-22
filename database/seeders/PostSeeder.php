<?php

namespace Database\Seeders;

use App\Models\Admin\Blog\Post;
use App\Models\Admin\Blog\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        Schema::enableForeignKeyConstraints();

        $posts = Post::factory()->count(50)->create();

        // Retrieve all post tags
        $allTags = PostTag::all();

        // Attach 1 to 3 random tags to each post (many-to-many relationship)
        foreach ($posts as $post) {
            $tagIds = $allTags->random(rand(1, 3))->pluck('id')->toArray();
            $post->tags()->attach($tagIds);
        }
    }
}
