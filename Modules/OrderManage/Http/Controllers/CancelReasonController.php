<?php

namespace Modules\OrderManage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderManage\Services\CancelReasonService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class CancelReasonController extends Controller
{
    protected $cancelReasonService;

    public function __construct(CancelReasonService $cancelReasonService){
        $this->middleware('maintenance_mode');
        $this->cancelReasonService = $cancelReasonService;
    }

    public function index()
    {
        $data['items'] = $this->cancelReasonService->getAll();
        return view('ordermanage::cancel_reasons.index', $data);
    }

    public function process_list()
    {
        $data['items'] = $this->cancelReasonService->getAll();
        return view('ordermanage::cancel_reasons.reason_list', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:cancel_reasons,name',
            'description' => 'required'
        ]);

        try {
            $this->cancelReasonService->save($request->except("_token"));
            LogActivity::successLog('Reason added.');
            return response()->json(["message" => "New Reason Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:cancel_reasons,name,'.$id,
            'description' => 'required'
        ]);
        try {
            $this->cancelReasonService->update($request->except("_token"), $id);
            LogActivity::successLog('Reason updated.');
            return response()->json(["message" => "Reason updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->cancelReasonService->delete($id);
            LogActivity::successLog('A Reason has been destroyed.');
            Toastr::success(__('common.deleted_successfully'),__('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Cancel Reason.');
            Toastr::error(__('common.error_message'));
            return back();
        }
    }
}
