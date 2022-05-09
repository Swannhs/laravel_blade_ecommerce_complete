<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\BenefitService;
use Exception;
use Modules\FrontendCMS\Http\Requests\CreateBenifitRequest;
use Modules\FrontendCMS\Http\Requests\UpdateBenifitRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class BenifitController extends Controller
{
    protected $benefitService;

    public function __construct(BenefitService $benefitService)
    {
        $this->middleware('maintenance_mode');
        $this->benefitService = $benefitService;
    }


    public function store(CreateBenifitRequest $request)
    {

        try {
            $this->benefitService->save($request->only('title', 'description', 'status', 'image'));
            LogActivity::successLog('benifit store successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return  $this->loadTableData();
    }



    public function update(UpdateBenifitRequest $request)
    {

        try {
            $id = $request->id;
            $this->benefitService->update($request->only('title', 'description', 'status', 'image'), $id);
            LogActivity::successLog('benifit update successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return  $this->loadTableData();
    }


    public function destroy(Request $request)
    {

        try {
            $this->benefitService->deleteById($request->id);
            LogActivity::successLog('benifit delete successful.');
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
            $BenefitList = $this->benefitService->getAll();

            return response()->json([
                'TableData' =>  (string)view('frontendcms::merchant.benefit.list', compact('BenefitList'))
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
