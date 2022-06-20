<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;


class AdminRedirectlf
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
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        if(!session('auth')){
            return redirect()->route('login_page');
        }

        if(session('role') != 'admin'){
            return redirect()->route('login_page');
        }

        return $next($request);
    }
}
