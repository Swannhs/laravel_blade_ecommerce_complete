<?php

namespace Modules\OrderManage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderManage\Services\DeliveryProcessService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class DeliveryProcessController extends Controller
{
    protected $deliveryProcessService;

    public function __construct(DeliveryProcessService $deliveryProcessService){
        $this->middleware('maintenance_mode');
        $this->deliveryProcessService = $deliveryProcessService;
    }

    public function index()
    {
        $data['items'] = $this->deliveryProcessService->getAll();
        return view('ordermanage::delivery_process.index', $data);
    }

    public function process_list()
    {
        $data['items'] = $this->deliveryProcessService->getAll();
        return view('ordermanage::delivery_process.process_list', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:delivery_processes,name',
            'description' => 'required'
        ]);
        try {
            $this->deliveryProcessService->save($request->except("_token"));
            LogActivity::successLog('Delivery Process added.');
            return response()->json(["message" => "New Delivery Process Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:delivery_processes,name,'.$request->id,
            'description' => 'required'
        ]);
        try {
            $this->deliveryProcessService->update($request->except("_token"), $request->id);
            LogActivity::successLog('Delivery Process updated.');
            return response()->json(["message" => "Delivery Process updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->deliveryProcessService->delete($id);
            LogActivity::successLog('A Delivery Process has been destroyed.');
            Toastr::success(__('common.deleted_successfully'),__('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Delivery Process');
            Toastr::error(__('common.error_message'));
            return back();
        }
    }
}
