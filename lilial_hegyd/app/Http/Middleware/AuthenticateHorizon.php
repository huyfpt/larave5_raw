<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Horizon\Horizon;

class AuthenticateHorizon
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Horizon::auth(function ($request) {
            if (in_array(config('app.env'), ['local', 'dev']))
            {
                return true;
            } elseif ($user = $request->user())
            {
                return $user->hasRole('super_admin');
            }

            return false;
        });

        return $next($request);
    }
}
