<?php

namespace Database\Factories;

use App\Models\Admin\Blog\Post;
use App\Models\Admin\Blog\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined list of 20 post titles
        static $titles = [
            'The Future of Pharmaceutical Innovations',
            'Emerging Trends in Drug Research',
            'Clinical Trials: Navigating Challenges',
            'Advances in Biotechnology and Their Impact',
            'Medical Devices: Safety and Efficiency',
            'Pharmacovigilance in a Global Market',
            'Understanding Regulatory Affairs in Pharma',
            'Manufacturing Excellence in Pharmaceuticals',
            'The Rise of Generic Drugs',
            'Analyzing Prescription Trends in 2025',
            'Digital Strategies in Pharmaceutical Marketing',
            'Optimizing Brand Management in Healthcare',
            'Leveraging Social Media for Drug Awareness',
            'Content Marketing Best Practices for Pharma',
            'Innovative Advertising Campaigns in Medicine',
            'Market Analysis in a Changing Pharmaceutical Landscape',
            'The Role of SEO in Health Product Promotion',
            'Product Launch Success Stories in Pharma',
            'Engaging Customers in the Digital Age',
            'Integrated Marketing Strategies for Medical Devices',
        ];

        $title = array_shift($titles) ?? $this->faker->sentence;
        // Fixed paragraphs with real language
        $paragraphs = [
            'In the rapidly evolving world of pharmaceuticals, innovation drives the industry forward.',
            'Research and development have become cornerstones of successful drug discovery and improved patient care.',
            'Clinical trials and strict regulatory compliance ensure that new therapies are both safe and effective.',
            'Marketing strategies in the pharmaceutical sector focus on building trust and educating consumers.',
            'Digital tools and social media have transformed the way healthcare professionals and companies communicate.',
            'Continued investment in biotechnology and data analytics is paving the way for a healthier and more informed future.',
        ];
        $body = '<p>' . implode('</p><p>', $paragraphs) . '</p>';
        $createdAt = $this->faker->dateTimeBetween('2024-06-01', '2025-01-31');

        return [
            'admin_id'         => 2,
            // Randomly assign an existing category (ensure PostCategorySeeder is run first)
            'post_category_id' => PostCategory::inRandomOrder()->first()->id,
            'title'            => $title,
            'slug'             => Str::slug($title),
            'body'             => $body,
            'banner'           => 'assets/images/blog/1.jpg',
            'status'           => 'active',
            'created_at'       => $createdAt,
            'updated_at'       => $createdAt,
        ];
    }
}
