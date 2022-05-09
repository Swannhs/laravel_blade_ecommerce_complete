<?php

namespace SpondonIt\Service\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SpondonIt\Service\Repositories\InitRepository as ServiceRepository;
use Illuminate\Support\Facades\Storage;

class ServiceMiddleware
{
    protected $repo, $service_repo;

    public function __construct(
        ServiceRepository $service_repo
    ) {
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
        $logout = Storage::exists('.logout') && Storage::get('.logout');
        if ($logout) {
            $request->session()->flush();
            Storage::delete('.logout');
            return redirect('/install');
        }

        if (Auth::check() and Auth::user()->role_id == 1) {
            $this->service_repo->check();
        }

        return $next($request);
    }
}
