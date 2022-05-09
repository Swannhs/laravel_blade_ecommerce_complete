<?php

namespace Modules\Refund\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Refund\Services\RefundReasonService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class RefundReasonController extends Controller
{
    protected $refundReasonService;

    public function __construct(RefundReasonService $refundReasonService){
        $this->middleware('maintenance_mode');
        $this->refundReasonService = $refundReasonService;
    }

    public function index()
    {
        $data['items'] = $this->refundReasonService->getAll();
        return view('refund::admin.refund_reasons.refund_list', $data);
    }

    public function reasons_list()
    {
        $data['items'] = $this->refundReasonService->getAll();
        return view('refund::admin.refund_reasons.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|unique:refund_reasons,reason'
        ]);
        try {
            $this->refundReasonService->save($request->except("_token"));
            LogActivity::successLog('Refund Reason added.');
            return response()->json(["message" => "New Reason Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|unique:refund_reasons,reason,'.$id
        ]);
        try {
            $this->refundReasonService->update($request->except("_token"), $id);
            LogActivity::successLog('Refund Reason updated.');
            return response()->json(["message" => "Refund Reason updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->refundReasonService->delete($id);
            LogActivity::successLog('A Refund Reason has been destroyed.');
            Toastr::success(__('common.deleted_successfully'),__('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Tag Destroy');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
