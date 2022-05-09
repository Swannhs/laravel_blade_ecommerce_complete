<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Http\Requests\CreateFlashDealsRequest;
use Modules\Marketing\Services\FlashDealsService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Marketing\Http\Requests\UpdateFlashDealRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class FlashDealsController extends Controller
{
    protected $flashDealsService;

    public function __construct(FlashDealsService $flashDealsService)
    {
        $this->middleware('maintenance_mode');
        $this->flashDealsService = $flashDealsService;
    }
    
    public function index()
    {
        try{
            $DealList = $this->flashDealsService->getAll();
            return view('marketing::flash_deals.index',compact('DealList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function create(){
        try{
            $sellerProducts = $this->flashDealsService->getSellerProduct();
            return view('marketing::flash_deals.components.create',compact('sellerProducts'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function productList(Request $request){
        try{
            $product_id = $request->product_id;
            return view('marketing::flash_deals.components.product_list',compact('product_id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
    public function productListEdit(Request $request){
        try{
            $product_id = $request->product_id;
            $flash_deal_id = $request->flash_deal_id;
            return view('marketing::flash_deals.components.product_list',compact('product_id','flash_deal_id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function store(CreateFlashDealsRequest $request){
        
        DB::beginTransaction();
        try{
            $this->flashDealsService->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Flash Deal Created Successfully.');
            return redirect(route('marketing.flash-deals'));
        }catch(Exception $e){
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit($id){
        try{
            $flash_deal = $this->flashDealsService->editById($id);
            $sellerProducts = $this->flashDealsService->getSellerProduct();
            return view('marketing::flash_deals.components.edit',compact('sellerProducts','flash_deal'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }
    public function update(UpdateFlashDealRequest $request, $id){
       
        DB::beginTransaction(); 
        try{
            $this->flashDealsService->update($request->except('_token'),decrypt($id));
            DB::commit();
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Flash Deal Updated Successfully.');
            return redirect(route('marketing.flash-deals'));
        }catch(Exception $e){
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function statusChange(Request $request){
        try{
            $this->flashDealsService->statusChange($request->except('_token'));
            LogActivity::successLog('Flash Deal Status Change Successfully.');
            return $this->reloadwithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
        
    }
    public function featuredChange(Request $request){
        try{
            $this->flashDealsService->featuredChange($request->except('_token'));
            LogActivity::successLog('Flash Deal Is Feature Change Successfully.');
            return true;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function destroy(Request $request){
        try{
            $this->flashDealsService->deleteById($request->id);
            LogActivity::successLog('Flash Deal delete Successfully.');
            return $this->reloadwithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    private function reloadwithData(){
        try{
            $DealList = $this->flashDealsService->getAll();
            return view('marketing::flash_deals.components.list',compact('DealList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    
}
