<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'difficulty' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'description' => $this->faker->sentence(),
            'is_active' => true
        ];
    }
}
