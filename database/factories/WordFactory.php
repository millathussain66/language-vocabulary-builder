<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory
{
    protected $model = Word::class;

    public function definition(): array
    {
        $difficulties = ['beginner', 'intermediate', 'advanced'];
        
        return [
            'category_id' => Category::factory(),
            'word' => $this->faker->word(),
            'meaning' => $this->faker->sentence(),
            'pronunciation' => $this->faker->word() . ' ' . $this->faker->word(),
            'example_sentence' => $this->faker->sentence(),
            'difficulty' => $this->faker->randomElement($difficulties),
            'language' => 'english',
            'is_active' => true,
        ];
    }
}