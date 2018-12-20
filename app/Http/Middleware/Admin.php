<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next = null , $guard = null)
    {
        if (auth()->guard($guard)->check()) {
            return $next($request);
        }else{
            return redirect('admin/login');
        }
    }
}
