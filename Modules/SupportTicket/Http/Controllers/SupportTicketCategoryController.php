<?php

namespace Modules\SupportTicket\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Services\SupportTicketCategoryService;
class SupportTicketCategoryController extends Controller
{
    protected $supportTicketCategoryService;

    public function __construct(SupportTicketCategoryService $supportTicketCategoryService)
    {
        $this->middleware('maintenance_mode');
        $this->supportTicketCategoryService = $supportTicketCategoryService;
    }
    public function index()
    {
        try{
            $data['categories']  = $this->supportTicketCategoryService->getAll();
            return view('supportticket::category.index',$data);
        }catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:support_ticket_category,name'
        ]);

        try{

            $this->supportTicketCategoryService->create($request->except('_token'));
            \LogActivity::successLog('Support Ticket Category Created Successfully');
            if($request->form_type == 2){
                $CategoryList = $this->supportTicketCategoryService->getActiveAll();
                return view('supportticket::ticket.components._category_list_select',compact('CategoryList'));
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

    public function edit(Request $request){
        try{
            $category   = $this->supportTicketCategoryService->find($request->id);
            return view('supportticket::category.components.edit',compact('category'));
        }catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:support_ticket_category,name,'.$request->id
        ]);
        try{
            $this->supportTicketCategoryService->update($request->except('_token'));
            \LogActivity::successLog('Support Ticket Category Updated Successfully');
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
            $this->supportTicketCategoryService->statusChange($request->except('_token'));
            \LogActivity::successLog('Support Ticket Category Status Chnage Successfully');
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
            $this->supportTicketCategoryService->delete($request->id);
            \LogActivity::successLog('Support Ticket Category Deleted Successfully');
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
            $categories  = $this->supportTicketCategoryService->getAll();

            return response()->json([

                'TableData' =>  (string)view('supportticket::category.components.list', compact('categories')),
                'createForm' =>  (string)view('supportticket::category.components.create')
            ],200);
        }catch(Exception $e){
            \LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
}
