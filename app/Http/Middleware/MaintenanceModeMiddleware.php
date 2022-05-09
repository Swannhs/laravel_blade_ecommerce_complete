<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Modules\GeneralSetting\Entities\GeneralSetting;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $maintain = GeneralSetting::select('maintenance_status',
                    'maintenance_title', 'maintenance_subtitle', 'maintenance_banner'
                )->first();
        if ($maintain->maintenance_status == 1) {
            if(auth()->check()){
                if(auth()->user()->role->type == 'superadmin' || auth()->user()->role->type == 'admin' || auth()->user()->role->type == 'staff'){
                    return $next($request);
                }else{
                    return new response(view(theme('pages.maintenance'), compact('maintain')));
                }
            }
            else{
                return new response(view(theme('pages.maintenance'), compact('maintain')));
            }
        }
        return $next($request);
    }
}
