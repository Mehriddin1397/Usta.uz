<?php

namespace Database\Factories;

use App\Models\Master;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'master_id' => Master::factory()->approved(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'media_paths' => null,
        ];
    }

    /**
     * Indicate that the work has media.
     */
    public function withMedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'media_paths' => [
                'works/sample1.jpg',
                'works/sample2.jpg',
            ],
        ]);
    }
}
