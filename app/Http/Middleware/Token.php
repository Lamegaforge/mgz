<?php

namespace App\Http\Middleware;

use App;
use Config;
use Closure;
use Exception;
use Illuminate\Http\Request;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $this->checkAuthorization($request);
        } catch (Exception $e) {
            return App::abort(403, 'GET OUT OF HERE STALKER');
        }

        return $next($request);
    }

    protected function checkAuthorization(Request $request)
    {
        $requestToken = $this->getRequestToken($request);
        $appToken = $this->getAppToken();

        throw_if($requestToken != $appToken, Exception::class);
    }

    protected function getRequestToken(Request $request): string
    {
        $token = $request->header('token');
        $expectedJson = $request->expectsJson();

        throw_unless($token, Exception::class);
        throw_unless($expectedJson, Exception::class);

        return $token;
    }

    protected function getAppToken(): string
    {
        $appToken = Config::get('app.token');

        throw_unless($appToken, Exception::class);

        return $appToken;
    }
}
