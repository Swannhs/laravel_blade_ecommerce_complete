<?php

namespace Modules\Marketing\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Http\Requests\CreateCouponRequest;
use Modules\Marketing\Http\Requests\UpdateCouponRequest;
use Modules\Marketing\Services\CouponService;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->middleware('maintenance_mode');
        $this->couponService = $couponService;
    }


    public function index(){
        try{
            return view('marketing::coupon.index');
        }
        catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){
        $coupon = $this->couponService->getAll();
        return DataTables::of($coupon)
            ->addIndexColumn()
            ->addColumn('type', function($coupon){
                return view('marketing::coupon.components._type_td',compact('coupon'));
            })
            ->addColumn('start_date', function($coupon){
                return date(app('general_setting')->dateFormat->format, strtotime($coupon->start_date));
            })
            ->addColumn('end_date', function($coupon){
                return date(app('general_setting')->dateFormat->format, strtotime($coupon->end_date));
            })
            ->addColumn('action', function($coupon){
                return view('marketing::coupon.components._action_td',compact('coupon'));
            })
            ->rawColumns(['type','action'])
            ->toJson();
    }

    public function getForm(Request $request){
        try{
            $id = $request->id;
            if($id == 1){
                $products = $this->couponService->getProduct();
                return view('marketing::coupon.components.form_data_for_product',compact('products'));
            }elseif($id == 2){
                return view('marketing::coupon.components.form_data_for_order');
            }elseif($id == 3){
                return view('marketing::coupon.components.form_data_for_free_shipping');
            }else{
                return false;
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            
        }
    }

    public function store(CreateCouponRequest $request){
        
        if($request->coupon_type == 1){
            $request->validate([
                'product_list' => 'required',
                'discount' => 'required',
                'discount_type' => 'required'
            ]);
        }
        elseif($request->coupon_type == 2){
            $request->validate([
                'minimum_shopping' => 'required',
                'maximum_discount' => 'nullable|min:0',
                'discount' => 'required',
                'discount_type' => 'required'
            ]);
        }
        elseif($request->coupon_type == 3){
            $request->validate([
                'maximum_discount' => 'nullable|min:0'
            ]);
        }

        try{
            $this->couponService->store($request->except('_token'));
            LogActivity::successLog('Coupon Created Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            
        }

    }

    public function update(UpdateCouponRequest $request){
        $coupon = $this->couponService->editById($request->id);
        if($coupon->coupon_type == 1){
            $request->validate([
                'product_list' => 'required',
                'discount' => 'required',
                'discount_type' => 'required'
            ]);
        }
        elseif($coupon->coupon_type == 2){
            $request->validate([
                'minimum_shopping' => 'required',
                'maximum_discount' => 'nullable|min:0',
                'discount' => 'required',
                'discount_type' => 'required'
            ]);
        }
        elseif($coupon->coupon_type == 3){
            
        }

        try{
            $this->couponService->update($request->except('_token'));
            LogActivity::successLog('Coupon Updated Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
        
    }

    public function edit(Request $request){
        try{
            $coupon = $this->couponService->editById($request->id);
            $products = $this->couponService->getProduct();
            return view('marketing::coupon.components.edit',compact('coupon','products'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try{
            $this->couponService->deleteById($request->id);
            LogActivity::successLog('Coupon Deleted Successfully.');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    private function reloadWithData(){
        try{
            $coupons = $this->couponService->getAll();
            return response()->json([
                'TableData' =>  (string)view('marketing::coupon.components.list', compact('coupons')),
                'createForm' =>  (string)view('marketing::coupon.components.create')
            ]);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function coupon_info()
    {
        try {
            $coupons = $this->couponService->getAll()->get();
            return view('marketing::coupon.info', compact('coupons'));
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }

    }
}
