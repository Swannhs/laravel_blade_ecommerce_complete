<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\FaqService;
use Exception;
use Modules\FrontendCMS\Http\Requests\CreateFaqRequest;
use Modules\FrontendCMS\Http\Requests\UpdateFaqRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->middleware('maintenance_mode');
        $this->faqService = $faqService;
    }

    public function store(CreateFaqRequest $request)
    {
        try{
            $this->faqService->save($request->only('title', 'status', 'description'));
            LogActivity::successLog('faq store successful.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }

        return $this->loadTableData();
    }

    public function update(UpdateFaqRequest $request)
    {
        try{
            $this->faqService->update($request->only('title', 'status', 'description'),$request->id);
            LogActivity::successLog('faq update successful.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return  $this->loadTableData();
    }


    public function destroy(Request $request)
    {
        try {
            $this->faqService->deleteById($request->id);
            LogActivity::successLog('faq delete successful.');
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
            $FaqList = $this->faqService->getAll();

            return response()->json([
                'TableData' =>  (string)view('frontendcms::merchant.faq.list', compact('FaqList'))
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
