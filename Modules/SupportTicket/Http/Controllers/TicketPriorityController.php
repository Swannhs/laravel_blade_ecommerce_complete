<?php

namespace Modules\SupportTicket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Services\TicketPriorityService;
use Brian2694\Toastr\Facades\Toastr;
class TicketPriorityController extends Controller
{
    protected $ticketPriorityService;

    public function __construct(TicketPriorityService $ticketPriorityService)
    {
        $this->middleware('maintenance_mode');
        $this->ticketPriorityService = $ticketPriorityService;
    }
    public function index()
    {
        try{
            $data['priorities']  = $this->ticketPriorityService->getAll();
            return view('supportticket::priority.index',$data);
        }catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:support_ticket_pirority,name'
        ]);
        try{

            $this->ticketPriorityService->create($request->except('_token'));
            \LogActivity::successLog('Priority Created Successfully');
            if($request->form_type == 2){
                $PriorityList = $this->ticketPriorityService->getActiveAll();
                return view('supportticket::ticket.components._priority_list_select',compact('PriorityList'));
            }else{
                return $this->reloadWithData();
            }

        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            \LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);

        }
    }


    public function edit(Request $request)
    {
        try{
            $priority = $this->ticketPriorityService->find($request->id);
            return view('supportticket::priority.components.edit',compact('priority'));
        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);

        }
    }

    public function update(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|unique:support_ticket_pirority,name,'.$request->id
            ]);
           $this->ticketPriorityService->update($request->except('_token'));
           \LogActivity::successLog('Priority Updated Successfully');
           return $this->reloadWithData();
        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            \LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function status(Request $request){
        try{
            $this->ticketPriorityService->statusChange($request->except('_token'));
            \LogActivity::successLog('Priority Status Change Successfully');
            return true;
        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            \LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function destroy(Request $request)
    {
        try{
            $this->ticketPriorityService->delete($request->id);
            \LogActivity::successLog('Priority Deleted Successfully');
            return $this->reloadWithData();
        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            \LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    private function reloadWithData(){
        try{
            $priorities  = $this->ticketPriorityService->getAll();

            return response()->json([

                'TableData' =>  (string)view('supportticket::priority.components.list', compact('priorities')),
                'createForm' =>  (string)view('supportticket::priority.components.create')
            ]);
        }catch(Exception $e){
            \LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
}
