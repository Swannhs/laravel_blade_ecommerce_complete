<?php

namespace Modules\ContactRequest\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\ContactRequest\Services\ContactService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
        $this->middleware('maintenance_mode');
    }
    public function index()
    {
        try{
            $ContactList = $this->contactService->getAll();
            return view('contactrequest::contact.index',compact('ContactList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        $contact = $this->contactService->getById($id);
        return view('contactrequest::contact.show',compact('contact'));
    }

    public function destroy(Request $request)
    {
        try {
            $this->contactService->deleteById($request->id);
            LogActivity::successLog('contact deleted.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }
        return $this->loadTableData();
    }

    private function loadTableData()
    {
        try {
            $ContactList = $this->contactService->getAll();

            return response()->json([
                'TableData' =>  (string)view('contactrequest::contact.components.list', compact('ContactList'))
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
