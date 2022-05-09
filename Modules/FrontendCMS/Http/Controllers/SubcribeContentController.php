<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendCMS\Http\Requests\UpdateSubscribeContentRequest;
use \Modules\FrontendCMS\Services\SubcribeContentService;
use Exception;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class SubcribeContentController extends Controller
{

    protected $subscribeContentService;

    public function __construct(SubcribeContentService $subscribeContentService){
        $this->middleware('maintenance_mode');
        $this->subscribeContentService = $subscribeContentService;
    }

    public function index()
    {
        try{
            $subscribeContent = $this->subscribeContentService->editById(1);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return view('frontendcms::subscribe_content.index',compact('subscribeContent'));
    }

    public function popup_index()
    {
        try{
            $subscribeContent = $this->subscribeContentService->editById(2);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return view('frontendcms::popup_content.index',compact('subscribeContent'));
    }




    public function update(UpdateSubscribeContentRequest $request)
    {
        
        try{
            $this->subscribeContentService->update($request, $request->id);

            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Subscribe Content updated.');
            return 1;
            
        } catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'),__('common.error'));
            return 0;
        }

    }


}
