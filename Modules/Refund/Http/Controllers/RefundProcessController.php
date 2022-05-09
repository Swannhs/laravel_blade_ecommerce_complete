<?php

namespace Modules\Refund\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Refund\Services\RefundProcessService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class RefundProcessController extends Controller
{
    protected $refundProcessService;

    public function __construct(RefundProcessService $refundProcessService){
        $this->middleware('maintenance_mode');
        $this->refundProcessService = $refundProcessService;
    }

    public function index()
    {
        $data['items'] = $this->refundProcessService->getAll();
        return view('refund::admin.refund_process.index', $data);
    }

    public function process_list()
    {
        $data['items'] = $this->refundProcessService->getAll();
        return view('refund::admin.refund_process.process_list', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:refund_processes,name',
            'description' => 'required'
        ]);
        try {
            $this->refundProcessService->save($request->except("_token"));
            LogActivity::successLog('Refund Process added.');
            return response()->json(["message" => "New Refund Process Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:refund_processes,name,'.$id,
            'description' => 'required'
        ]);
        try {
            $this->refundProcessService->update($request->except("_token"), $id);
            LogActivity::successLog('Refund Process updated.');
            return response()->json(["message" => "Refund Process updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->refundProcessService->delete($id);
            LogActivity::successLog('A Refund Process has been destroyed.');
            Toastr::success(__('common.deleted_successfully'),__('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Refund Process');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
