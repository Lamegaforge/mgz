<?php

namespace Tests\Unit;

use Config;
use Tests\TestCase;
use App\Models\User;
use App\Services\AuthorityService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class AuthorityServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_with_privileged_user()
    {
        $user = User::factory()->create();

        Config::set('authority.privileged', [
            $user->tracking_id,  
        ]);

        $can = app(AuthorityService::class)->can($user, 'can_reject_clip');

        $this->assertTrue($can);
    }

    /**
     * @test
     */
    public function can()
    {
        $user = User::factory()->create();

        Config::set('authority.can_reject_clip', [
            $user->tracking_id,  
        ]);

        $can = app(AuthorityService::class)->can($user, 'can_reject_clip');

        $this->assertTrue($can);
    }

    /**
     * @test
     */
    public function cannot()
    {
        $user = User::factory()->create();

        Config::set('authority.can_reject_clip', $empty = []);

        $can = app(AuthorityService::class)->can($user, 'can_reject_clip');

        $this->assertFalse($can);
    }
}
