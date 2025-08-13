<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Master;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_create_order(): void
    {
        $user = User::factory()->create();
        $master = Master::factory()->approved()->create();

        $response = $this->actingAs($user)
            ->post(route('orders.store', $master), [
                'description' => 'Test order description'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'master_id' => $master->id,
            'description' => 'Test order description',
            'status' => 'pending'
        ]);
    }

    public function test_user_cannot_create_order_for_unapproved_master(): void
    {
        $user = User::factory()->create();
        $master = Master::factory()->pending()->create();

        $response = $this->actingAs($user)
            ->post(route('orders.store', $master), [
                'description' => 'Test order description'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_user_can_view_their_orders(): void
    {
        $user = User::factory()->create();
        $orders = Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('orders.index'));

        $response->assertStatus(200);
        foreach ($orders as $order) {
            $response->assertSee($order->description);
        }
    }

    public function test_user_can_review_completed_order(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->completed()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->post(route('orders.review.store', $order), [
                'rating' => 5,
                'comment' => 'Excellent work!'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'user_id' => $user->id,
            'master_id' => $order->master_id,
            'rating' => 5,
            'comment' => 'Excellent work!'
        ]);
    }

    public function test_user_cannot_review_non_completed_order(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->pending()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->post(route('orders.review.store', $order), [
                'rating' => 5,
                'comment' => 'Excellent work!'
            ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_review_order_twice(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->completed()->create(['user_id' => $user->id]);
        Review::factory()->create(['order_id' => $order->id]);

        $response = $this->actingAs($user)
            ->post(route('orders.review.store', $order), [
                'rating' => 5,
                'comment' => 'Excellent work!'
            ]);

        $response->assertStatus(403);
    }
}
