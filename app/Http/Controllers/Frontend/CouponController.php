<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Exception;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CustomerCouponStore;
use Modules\UserActivityLog\Traits\LogActivity;

class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
        $this->middleware('maintenance_mode');
    }
    public function index(){
        try{
            $coupons = $this->couponService->getAll(auth()->user()->id);
            if (auth()->user()->role->type == 'customer' || auth()->user()->role->type == 'customer') {
                return view('backEnd.pages.customer_data.coupons',compact('coupons'));
            }else {
                return view(theme('pages.profile.coupons'),compact('coupons'));
            }
        }catch(Exception $e){
            LogActivity::successLog(' successful.');
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);
        $coupon = Coupon::where('coupon_code',$request->code)->first();
        if(isset($coupon)){
            $storeCheck = CustomerCouponStore::where('customer_id',auth()->user()->id)->where('coupon_id',$coupon->id)->first();
            if(!isset($storeCheck)){
                if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                    $this->couponService->store($coupon->id, auth()->user()->id);
                }else{
                    return response()->json([
                        'error' => 'Coupon Is Expired.'
                    ]);
                }
            }else{
                return response()->json([
                    'error' => 'Coupon Already Stored.'
                ]);
            }


        }else{
            return response()->json([
                'error' => 'Coupon Is Invalid.'
            ]);
        }
        LogActivity::successLog('coupon store successful.');
        return $this->reloadWithData();

    }
    public function destroy(Request $request){
        $this->couponService->deleteById($request->id, auth()->user()->id);
        LogActivity::successLog('coupon delete successful.');
        return $this->reloadWithData();
    }
    private function reloadWithData(){

        $coupons = $this->couponService->getAll(auth()->user()->id);
        if (auth()->user()->role->type != 'customer') {
            return response()->json([
                'CouponList' =>  (string)view('backEnd.pages.customer_data._coupon_list',compact('coupons'))
            ]);
        }else {
            return response()->json([
                'CouponList' =>  (string)view(theme('pages.profile.partials._coupon_list'),compact('coupons'))
            ]);
        }
    }
}
