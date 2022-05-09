<?php

namespace SpondonIt\Service\Repositories;
ini_set('max_execution_time', 0);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SpondonIt\Service\Repositories\InitRepository;
use Illuminate\Validation\ValidationException;
use Throwable;

class UpdateRepository
{
    protected $init;

    public function __construct(
        InitRepository $init
    ) {
        $this->init = $init;
    }

    public function download()
    {
        $info = $this->init->product();

        $product = gv($info, 'product');

        $build = $product['next_release_build'];
        $version = $product['next_release_version'];
        $update_size = $product['next_release_size'];

        if (! $version) {
            throw ValidationException::withMessages(['message' => trans('service::install.no_update_available')]);
        }

        if (! $update_size) {
            throw ValidationException::withMessages(['message' => trans('service::install.missing_update_file')]);
        }

        $ac = Storage::exists('.access_code') ? Storage::get('.access_code') : null;
        $e = Storage::exists('.account_email') ? Storage::get('.account_email') : null;
        $c = Storage::exists('.app_installed') ? Storage::get('.app_installed') : null;
        $v = Storage::exists('.version') ? Storage::get('.version') : null;

        $url = config('app.verifier').'/api/cc?a=download&u='. url('/') .'&ac='.$ac.'&i='.config('app.item').'&e='.$e.'&c='.$c.'&v='.$v;


        $zipFile = $build;

        $zipResource = fopen($zipFile, "w");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FILE, $zipResource);
        $response = curl_exec($ch);
        curl_close($ch);

        $zip = new \ZipArchive;
        if (! $zip) {
            throw ValidationException::withMessages(['message' => trans('service::install.missing_zip_extension')]);
        }

        if (! File::exists($build)) {
            throw ValidationException::withMessages(['message' => trans('service::install.missing_update_file')]);
        }

        if ($zip->open($build) === TRUE) {
            $zip->extractTo(base_path());
            $zip->close();
        } else {
            unlink($build);
            throw ValidationException::withMessages(['message' => trans('service::install.zip_file_corrupted')]);
        }


        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');

        $this->migrateDB();

        Storage::put('.version', $version);
        unlink($build);

        return ['message' => 'Product Updated Successfully'];
    }

    public function update($params)
    {
        $info = $this->init->product();

        $product = $info['product'] ?? null;

        $build = $params['build'] ?? null;
        $version = $params['version'] ?? null;


        if (! $product['next_release_version'] || $build != $product['next_release_build'] || $version != $product['next_release_version']) {
            throw ValidationException::withMessages(['message' => trans('service::install.invalid_action')]);
        }

        $zip = new \ZipArchive;
        if (! $zip) {
            throw ValidationException::withMessages(['message' => trans('service::install.missing_zip_extension')]);
        }

        if (! File::exists($build)) {
            throw ValidationException::withMessages(['message' => trans('service::install.missing_update_file')]);
        }

        if ($zip->open($build) === TRUE) {
            $zip->extractTo(base_path());
            $zip->close();
        } else {
            unlink($build);
            throw ValidationException::withMessages(['message' => trans('service::install.zip_file_corrupted')]);
        }


        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');

        $this->migrateDB();

        Storage::put('.version', $version);
        unlink($build);
    }

     /**
    * Mirage tables to database
    */
    protected function migrateDB() {
        try {
            Artisan::call('migrate', array('--force' => true));
        } catch (Throwable $e) {
            Log::info($e->getMessage());
            $sql = base_path('database/' . config('spondonit.database_file'));
            if (File::exists($sql)) {
                DB::unprepared(file_get_contents($sql));
            }

        }
   }
}
