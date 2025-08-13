<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Master;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_check_if_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_can_check_if_master(): void
    {
        $master = User::factory()->create(['role' => 'master']);
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($master->isMaster());
        $this->assertFalse($user->isMaster());
    }

    public function test_user_can_check_if_regular_user(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->isUser());
        $this->assertFalse($admin->isUser());
    }

    public function test_user_belongs_to_region(): void
    {
        $region = Region::factory()->create();
        $user = User::factory()->create(['region_id' => $region->id]);

        $this->assertEquals($region->id, $user->region->id);
        $this->assertEquals($region->name, $user->region->name);
    }

    public function test_user_can_have_master_profile(): void
    {
        $user = User::factory()->create(['role' => 'master']);
        $master = Master::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->master);
        $this->assertEquals($master->id, $user->master->id);
    }
}
