<?php

namespace Modules\Utilities\Repositories;

use App\Models\User;
use App\Traits\UploadTheme;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductTag;
use Modules\Seller\Entities\SellerProduct;
use Illuminate\Support\Facades\Hash;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Blog\Entities\BlogPost;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\ModuleManager\Entities\InfixModuleManager;
use Modules\ModuleManager\Entities\Module;
use ZipArchive;

class UtilitiesRepository
{
    use UploadTheme;
    public function updateUtility($utilities)
    {
        if ($utilities == 'optimize_clear') {
            Artisan::call('optimize:clear');

            $dirname = base_path('/bootstrap/cache/');

            if (is_dir($dirname)) {
                $dir_handle = opendir($dirname);
            } else {
                $dir_handle = false;
            }
            if (!$dir_handle)
                return false;
            while ($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname . "/" . $file))
                        unlink($dirname . "/" . $file);
                    else
                        File::deleteDirectory($dirname . '/' . $file);
                }
            }
            closedir($dir_handle);
        } elseif ($utilities == "clear_log") {
            array_map('unlink', array_filter((array)glob(storage_path('logs/*.log'))));
            array_map('unlink', array_filter((array)glob(storage_path('debugbar/*.json'))));
        } elseif ($utilities == "change_debug") {
            envu([
                'APP_DEBUG' => env('APP_DEBUG') ? "false" : "true"
            ]);
        } elseif ($utilities == "force_https") {
            envu([
                'FORCE_HTTPS' => env('FORCE_HTTPS') ? "false" : "true"
            ]);
        } elseif ($utilities == "xml_sitemap") {
        } else {
            return 'not_done';
        }
        return 'done';
    }

    public function get_xml_data($request)
    {

        if (in_array('pages', $request->sitemap)) {
            $data['pages'] = DynamicPage::all();
        }
        if (in_array('products', $request->sitemap)) {
            $data['products'] = SellerProduct::where('status', 1)->activeSeller()->get();
        }

        if (in_array('categories', $request->sitemap)) {
            $data['categories'] = Category::where('status', 1)->get();
        }

        if (in_array('brands', $request->sitemap)) {
            $data['brands'] = Brand::where('status', 1)->get();
        }

        if (in_array('blogs', $request->sitemap)) {
            $data['blogs'] = BlogPost::where('status', 1)->get();
        }

        if (in_array('tags', $request->sitemap)) {
            $data['tags'] = ProductTag::distinct()->with('tag')->get(['tag_id']);
        }
        if (in_array('flash_deal', $request->sitemap)) {
            $data['flash_deal'] = FlashDeal::where('status', 1)->first();
        }
        if (in_array('new_user_zone', $request->sitemap)) {
            $data['new_user_zone'] = NewUserZone::where('status', 1)->first();
        }
        return $data;
    }

    public function reset_database($request)
    {
        $user = DB::table('users')->where('id', 1)->first();
        $data = (array) $user;
        $data['lang_code'] = 'en';
        $data['currency_id'] = 2;
        $data['currency_code'] = "USD";
        $data['is_verified'] = 1;
        $infix_modules = InfixModuleManager::all();
        $setting = [
            'system_domain' => app('general_setting')->system_domain,
            'copyright_text' => app('general_setting')->copyright_text,
            'software_version' => app('general_setting')->software_version,
            'system_version' => app('general_setting')->system_version
        ];
        $modules = Module::all();
        Artisan::call('migrate:fresh',array('--force' => true));
        User::where('id', 1)->update($data);
        InfixModuleManager::query()->truncate();
        Module::query()->truncate();
        foreach($infix_modules as $module){
            $module = $module->toArray();
            InfixModuleManager::create($module);
            if($module['purchase_code'] != null){
                if(!Schema::hasColumn('general_settings', 'general_settings')) {
                    $name = $module['name'];
                    Schema::table('general_settings', function ($table) use ($name) {
                        $table->integer($name)->default(1)->nullable();
                    });
                }
            }
        }
        foreach($modules as $module){
            $module = $module->toArray();
            Module::create($module);
        }
        GeneralSetting::first()->update($setting);

        if(file_exists(asset_path('uploads'))){
            $this->delete_directory(asset_path('uploads'));
        }
        $zip = new ZipArchive;
        $res = $zip->open(asset_path('demo_db/reset_uploads.zip'));
        if ($res === true) {
            $zip->extractTo(storage_path('app/tempResetFile'));
            $zip->close();
        } else {
            abort(500, 'Error! Could not open File');
        }


        $src = storage_path('app/tempResetFile');
        $dst = asset_path('uploads');

        $this->recurse_copy($src, $dst);

        if(file_exists(storage_path('app/tempResetFile'))){
            $this->delete_directory(storage_path('app/tempResetFile'));
        }

        Artisan::call('optimize:clear');
        return true;

    }

    public function import_demo_database($request){
        $user = DB::table('users')->where('id', 1)->first();
        $data = (array) $user;
        $data['lang_code'] = 'en';
        $data['currency_id'] = 2;
        $data['currency_code'] = "USD";
        $data['is_verified'] = 1;
        $setting = [
            'system_domain' => app('general_setting')->system_domain,
            'copyright_text' => app('general_setting')->copyright_text,
            'software_version' => app('general_setting')->software_version,
            'system_version' => app('general_setting')->system_version
        ];
        $modules = Module::all();
        $infix_modules = InfixModuleManager::all();
        set_time_limit(2700);

        DB::statement("SET foreign_key_checks=0");

        Artisan::call('db:wipe',array('--force' => true));

        $sql = asset_path('demo_db/amazcart_demo.sql');
        DB::unprepared(file_get_contents($sql));

        DB::statement("SET foreign_key_checks=1");
        
        DB::statement("SET AUTOCOMMIT=1");
        Artisan::call('migrate',array('--force' => true));
        if(file_exists(asset_path('uploads'))){
            $this->delete_directory(asset_path('uploads'));
        }

        $zip = new ZipArchive;
        $res = $zip->open(asset_path('demo_db/demo_uploads.zip'));
        if ($res === true) {
            $zip->extractTo(storage_path('app/tempDemoFile'));
            $zip->close();
        } else {
            abort(500, 'Error! Could not open File');
        }


        $src = storage_path('app/tempDemoFile');
        $dst = asset_path('uploads');

        $this->recurse_copy($src, $dst);

        if(file_exists(storage_path('app/tempDemoFile'))){
            $this->delete_directory(storage_path('app/tempDemoFile'));
        }

        User::where('id', 1)->update($data);
        InfixModuleManager::query()->truncate();
        Module::query()->truncate();
        foreach($infix_modules as $module){
            InfixModuleManager::create([
                'name' => $module->name,
                'email' => $module->email
            ]);
        }

        foreach($modules as $module){
            $module = $module->toArray();
            Module::create($module);
        }
        GeneralSetting::first()->update($setting);
        Artisan::call('optimize:clear');
        return true;

    }
}
