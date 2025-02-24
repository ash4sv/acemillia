<?php

namespace Database\Factories;

use App\Models\Admin\Blog\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostCategoryFactory extends Factory
{
    protected $model = PostCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined list of real category names
        static $categories = [
            'Innovations',
            'Drug Research',
            'Clinical Trials',
            'Biotechnology',
            'Medical Devices',
            'Pharmacovigilance',
            'Regulatory Affairs',
            'Manufacturing',
            'Generic Drugs',
            'Prescription Trends',
        ];

        $name = array_shift($categories) ?? $this->faker->words(2, true);
        // Generate a date between June 1, 2024 and January 31, 2025
        $createdAt = $this->faker->dateTimeBetween('2024-06-01', '2025-01-31');

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => '<p>This category focuses on ' . $name . ' and highlights real-world developments in both pharmaceuticals and marketing.</p>',
            'image'       => 'https://via.placeholder.com/1500x698?text=' . urlencode($name) . '&rand=' . random_int(1, 1000),
            'status'      => 'active',
            'created_at'  => $createdAt,
            'updated_at'  => $createdAt,
        ];
    }
}
