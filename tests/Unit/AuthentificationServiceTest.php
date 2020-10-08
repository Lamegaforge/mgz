<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthentificationService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class AuthentificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_user_by_resource()
    {
        $resourceOwner = new class() implements ResourceOwnerInterface {

            public function getId()
            {
                //
            }

            public function toArray()
            {
                return [
                    'id' => '1',
                    'login' => 'aloy',
                    'display_name' => 'Aloy',
                    'profile_image_url' => 'url',
                    'email' => 'email',
                ];
            }
        };

        $user = app(AuthentificationService::class)->getUserByResource($resourceOwner);

        $this->assertInstanceOf(User::class, $user);
    }
}
