<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use App\Models\Master;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create regions
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

        foreach ($regions as $regionName) {
            Region::create(['name' => $regionName]);
        }

        // Create categories
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

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@usta.uz',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'region_id' => 1,
        ]);

        // Create sample users and masters
        $toshkentRegion = Region::where('name', 'Toshkent shahri')->first();
        $qurilishCategory = Category::where('name', 'Qurilish')->first();
        $elektrikCategory = Category::where('name', 'Elektrik')->first();

        // Sample master 1
        $user1 = User::create([
            'name' => 'Akmal Karimov',
            'email' => 'akmal@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234567',
            'role' => 'master',
            'region_id' => $toshkentRegion->id,
        ]);

        Master::create([
            'user_id' => $user1->id,
            'category_id' => $qurilishCategory->id,
            'description' => '10 yillik tajribaga ega qurilish ustasi. Uy qurilishi va ta\'mirlash ishlarini sifatli bajaraman.',
            'experience_years' => 10,
            'rating' => 4.8,
            'reviews_count' => 25,
            'is_approved' => true,
        ]);

        // Sample master 2
        $user2 = User::create([
            'name' => 'Bobur Toshmatov',
            'email' => 'bobur@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234568',
            'role' => 'master',
            'region_id' => $toshkentRegion->id,
        ]);

        Master::create([
            'user_id' => $user2->id,
            'category_id' => $elektrikCategory->id,
            'description' => 'Elektrik montaj va ta\'mirlash bo\'yicha mutaxassis. Barcha turdagi elektr ishlarini bajaraman.',
            'experience_years' => 7,
            'rating' => 4.5,
            'reviews_count' => 18,
            'is_approved' => true,
        ]);

        // Sample regular user
        User::create([
            'name' => 'Dilshod Rahimov',
            'email' => 'dilshod@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234569',
            'role' => 'user',
            'region_id' => $toshkentRegion->id,
        ]);
    }
}
