<?php

namespace Modules\GeneralSetting\Http\Controllers;


use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\UserActivityLog\Traits\LogActivity;

class CloudStorageController extends Controller
{
    public function index()
    {
        try{

            $data = [];
            $data['cloud_hosts'] = BusinessSetting::where('category_type','file_storage')->get();
            return view('generalsetting::cloud_storage_index',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function allFileStorage()
    {
        return BusinessSetting::where('category_type','file_storage')->get();
    }

    public function activeStorage($activeStorageID)
    {
        foreach ($this->allFileStorage() as  $fileStore) {
            $fileStore->status = 0;
            $fileStore->save();
        }

        BusinessSetting::where('id',$activeStorageID)->update([
            'status' => 1,
        ]);

        $row = BusinessSetting::where('category_type','file_storage')->where('status',1)->first();
        if($row){
            Cache::forget('file_storage');
            Cache::rememberForever('file_storage', function () use($row) {
                return $row->type;
            });

        }else{
            Cache::rememberForever('file_storage', function ()  {
                return 'Local';
            });
        }

    }

    public function overWriteEnvFile($data)
    {
        try {
            if (!count($data)) {
                return false;
            }
            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach ((array)$data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if ($entry[0] === $key) {
                        $env[$env_key] = $key . "=" . (is_string($value) ? '"' . $value . '"' : $value);
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } catch (Exception $e) {
            Toastr::error($e->getMessage(), 'Error!!');
            return back();
        }

    }

}
