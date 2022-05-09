<?php

namespace Modules\GeneralSetting\Http\Controllers;

use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Entities\GeneralSetting;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }
    
    public function index()
    {
        $setting = GeneralSetting::select('maintenance_title', 'maintenance_subtitle', 'maintenance_banner', 'maintenance_status')->first();
        return view('generalsetting::maintenance.index',compact('setting'));
    }


    public function maintenanceAction(Request $request)
    {
        

        $request->validate([
            'title' => 'max:255',
            'subtitle' => 'max:255',
            'banner' => 'mimes:jpg,jpeg,png,svg,bmp',
            'status' => 'required'
        ]);


        try {

            $content = GeneralSetting::first();
            $banner = $content->maintenance_banner;
            if(isset($request->banner)) {
                ImageStore::deleteImage($content->maintenance_banner);
                $banner = ImageStore::saveSettingsImage($request->banner,1300,920);
            }
            $content->update([
                'maintenance_title' => $request->title,
                'maintenance_subtitle' => $request->subtitle,
                'maintenance_banner' => $banner,
                'maintenance_status' => $request->status,
            ]);
            Toastr::success(trans('common.operation_done_successfully'), trans('common.success'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(trans('common.operation_failed'), trans('common.error'));
            return redirect()->back();
        }
    }
}
