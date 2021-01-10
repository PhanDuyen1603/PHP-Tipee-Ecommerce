<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class CustomCKFinderAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard($guard)->guest()) {
            config(['ckfinder.authentication' => function() use ($request) {
                return true;
            }] );
        } else {
            config(['ckfinder.authentication' => function() use ($request) {
                return false;
            }] );
        }

        return $next($request);
    }
}
