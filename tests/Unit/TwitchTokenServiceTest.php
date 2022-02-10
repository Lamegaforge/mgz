<?php

namespace Tests\Unit;

use Mockery;
use Closure;
use Tests\TestCase;
use App\Dtos\BearerToken;
use App\Services\TwitchTokenService;
use Illuminate\Contracts\Cache\Repository;

class TwitchTokenServiceTest extends TestCase
{
    /**
     * @test
     */
    public function expired()
    {
        $closure = function ($mock) {
            $mock
                ->shouldReceive('missing')
                ->andReturn(true);
        };

        $this->mockRepositoryCache($closure);

        $expired = app(TwitchTokenService::class)->expired();

        $this->assertTrue($expired);
    }

    /**
     * @test
     */
    public function get_bearer_token()
    {
        $closure = function ($mock) {
            $mock
                ->shouldReceive('get')
                ->andReturn('gvqzwz1sdc72w4c');
        };

        $this->mockRepositoryCache($closure);

        $bearerToken = app(TwitchTokenService::class)->get();

        $this->assertInstanceOf(BearerToken::class, $bearerToken);
        $this->assertEquals('gvqzwz1sdc72w4c', $bearerToken->value);
        $this->assertNull($bearerToken->expiresIn);
    }

    /**
     * @test
     */
    public function save_bearer_token()
    {
        $closure = function ($mock) {
            $mock
                ->shouldReceive('put')
                ->andReturn('TWITCH_BEARER_TOKEN_VALUE', 'gvqzwz1sdc72w4c', 3600);
        };

        $this->mockRepositoryCache($closure);

        $bearerToken = new BearerToken(
            value: 'gvqzwz1sdc72w4c',
            expiresIn: 3600,
        );

        app(TwitchTokenService::class)->save($bearerToken);
    }

    protected function mockRepositoryCache(Closure $closure): void
    {
        $this->instance(
            Repository::class,
            Mockery::mock(Repository::class, $closure)
        );
    }
}
