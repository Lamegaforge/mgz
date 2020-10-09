<?php

namespace App\Http\Controllers\Web;

use Auth;
use View;
use Redirect;
use App\Managers\Oauth\OauthManager;
use App\Http\Controllers\Controller;
use App\Services\AuthentificationService;
use App\Http\Requests\Web\ConsumeOauthRequest;

class OauthController extends Controller
{
    public function login()
    {
        $authorizationUrl = app(OauthManager::class)->driver('vertisan')->getAuthorizationUrl();

        return Redirect::to($authorizationUrl);
    }

    public function consume(ConsumeOauthRequest $request)
    {
        app(OauthManager::class)->driver('vertisan')->checkAuthorizationToken($request->get('state'));

        $resourceOwner = app(OauthManager::class)->driver('vertisan')->consume($request->get('code'));

        $user = app(AuthentificationService::class)->getUserByResource($resourceOwner);

        Auth::login($user);

        return Redirect::route('home');
    }
}
