<?php

namespace SpondonIt\AmazCartService\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use SpondonIt\Service\Repositories\InitRepository as ServiceRepository;
use SpondonIt\AmazCartService\Repositories\InitRepository;

class AmazCartService
{
    protected $repo, $service_repo;

    public function __construct(
        InitRepository $repo,
        ServiceRepository $service_repo
    ) {
        $this->repo = $repo;
        $this->service_repo = $service_repo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->repo->init();
        
        $this->service_repo->init();

        if($this->inExceptArray($request)){
            return $next($request);
        }

       $temp = Storage::exists('.temp_app_installed') ? Storage::get('.temp_app_installed') : false;
        
        if (!$temp) {
            $database = $this->service_repo->checkDatabase();
            $logout = Storage::exists('.logout') ? Storage::get('.logout') : false;
            
            if (!$database and !$logout) {
                Log::info($request->url());
                Log::info('Table not found');
                Storage::put('.logout', 'true');
                Storage::delete(['.access_code', '.account_email']);
                Storage::put('.app_installed', '');
            }
        }

        $c = Storage::exists('.app_installed') ? Storage::get('.app_installed') : false;
        if (!$c) {
            return redirect('/install');
        }

        $this->repo->config();

        return $next($request);


    }

      /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'install', 'install/*'
    ];

    protected function inExceptArray($request)
    {

        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
