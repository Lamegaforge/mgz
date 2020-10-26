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

            $requestToken = $this->getRequestToken($request);

            $appToken = $this->getAppToken();
            
            if ($requestToken != $appToken) {
                throw new Exception();
            }

        } catch (Exception $e) {
            return App::abort(403);
        }

        return $next($request);
    }

    protected function getRequestToken(Request $request): string
    {
        $token = $request->token;

        if (! $request->expectsJson() || ! $token) {
            throw new Exception();
        }

        return $token;
    }

    protected function getAppToken(): string
    {
        $appToken = Config::get('app.token');

        if (! $appToken || $appToken == '') {
            throw new Exception();
        }

        return $appToken;
    }
}
