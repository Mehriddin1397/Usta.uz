<?php

namespace Tests\Unit;

use App\Models\Master;
use App\Models\Review;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_belongs_to_user(): void
    {
        $user = User::factory()->master()->create();
        $master = Master::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $master->user->id);
        $this->assertEquals($user->name, $master->user->name);
    }

    public function test_master_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $master = Master::factory()->create(['category_id' => $category->id]);

        $this->assertEquals($category->id, $master->category->id);
        $this->assertEquals($category->name, $master->category->name);
    }

    public function test_master_can_update_rating(): void
    {
        $master = Master::factory()->create(['rating' => 0, 'reviews_count' => 0]);
        
        // Create some reviews
        Review::factory()->create(['master_id' => $master->id, 'rating' => 5]);
        Review::factory()->create(['master_id' => $master->id, 'rating' => 4]);
        Review::factory()->create(['master_id' => $master->id, 'rating' => 3]);

        $master->updateRating();

        $this->assertEquals(3, $master->reviews_count);
        $this->assertEquals(4.0, $master->rating);
    }

    public function test_approved_scope_filters_approved_masters(): void
    {
        Master::factory()->approved()->count(3)->create();
        Master::factory()->pending()->count(2)->create();

        $approvedMasters = Master::approved()->get();

        $this->assertEquals(3, $approvedMasters->count());
        foreach ($approvedMasters as $master) {
            $this->assertTrue($master->is_approved);
        }
    }

    public function test_in_region_scope_filters_by_region(): void
    {
        $region1 = \App\Models\Region::factory()->create();
        $region2 = \App\Models\Region::factory()->create();

        $user1 = User::factory()->create(['region_id' => $region1->id]);
        $user2 = User::factory()->create(['region_id' => $region2->id]);

        $master1 = Master::factory()->create(['user_id' => $user1->id]);
        $master2 = Master::factory()->create(['user_id' => $user2->id]);

        $mastersInRegion1 = Master::inRegion($region1->id)->get();

        $this->assertEquals(1, $mastersInRegion1->count());
        $this->assertEquals($master1->id, $mastersInRegion1->first()->id);
    }
}
