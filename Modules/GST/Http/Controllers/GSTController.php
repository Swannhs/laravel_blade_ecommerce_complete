<?php

namespace Modules\GST\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\GST\Services\GSTService;
use Modules\UserActivityLog\Traits\LogActivity;

class GSTController extends Controller
{
    protected $gstService;

    public function __construct(GSTService $gstService)
    {
        $this->middleware('maintenance_mode');
        $this->gstService = $gstService;
    }
    
    public function index()
    {
        $data['gst_lists'] = $this->gstService->getAllList();
        return view('gst::gst.index', $data);
    }

    public function list()
    {
        $data['gst_lists'] = $this->gstService->getAllList();
        return view('gst::gst.gst_list', $data);
    }

    public function configuration()
    {
        $data['gst_lists'] = $this->gstService->getActiveList();
        $data['gst_configs'] = json_decode(file_get_contents(base_path('Modules/GST/Resources/assets/config_files/config.json')), true);
        return view('gst::configurations.index', $data);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:gst_taxes|max:255',
            'rate' => 'required'
        ]);
        try {
            $this->gstService->create($request->except("_token"));
            LogActivity::successLog('GST added.');
            return response()->json(["message" => "GST Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }

    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:gst_taxes,name,'.$id,
            'rate' => 'required'
        ]);
        try {
            $result = $this->gstService->update($request->except("_token"), $id);
            if($result == 1){
                LogActivity::successLog('GST updated.');
                return response()->json(["message" => "GST updated Successfully"], 200);
            }else{
                return 0;
            }
            
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    
     public function destroy($id)
     {
         try {
             $this->gstService->delete($id);
             LogActivity::successLog('A GST has been destroyed.');
             Toastr::success(__('common.deleted_successfully'), __('common.success'));
             return redirect()->route('gst_tax.index');
         } catch (\Exception $e) {
             LogActivity::errorLog($e->getMessage().' - Error has been detected for Tag Destroy');
             Toastr::error(__('common.error_message'), __('common.error'));
             return back();
         }
     }

     public function configuration_update(Request $request)
     {
         try {
             $this->gstService->updateConfiguration($request->except("_token"));
             LogActivity::successLog('GST Configuration updated.');
             Toastr::success(__('common.updated_successfully'), __('common.success'));
             return back();
         } catch (\Exception $e) {
             LogActivity::errorLog($e);
             Toastr::error(__('common.error_message'), __('common.error'));
             return back();
         }
     }
}
