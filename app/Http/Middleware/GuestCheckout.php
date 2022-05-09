<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Session;

class GuestCheckout
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
        if(app('general_setting')->guest_checkout || auth()->check()){
            
            if(isModuleActive('MultiVendor') || auth()->check() && auth()->user()->role->type != 'superadmin' && auth()->user()->role->type != 'admin' && auth()->user()->role->type != 'staff'){
                return $next($request);
            }elseif(auth()->check() && auth()->user()->role->type == 'superadmin' || auth()->check() && auth()->user()->role->type == 'admin' || auth()->check() && auth()->user()->role->type == 'staff'){
                Toastr::error("Checkout Not Allow for Admin.");
                return redirect(url('/'));
            }else{
                return $next($request);
            }
                
        }
        session()->put('url.intended',$request->fullUrl());
        return redirect(url('/login')); 
        
    }
}
