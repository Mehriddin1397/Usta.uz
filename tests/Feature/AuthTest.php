<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $region = Region::factory()->create();
        
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'region_id' => $region->id,
            'user_type' => 'user',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    public function test_new_masters_can_register(): void
    {
        $region = Region::factory()->create();
        $category = Category::factory()->create();
        
        $response = $this->post('/register', [
            'name' => 'Test Master',
            'email' => 'master@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'region_id' => $region->id,
            'user_type' => 'master',
            'category_id' => $category->id,
            'description' => 'Test master description',
            'experience_years' => 5,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
        
        $user = User::where('email', 'master@example.com')->first();
        $this->assertNotNull($user->master);
        $this->assertFalse($user->master->is_approved);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
