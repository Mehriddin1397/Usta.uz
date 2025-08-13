<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = [
            'Toshkent shahri',
            'Toshkent viloyati',
            'Samarqand viloyati',
            'Buxoro viloyati',
            'Andijon viloyati',
            'Farg\'ona viloyati',
            'Namangan viloyati',
            'Qashqadaryo viloyati',
            'Surxondaryo viloyati',
            'Navoiy viloyati',
            'Jizzax viloyati',
            'Sirdaryo viloyati',
            'Xorazm viloyati',
            'Qoraqalpog\'iston Respublikasi'
        ];

        return [
            'name' => fake()->randomElement($regions),
        ];
    }
}
