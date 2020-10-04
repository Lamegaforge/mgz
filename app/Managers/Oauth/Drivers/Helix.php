<?php

namespace App\Managers\Oauth\Drivers;

use Session;
use Exception;
use App\Managers\Oauth\Contracts\Driver;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Helix implements Driver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function checkAuthorizationToken(string $token)
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

    public function consume(string $code): ResourceOwnerInterface
    {
        $client = $this->getClient();

        $accessToken = $client->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        return $client->getResourceOwner($accessToken);
    }

    protected function getClient(): GenericProvider
    {
        // dd($this->config);

        return new GenericProvider([
            'clientId' => $this->config['client_id'],
            'clientSecret' => $this->config['client_secret'],
            'redirectUri' => $this->config['redirect_uri'],
            'urlAuthorize' => $this->config['url_authorize'],
            'urlAccessToken' => $this->config['url_access_token'],
            'urlResourceOwnerDetails' => $this->config['url_resource_owner_details'],
        ]);        
    }

    protected function saveAuthorizationToken(GenericProvider $client)
    {
        Session::put('oauth_authorization_token', $client->getState());
    }
}
