<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Validation\ValidationException;

class ProhibitedInDemoMode
{
    /**
     * Restric action if test mode is turned on.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
     
        if (env('APP_SYNC')) {
            if(($request->is('account/*') || $request->is('account')) && $request->ajax()){
                throw ValidationException::withMessages([
                    'message' => __('common.restricted_in_demo_mode')
                ]);
            }
            if ($request->ajax()) {
                return response()->json(['error' => __('common.restricted_in_demo_mode')], 422);
            }

            Toastr::error(__('common.restricted_in_demo_mode'));
            return back();
        }

        return $next($request);
    }
}
