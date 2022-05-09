<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        if (DB::connection()->getDatabaseName() != '' && Schema::hasTable('languages')){
                Cache::remember('translations', Carbon::now()->addHours(6),function () {
                    return $this->getTranslations();
                });
        }
    }


    public function getTranslations()
    {
        $translations = collect();

        $ln = DB::table('languages')->where('status',1)->orWhere('code','en')->pluck('code')->toArray();
        foreach ($ln as $locale) {
            $translations[$locale] = $this->jsonTranslations($locale) ;
        }
        return $translations;
    }


    private function jsonTranslations($lang)
    {
        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];
        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }
        

        return json_encode($strings, true);
    
    }
}