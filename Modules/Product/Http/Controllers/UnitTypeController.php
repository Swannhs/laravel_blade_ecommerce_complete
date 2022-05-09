<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Product\Http\Requests\UnitRequest;
use Modules\Product\Services\UnitTypeService;
use Modules\UserActivityLog\Traits\LogActivity;

class UnitTypeController extends Controller
{
    protected $unitTypeService;

    public function __construct(UnitTypeService $unitTypeService)
    {
        $this->middleware('maintenance_mode');
        $this->unitTypeService = $unitTypeService;
    }

    public function index(Request $request)
    {
        try{
            $units = $this->unitTypeService->getAll();
            return view('product::units.index', [
                "units" => $units,
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function csv_unit_download()
    {
        try {
            $this->unitTypeService->csvDownloadUnit();
            $filePath = storage_path("app/unit_list.xlsx");
        	$headers = ['Content-Type: text/xlsx'];
        	$fileName = time().'-unit_list.xlsx';
            return response()->download($filePath, $fileName, $headers);

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function get_list()
    {
        $data['units'] = $this->unitTypeService->getAll();
        return view('product::units.units_list', $data);
    }

    public function store(UnitRequest $request)
    {
        try {
            $this->unitTypeService->save($request->except("_token"));
            LogActivity::successLog('Units added.');
            if(isset($request->form_type)){
                if($request->form_type == 'modal_form'){
                    $units = $this->unitTypeService->getActiveAll();
                    return view('product::products.components._unit_list_select',compact('units'));
                }else{
                    return response()->json(["message" => "Units Added Successfully"], 200);
                }
            }else{
                return response()->json(["message" => "Units Added Successfully"], 200);
            }


        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(UnitRequest $request, $id)
    {
        try {
            $this->unitTypeService->update($request->except("_token"), $id);
            LogActivity::successLog('Units updated.');
            return response()->json(["message" => "Units updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->unitTypeService->delete($id);
            LogActivity::successLog('unit delete successful.');
            if ($result == "not_possible") {
                Toastr::warning(__('common.related_data_exist_in_multiple_directory'));
                return back();
            }
            else {
                Toastr::success(__("common.deleted_successfully"), __("common.success"));
                return redirect()->route('product.units.index');
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Unit Destroy');
            Toastr::error(__('common.error_message'));
            return back();
        }
    }
}
