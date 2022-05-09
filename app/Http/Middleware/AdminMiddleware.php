<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AdminMiddleware
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
        if (Auth::check() && (Auth::user()->role->type == 'superadmin' || Auth::user()->role->type == 'admin' || Auth::user()->role->type == 'staff')) {
            return $next($request);
        }
        else{
            abort(404);
        }
    }
}
