<?php

namespace App\Http\Middleware;

use Closure;

class AllowRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $general        = gs();
        if ($general->registration == 0) {
            return to_route('registration.disabled');
        }
        return $next($request);
    }
}
