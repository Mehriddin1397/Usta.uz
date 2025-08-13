<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Master;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_can_approve_master(): void
    {
        $admin = User::factory()->admin()->create();
        $master = Master::factory()->pending()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.masters.approve', $master));

        $response->assertRedirect();
        $this->assertDatabaseHas('masters', [
            'id' => $master->id,
            'is_approved' => true
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $master->user_id,
            'role' => 'master'
        ]);
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Test Category',
                'description' => 'Test category description'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'description' => 'Test category description'
        ]);
    }

    public function test_admin_can_create_region(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.regions.store'), [
                'name' => 'Test Region'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('regions', [
            'name' => 'Test Region'
        ]);
    }

    public function test_admin_can_view_users(): void
    {
        $admin = User::factory()->admin()->create();
        $users = User::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get(route('admin.users'));

        $response->assertStatus(200);
        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    public function test_admin_can_view_pending_masters(): void
    {
        $admin = User::factory()->admin()->create();
        $pendingMasters = Master::factory()->pending()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.masters.pending'));

        $response->assertStatus(200);
        foreach ($pendingMasters as $master) {
            $response->assertSee($master->user->name);
        }
    }
}
