<?php

namespace App\Managers\Oauth\Drivers;

use Session;
use Exception;
use App\Managers\Oauth\Contracts\Driver;
use Vertisan\OAuth2\Client\Provider\TwitchHelix;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Vertisan implements Driver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function checkAuthorizationToken(string $token): void
    {
        $trustedToken = Session::get('oauth_authorization_token');

        throw_unless($trustedToken, Exception::class);
        throw_unless($trustedToken === $token, Exception::class);
    }

    public function getAuthorizationUrl(): string
    {
        $client = $this->getClient();

        $authorizationUrl = $client->getAuthorizationUrl();

        $this->saveAuthorizationToken($client);

        return $authorizationUrl;
    }

    public function consume(string $code): array
    {
        $client = $this->getClient();

        $accessToken = $client->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        $resourceOwner = $client->getResourceOwner($accessToken);

        $content = $resourceOwner->toArray();

        return [
            'tracking_id' => $content['id'],
            'login' => $content['login'],
            'display_name' => $content['display_name'],
            'profile_image_url' => $content['profile_image_url'],
            'email' => $content['email'],
        ];
    }

    protected function getClient(): TwitchHelix
    {
        return new TwitchHelix([
            'clientId' => $this->config['client_id'],
            'clientSecret' => $this->config['client_secret'],
            'redirectUri' => $this->config['redirect_uri'],
        ]);
    }

    protected function saveAuthorizationToken($client): void
    {
        Session::put('oauth_authorization_token', $client->getState());
    }    
}
