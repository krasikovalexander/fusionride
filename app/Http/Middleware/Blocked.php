<?php

namespace App\Http\Middleware;

use Closure;

class Blocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (config()->get("app.blocked_mode")) {
            return redirect('/demo');
        }

        return $next($request);
    }
}
