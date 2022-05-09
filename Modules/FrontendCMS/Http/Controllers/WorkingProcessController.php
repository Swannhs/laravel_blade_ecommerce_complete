<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\WorkingProcessService;
use Exception;
use Modules\FrontendCMS\Http\Requests\CreateBenifitRequest;
use Modules\FrontendCMS\Http\Requests\UpdateBenifitRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class WorkingProcessController extends Controller
{
    protected $workingProcessService;

    public function __construct(WorkingProcessService $workingProcessService)
    {
        $this->middleware('maintenance_mode');
        $this->workingProcessService = $workingProcessService;
    }



    public function store(CreateBenifitRequest $request)
    {
        try {
            $this->workingProcessService->save($request->except('_token'));
            LogActivity::successLog('working process create successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return  $this->loadTableData();
    }

    public function update(UpdateBenifitRequest $request)
    {

        try {
            $this->workingProcessService->update($request->only('title', 'description', 'position', 'status', 'image'), $request->id);
            LogActivity::successLog('working process update successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return  $this->loadTableData();
    }


    public function destroy(Request $request)
    {

        try {
            $this->workingProcessService->deleteById($request->id);
            LogActivity::successLog('working process delete successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }
        return  $this->loadTableData();
    }

    private function loadTableData()
    {

        try {
            $WorkingProcessList = $this->workingProcessService->getAll();

            return response()->json([
                'TableData' =>  (string)view('frontendcms::merchant.working_process.list', compact('WorkingProcessList'))
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
