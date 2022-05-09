<?php

namespace Modules\Marketing\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\SubscriberService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    protected $subscriberService;
    public function __construct(SubscriberService $subscriberService)
    {
        $this->middleware('maintenance_mode');
        $this->subscriberService = $subscriberService;
    }
    public function index()
    {
        try{
            return view('marketing::subscribers.index');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){
        $subscriber = $this->subscriberService->getAll();

        return DataTables::of($subscriber)
            ->addIndexColumn()
            ->addColumn('date', function($subscriber){
                return date(app('general_setting')->dateFormat->format, strtotime($subscriber->created_at));
            })
            
            ->addColumn('status', function($subscriber){
                return view('marketing::subscribers.components._status_td',compact('subscriber'));
            })
            ->addColumn('action', function($subscriber){
                return view('marketing::subscribers.components._action_td',compact('subscriber'));
            })
            ->rawColumns(['status','action'])
            ->toJson();
    }

    public function destroy(Request $request)
    {
        try{
            $this->subscriberService->deleteById($request->id);
            LogActivity::successLog('Subscriber Deleted Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    private function reloadWithData(){

        try{
            $subscribers = $this->subscriberService->getAll();
            return view('marketing::subscribers.components.list',compact('subscribers'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function statusChange(Request $request){
        try{
            $this->subscriberService->statusChange($request->except('_token'));
            LogActivity::successLog('Subscriber Status Change Successfully.');
            return $this->reloadWithData();
        }
        catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
}
