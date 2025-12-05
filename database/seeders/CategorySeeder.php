<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Basic Vocabulary',
                'slug' => 'basic-vocabulary',
                'difficulty' => 'beginner',
                'description' => 'Essential words for everyday communication'
            ],
            [
                'name' => 'Travel & Tourism',
                'slug' => 'travel-tourism',
                'difficulty' => 'beginner',
                'description' => 'Words useful for traveling and tourism'
            ],
            [
                'name' => 'Business English',
                'slug' => 'business-english',
                'difficulty' => 'intermediate',
                'description' => 'Professional vocabulary for business contexts'
            ],
            [
                'name' => 'Academic Vocabulary',
                'slug' => 'academic-vocabulary',
                'difficulty' => 'advanced',
                'description' => 'Advanced words for academic and formal writing'
            ],
            [
                'name' => 'Food & Dining',
                'slug' => 'food-dining',
                'difficulty' => 'beginner',
                'description' => 'Vocabulary related to food, cooking, and dining'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}