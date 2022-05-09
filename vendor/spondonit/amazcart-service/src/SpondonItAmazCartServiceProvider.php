<?php

namespace SpondonIt\AmazCartService;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Storage;
use SpondonIt\AmazCartService\Middleware\AmazCartService;
use Modules\ModuleManager\Entities\InfixModuleManager;

class SpondonItAmazCartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(AmazCartService::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'amazcart');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amazcart');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if(Storage::exists('.app_installed') && Storage::get('.app_installed')){
            app()->singleton('ModuleList', function() {
                return InfixModuleManager::all();
            });
        }
    }
}
