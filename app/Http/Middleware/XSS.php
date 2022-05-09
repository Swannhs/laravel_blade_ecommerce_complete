<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class XSS
{
    public function handle($request, Closure $next)
    {
        $inputs = $request->except(['_token','_method','code']);
        if(count($inputs) > 0 && $request->has('_token'))
        {

            foreach ($inputs as $key => $input){
                if(!is_array($input) && $input != null){
                  
                    if(str_contains($input, '<script>') || str_contains($input, '</script>') || str_contains($input, 'script')){
                        $request->merge([$key => Purifier::clean($input)]);
                    }
                }

            }
        }

        return $next($request);

    }
}
