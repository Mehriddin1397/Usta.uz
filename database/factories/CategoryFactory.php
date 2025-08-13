<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'Qurilish', 'description' => 'Uy qurilishi, ta\'mirlash ishlari'],
            ['name' => 'Elektrik', 'description' => 'Elektr montaj va ta\'mirlash'],
            ['name' => 'Santexnik', 'description' => 'Suv va kanalizatsiya ishlari'],
            ['name' => 'Marangoz', 'description' => 'Yog\'och ishlari va mebel yasash'],
            ['name' => 'Bo\'yoqchi', 'description' => 'Devor va shift bo\'yash'],
            ['name' => 'Plitkachi', 'description' => 'Kafel va plitka yotqizish'],
            ['name' => 'Konditsioner', 'description' => 'Konditsioner o\'rnatish va ta\'mirlash'],
            ['name' => 'Avtomobil ta\'mirlash', 'description' => 'Avtomobil diagnostika va ta\'mirlash'],
        ];

        $category = fake()->randomElement($categories);

        return [
            'name' => $category['name'],
            'description' => $category['description'],
        ];
    }
}
