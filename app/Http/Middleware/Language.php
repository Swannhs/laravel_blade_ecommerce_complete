<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Language
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
        if(\Session::has('locale')){
            $lang = \Modules\Language\Entities\Language::where('code', \Session::get('locale'))->first();
            if($lang){
                \App::setlocale(\Session::get('locale'));
            }else{
                \Session::forget('locale');
            }

        }
        if(auth()->check()){
            \App::setlocale(auth()->user()->lang_code);
        }
        elseif(\App::bound('general_setting')){
            \App::setlocale(app('general_setting')->language_code);
        }
        else{
            \App::setlocale('en');
        }
        return $next($request);
    }
}
