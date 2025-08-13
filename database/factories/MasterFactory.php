<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Master>
 */
class MasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->master(),
            'category_id' => Category::factory(),
            'description' => fake()->paragraph(3),
            'experience_years' => fake()->numberBetween(1, 20),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'reviews_count' => fake()->numberBetween(0, 50),
            'is_approved' => fake()->boolean(80), // 80% chance of being approved
        ];
    }

    /**
     * Indicate that the master is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    /**
     * Indicate that the master is not approved.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
            'rating' => 0.00,
            'reviews_count' => 0,
        ]);
    }
}
