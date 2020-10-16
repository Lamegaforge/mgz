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

        return View::make('home.login', [
            'authorization_url' => $authorizationUrl,
        ]);
    }

    public function consume(ConsumeOauthRequest $request)
    {
        app(OauthManager::class)->driver('vertisan')->checkAuthorizationToken($request->get('state'));

        $attributes = app(OauthManager::class)->driver('vertisan')->consume($request->get('code'));

        $user = app(AuthentificationService::class)->getUser($attributes);

        Auth::login($user);

        $request->session()->flash('info', 'welcome asshole');

        return Redirect::route('home');
    }
}
