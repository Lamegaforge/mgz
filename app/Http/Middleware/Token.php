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
        $appToken = Config::get('app.token');

        if ($request->header('token') != $appToken || ! $appToken) {
            throw new Exception();
        }
    }
}
