<?php

namespace Modules\Marketing\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Marketing\Services\BulkSMSService;
use Modules\Marketing\Services\NewsLetterService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class BulkSMSController extends Controller
{
    protected $newsLetterService;
    protected $bulkSMSService;

    public function __construct(NewsLetterService $newsLetterService, BulkSMSService $bulkSMSService)
    {
        $this->middleware('maintenance_mode');
        $this->newsLetterService = $newsLetterService;
        $this->bulkSMSService = $bulkSMSService;
    }

    public function index()
    {
        try{
            $roles = $this->newsLetterService->getAllRole();
            $users = $this->bulkSMSService->getAllUser();
            $template = $this->bulkSMSService->getActiveTemplate();
            return view('marketing::bulk_sms.index',compact('roles','users', 'template'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){
        $message = $this->bulkSMSService->getAll();

        return DataTables::of($message)
            ->addIndexColumn()
            ->addColumn('message', function ($message){
                return substr($message->message,0,50).' ....';
            })
            ->addColumn('publish_date', function($message){
                return date(app('general_setting')->dateFormat->format, strtotime($message->publish_date));
            })
            ->addColumn('status', function($message){
                return view('marketing::bulk_sms.components._status_td',compact('message'));
            })
            ->addColumn('created_by', function($message){
                return $message->user->first_name . ' '. $message->user->last_name;
            })
            ->addColumn('message_to', function($message){
                return view('marketing::bulk_sms.components._message_to_td',compact('message'));
            })
            ->addColumn('action', function($message){
                return view('marketing::bulk_sms.components._action_td',compact('message'));
            })
            ->rawColumns(['status','message_to','action'])
            ->toJson();
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'send_to' => 'required',
            'publish_date' => 'required'
        ]);
        if($request->send_to == 1){
            $request->validate([
                'all_user' => 'required'
            ]);
        }

        if($request->send_to == 2){
            $request->validate([
                'role' => 'required',
                'role_user' => 'required'
            ]);
        }

        if($request->send_to == 3){
            $request->validate([
                'role_list' => 'required',
            ]);
        }
        try{
            $sms = $this->bulkSMSService->store($request->except('_token'));
            LogActivity::successLog('Bulk SMS Created Successfully.');
            return $this->reloadWithData($sms->id);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            
        }
    }

    public function update(Request $request){
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'send_to' => 'required',
            'publish_date' => 'required'
        ]);
        try{
            $this->bulkSMSService->update($request->except('_token'));
            LogActivity::successLog('Bulk SMS Updated Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
    
    public function edit(Request $request){
        
        $roles = $this->newsLetterService->getAllRole();
        $users = $this->bulkSMSService->getAllUser();
        $message = $this->bulkSMSService->editById($request->id);
        return view('marketing::bulk_sms.components.edit',compact('roles','users','message'));
    }

    public function roleUser(Request $request){
        
        try{
            $users = $this->bulkSMSService->getUserByRole($request->id);
            return view('marketing::bulk_sms.components.user_for_role',compact('users'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function testSMS(Request $request){

        try{
            $this->bulkSMSService->testSMS($request->except('_token'));
            LogActivity::successLog('Test SMS Send Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }

        
    }
    
    public function destroy(Request $request)
    {
        try{
            $this->bulkSMSService->deleteById($request->id);
            LogActivity::successLog('Bulk SMS Deleted Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
        
    }

    private function reloadWithData($id = null){
        try{
            $messages = $this->bulkSMSService->getAll();
            $roles = $this->newsLetterService->getAllRole();
            $users = $this->bulkSMSService->getAllUser();
            $template = $this->bulkSMSService->getActiveTemplate();

            return response()->json([
                'TableData' =>  (string)view('marketing::bulk_sms.components.list', compact('messages')),
                'createForm' =>  (string)view('marketing::bulk_sms.components.create',compact('roles','users','template')),
                'testSMSModal' =>  (string)view('marketing::bulk_sms.components.modal_for_test_sms',compact('id'))
            ]);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function cronjob(){
        try {
            Artisan::call('command:bulk_sms');
            return response()->json([
                'msg' => 'success'
            ],200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'msg' => 'error'
            ],500);
        }
    }
}
