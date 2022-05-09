<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\NewUserZoneService;
use Exception;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Marketing\Http\Requests\CreateNewUserZoneRequest;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;

class NewUserZoneController extends Controller
{
    protected $newUserZoneService;

    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->middleware('maintenance_mode');
        $this->newUserZoneService = $newUserZoneService;
    }

    public function index()
    {
        try{
            $ZoneList = $this->newUserZoneService->getAll();
            return view('marketing::new_user_zone.index',compact('ZoneList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function create(){
        try{
            $sellerProducts = $this->newUserZoneService->getSellerProduct();
             $categories = $this->newUserZoneService->getCategories()->where('parent_id', 0);
            $coupons = $this->newUserZoneService->getCoupons();
            return view('marketing::new_user_zone.components.create',compact('sellerProducts','categories','coupons'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function productList(Request $request){
        try{
            $product_id = $request->product_id;
            return view('marketing::new_user_zone.components.product_list',compact('product_id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }


    public function categoryList(Request $request){
        try{
            $category_id = $request->category_id;
            return view('marketing::new_user_zone.components.category_list',compact('category_id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }

    }

    public function couponCategoryList(Request $request){
        try{
            $category_id = $request->category_id;
            return view('marketing::new_user_zone.components.coupon_category_list',compact('category_id'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

        }
    }


    public function store(CreateNewUserZoneRequest $request){

        DB::beginTransaction();
        try{
            $this->newUserZoneService->store($request->except('_token'));
            DB::commit();
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('New User Zone Created Successfully');
            return redirect(route('marketing.new-user-zone'));
        }catch(Exception $e){
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit($id){
        try{
            $new_user_zone = $this->newUserZoneService->editById($id);
            $sellerProducts = $this->newUserZoneService->getSellerProduct();
            $categories = $this->newUserZoneService->getCategories()->where('parent_id', 0);
            $coupons = $this->newUserZoneService->getCoupons();
            return view('marketing::new_user_zone.components.edit',compact('sellerProducts','new_user_zone','categories','coupons'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }
    public function update(CreateNewUserZoneRequest $request, $id){

        DB::beginTransaction();
        try{
            $this->newUserZoneService->update($request->except('_token'),decrypt($id));
            DB::commit();
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('New User Zone Updated Successfully.');
            return redirect(route('marketing.new-user-zone'));
        }catch(Exception $e){
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function statusChange(Request $request){
        try{
            $this->newUserZoneService->statusChange($request->except('_token'));
            LogActivity::successLog('New User Zone Status Change Successfully.');
            return $this->reloadwithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
    public function featuredChange(Request $request){
        try{
            $this->newUserZoneService->featuredChange($request->except('_token'));
            LogActivity::successLog('New User Zone Featured Change Successfully.');
            return true;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function destroy(Request $request){
        try{
            $this->newUserZoneService->deleteById($request->id);
            LogActivity::successLog('New User Zone Deleted Successfully.');
            return $this->reloadwithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    private function reloadwithData(){
        try{
            $ZoneList = $this->newUserZoneService->getAll();
            return view('marketing::new_user_zone.components.list',compact('ZoneList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
}
