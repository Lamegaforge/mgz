<?php

namespace App\Http\Middleware;

use View;
use Closure;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class ShareViews
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
        $this->shareNotifications();

        return $next($request);
    }

    protected function shareNotifications()
    {
        $count = app(NotificationService::class)->count();

        View::share('notificationsCount', $count);
    }
}
