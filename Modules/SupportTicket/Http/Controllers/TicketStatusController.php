<?php

namespace Modules\SupportTicket\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Services\TicketStatusService;
class TicketStatusController extends Controller
{
    protected $ticketStatusService;

    public function __construct(TicketStatusService $ticketStatusService)
    {
        $this->middleware('maintenance_mode');
        $this->ticketStatusService = $ticketStatusService;
    }


    public function index()
    {
        $statuses = $this->ticketStatusService->getAll();
        return view('supportticket::status.index',compact('statuses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:ticket_statuses,name'
        ]);
        try{
            $this->ticketStatusService->create($request->except('_token'));
            \LogActivity::successLog('Status Created Successfully');
            if($request->form_type == 2){
                $StatusList = $this->ticketStatusService->getActiveAll();
                
                return view('supportticket::ticket.components._status_list_select',compact('StatusList'));
            }else{
                return $this->reloadWithData();
            }
        }catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }


    public function edit(Request $request)
    {
        try{
            $status   = $this->ticketStatusService->find($request->id);
            return view('supportticket::status.components.edit',compact('status'));
        }catch (\Exception $e) {

            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:ticket_statuses,name,'.$request->id
        ]);
        try{
            $this->ticketStatusService->update($request->except('_token'));
            \LogActivity::successLog('Status Updated Successfully');
            return $this->reloadWithData();
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
            $this->ticketStatusService->delete($request->id);
            \LogActivity::successLog('Status Deleted Successfully');
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
            $this->ticketStatusService->statusChange($request->except('_token'));
            \LogActivity::successLog('Status Status Change Successfully');
            return true;
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
            $statuses = $this->ticketStatusService->getAll();

            return response()->json([

                'TableData' =>  (string)view('supportticket::status.components.list', compact('statuses')),
                'createForm' =>  (string)view('supportticket::status.components.create')
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
