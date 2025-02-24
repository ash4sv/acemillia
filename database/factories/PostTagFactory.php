<?php

namespace Database\Factories;

use App\Models\Admin\Blog\PostTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostTagFactory extends Factory
{
    protected $model = PostTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined list of marketing-related tag names
        static $tags = [
            'Marketing Strategy',
            'Digital Marketing',
            'SEO Optimization',
            'Brand Management',
            'Market Analysis',
            'Content Marketing',
            'Social Media Trends',
            'Advertising Campaigns',
            'Product Launch',
            'Customer Engagement',
        ];

        $name = array_shift($tags) ?? $this->faker->words(2, true);
        $createdAt = $this->faker->dateTimeBetween('2024-06-01', '2025-01-31');

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => '<p>This tag covers ' . $name . ', combining pharmaceutical expertise with innovative marketing approaches.</p>',
            'image'       => 'https://via.placeholder.com/1500x698?text=' . urlencode($name) . '&rand=' . random_int(1, 1000),
            'status'      => 'active',
            'created_at'  => $createdAt,
            'updated_at'  => $createdAt,
        ];
    }
}
