<?php

namespace Modules\Marketing\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\NewsLetterService;
use Modules\RolePermission\Entities\Role;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Artisan;
use Modules\UserActivityLog\Traits\LogActivity;

class NewsLetterController extends Controller
{
    protected $newsLetterService;

    public function __construct(NewsLetterService $newsLetterService)
    {
        $this->middleware('maintenance_mode');
        $this->newsLetterService = $newsLetterService;
    }

    public function index()
    {
        try{
            return view('marketing::newsletter.index');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){
        $message = $this->newsLetterService->getAll();

        return DataTables::of($message)
            ->addIndexColumn()
            ->addColumn('publish_date', function($message){
                return date(app('general_setting')->dateFormat->format, strtotime($message->publish_date));
            })
            ->addColumn('status', function($message){
                return view('marketing::newsletter.components._status_td',compact('message'));
            })
            ->addColumn('created_by', function($message){
                return $message->user->first_name . ' '. $message->user->last_name;
            })
            ->addColumn('mail_to', function($message){
                return view('marketing::newsletter.components._mail_to_td',compact('message'));
            })
            ->addColumn('action', function($message){
                return view('marketing::newsletter.components._action_td',compact('message'));
            })
            ->rawColumns(['status','message_to','action'])
            ->toJson();
    }

    public function roleUser(Request $request){

        try{
            $users = $this->newsLetterService->getUserByRole($request->id);
            return view('marketing::newsletter.components.user_for_role',compact('users'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }

    public function create(){

        try{
            $subscribers = $this->newsLetterService->getAllSubscriber();
            $email_template = $this->newsLetterService->getEmailTemplate();
            $roles = $this->newsLetterService->getAllRole();
            $users = $this->newsLetterService->getAllUser();
            if ($email_template) {
                return view('marketing::newsletter.components.create',compact('roles','users','subscribers','email_template'));
            }
            else {
                Toastr::error(__('common.create_template_first'), __('common.error'));
                return back();
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
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

        if($request->send_to == 4){
            $request->validate([
                'subscriber_list' => 'required',
            ]);
        }

        try{
            $news = $this->newsLetterService->store($request->except('_token'));
            LogActivity::successLog('News Letter Successfully Created.');
            return $this->reloadWithData($news->id);
        }catch(Exception $e){

            LogActivity::errorLog($e->getMessage());

        }
    }

    public function edit($id){

        try{
            $subscribers = $this->newsLetterService->getAllSubscriber();
            $email_template = $this->newsLetterService->getEmailTemplate();
            $roles = $this->newsLetterService->getAllRole();
            $users = $this->newsLetterService->getAllUser();
            $message = $this->newsLetterService->editById($id);
            return view('marketing::newsletter.components.edit',compact('roles','users','subscribers','email_template','message','id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function update(Request $request){
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

        if($request->send_to == 4){
            $request->validate([
                'subscriber_list' => 'required',
            ]);
        }

        try{
            $this->newsLetterService->update($request->except('_token'));
            LogActivity::successLog('News Letter Successfully Updated.');
            return $this->reloadWithData();

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }

    public function destroy(Request $request)
    {
        try{
            $this->newsLetterService->deleteById($request->id);

            LogActivity::successLog('News Letter Successfully Deleted.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }

    public function testMail(Request $request){

        try{
            return $this->newsLetterService->testMail($request->except('_token'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }

    private function reloadWithData($id = null){
        try{
            $messages = $this->newsLetterService->getAll();

            return response()->json([
                'TableData' =>  (string)view('marketing::newsletter.components.list', compact('messages')),
                'testMailModal' =>  (string)view('marketing::newsletter.components.test_mail_modal',compact('id'))
            ]);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }

    public function cronjob(){
        try {
            Artisan::call('command:newsletter');
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

    public function configuration(){
        return view('marketing::config');
    }
}
