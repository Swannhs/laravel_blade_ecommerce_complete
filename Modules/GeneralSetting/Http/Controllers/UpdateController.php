<?php

namespace Modules\GeneralSetting\Http\Controllers;

use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\GeneralSetting\Entities\VersionHistory;
use Modules\UserActivityLog\Traits\LogActivity;
use ZipArchive;

class UpdateController extends Controller
{
    use UploadTheme;
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function updateSystem()
    {
        $last_update = VersionHistory::latest()->first();
        return view('generalsetting::update_system.updateSystem',compact('last_update'));
    }

    public function updateSystemSubmit(Request $request)
    {

        $request->validate([
            'updateFile' => ['required', 'mimes:zip'],
        ]);

        try {


            $this->allClear();
            $this->databaseBackup();

            if ($request->hasFile('updateFile')) {
                $path = $request->updateFile->store('updateFile');
                $request->updateFile->getClientOriginalName();
                $zip = new ZipArchive;
                $res = $zip->open(storage_path('app/' . $path));
                if ($res === true) {
                    $zip->extractTo(storage_path('app/tempUpdate'));
                    $zip->close();
                } else {
                    abort(500, 'Error! Could not open File');
                }

                $str = @file_get_contents(storage_path('app/tempUpdate/config.json'), true);
                if ($str === false) {
                    abort(500, 'The update file is corrupt.');

                }

                $json = json_decode($str, true);

                if (!empty($json)) {
                    if (empty($json['version']) || empty($json['release_date'])) {
                        Toastr::error('Config File Missing', trans('common.operation_failed'));
                        return redirect()->back();
                    }

                    if (app('general_setting')->system_version < $json['min']) {
                        Toastr::error($json['min'] . ' or greater is  required for this version', trans('common.operation_failed'));
                        return redirect()->back();
                    }
    


                } else {
                    Toastr::error('Config File Missing', trans('common.operation_failed'));
                    return redirect()->back();
                }

                $src = storage_path('app/tempUpdate');
                $dst = base_path('/');

                $this->recurse_copy($src, $dst);

                if (isset($json['migrations']) & !empty($json['migrations'])) {
                    foreach ($json['migrations'] as $migration) {
                        Artisan::call('migrate',
                            array(
                                '--path' => $migration,
                                '--force' => true));
                    }
                }

                $setting = GeneralSetting::first();
                $setting->system_version = $json['version'];
                $setting->save();
                $newVersion = VersionHistory::where('version', $json['version'])->first();
                if (!$newVersion) {
                    $newVersion = new VersionHistory();
                }
                $newVersion->version = $json['version'];
                $newVersion->release_date = date('Y-m-d',strtotime($json['release_date']));
                $newVersion->url = $json['url'];
                $newVersion->notes = $json['notes'];
                $newVersion->created_at =now();
                $newVersion->updated_at = now();
                $newVersion->save();
                Storage::put('.version', $json['version']);
            }


            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }

            $this->allClear();
            session()->forget('menus');
            Toastr::success("Your system successfully updated", 'Success');
            
            return redirect()->back();
        } catch (\Exception $e) {

            $this->allClear();
            session()->forget('menus');
            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function allClear()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        $dirname = base_path('/bootstrap/cache/');

        if (is_dir($dirname)){
            $dir_handle = opendir($dirname);
        }else{
            $dir_handle=false;
        }
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    $this->delete_directory($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
    }

    public function databaseBackup()
    {
        try {
            Artisan::call('backup:database');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function projectBackup()
    {
        try {
            Artisan::call('backup:backup_file');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());

        }
    }
}
