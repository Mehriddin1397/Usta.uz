<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Master;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory()->completed(),
            'user_id' => User::factory(),
            'master_id' => Master::factory()->approved(),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->paragraph(1),
            'media_paths' => null,
        ];
    }

    /**
     * Indicate that the review has media.
     */
    public function withMedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'media_paths' => [
                'reviews/review1.jpg',
                'reviews/review2.jpg',
            ],
        ]);
    }

    /**
     * Indicate that the review has high rating.
     */
    public function highRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 5,
        ]);
    }

    /**
     * Indicate that the review has low rating.
     */
    public function lowRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
        ]);
    }
}
