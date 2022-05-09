<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Session;

class CustomerMiddleware
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
        if(auth()->check() && auth()->user()->role->type == 'customer' &&
         app('business_settings')->where('type', 'email_verification')->first()->status == 1 && auth()->user()->is_verified == 0 && auth()->user()->email != null){
            return redirect('/user-email-verify');
        }
        return $next($request);
    }
}
