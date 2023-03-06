<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['Max', 'Charlie', 'Bella', 'Luna', 'Lily', 'Bear', 'Lola', 'Milo', 'Rocky', 'Zoe', 'Lucy']),
            'breed' => fake()->randomElement(['retriever', 'bulldog', 'German Shepherd Dog', 'Poodle', 'Scottish Fold', 'Bengal', 'Persian', 'Catfish', 'Mollies', 'Parrotlet', 'Lovebird', 'Lionhead', 'Californian']),
            'gender' => fake()->randomElement(['male', 'female']),
            'status' => fake()->randomElement(['adopting', 'giving_away']),
            'pedigree' => fake()->randomElement(['yes', 'no']),
            'birth_date' => fake()->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null),
            'color' => fake()->colorName(),
            'weight' => fake()->randomFloat($nbMaxDecimals = 2, $min = 0.5, $max = 5),
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
