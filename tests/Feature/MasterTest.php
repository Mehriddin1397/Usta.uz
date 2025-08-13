<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Master;
use App\Models\Category;
use App\Models\Region;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MasterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_master_profile_can_be_viewed(): void
    {
        $master = Master::factory()->create(['is_approved' => true]);

        $response = $this->get(route('masters.show', $master));

        $response->assertStatus(200);
        $response->assertSee($master->user->name);
        $response->assertSee($master->category->name);
    }

    public function test_authenticated_master_can_access_dashboard(): void
    {
        $master = Master::factory()->create(['is_approved' => true]);

        $response = $this->actingAs($master->user)->get(route('master.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Usta Dashboard');
    }

    public function test_non_master_cannot_access_master_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('master.dashboard'));

        $response->assertStatus(403);
    }

    public function test_master_can_create_work(): void
    {
        $master = Master::factory()->create(['is_approved' => true]);

        $response = $this->actingAs($master->user)->post(route('master.works.store'), [
            'title' => 'Test Work',
            'description' => 'Test work description',
        ]);

        $response->assertRedirect(route('master.dashboard'));
        $this->assertDatabaseHas('works', [
            'master_id' => $master->id,
            'title' => 'Test Work',
        ]);
    }

    public function test_master_can_accept_order(): void
    {
        $master = Master::factory()->create(['is_approved' => true]);
        $order = Order::factory()->create([
            'master_id' => $master->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($master->user)
            ->post(route('master.orders.accept', $order));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'accepted'
        ]);
    }

    public function test_master_can_complete_order(): void
    {
        $master = Master::factory()->create(['is_approved' => true]);
        $order = Order::factory()->create([
            'master_id' => $master->id,
            'status' => 'accepted'
        ]);

        $response = $this->actingAs($master->user)
            ->post(route('master.orders.complete', $order), [
                'completion_notes' => 'Work completed successfully'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
            'completion_notes' => 'Work completed successfully'
        ]);
    }

    public function test_master_cannot_accept_other_masters_order(): void
    {
        $master1 = Master::factory()->create(['is_approved' => true]);
        $master2 = Master::factory()->create(['is_approved' => true]);
        $order = Order::factory()->create([
            'master_id' => $master2->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($master1->user)
            ->post(route('master.orders.accept', $order));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending'
        ]);
    }
}
