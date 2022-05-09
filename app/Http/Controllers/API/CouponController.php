<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CouponService;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CustomerCouponStore;


class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    // Customer Coupon list

    public function index(Request $request){
        
        $coupons = $this->couponService->getAll($request->user()->id);
        if(count($coupons) > 0){
            return response()->json([
                'coupons' => $coupons,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'coupon not found'
            ],404);
        }

    }

    // Customer coupon store

    public function store(Request $request){
        $request->validate([
            'code' => 'required'
        ]);
        $coupon = Coupon::where('coupon_code',$request->code)->first();
        if(isset($coupon)){
            $storeCheck = CustomerCouponStore::where('customer_id',auth()->user()->id)->where('coupon_id',$coupon->id)->first();
            if(!isset($storeCheck)){
                if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                    $this->couponService->store($coupon->id, $request->user()->id);
                    return response()->json([
                        'message' => 'coupon Stored Successfully'
                    ],201);
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
    }

    // Customer coupon delete

    public function destroy(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $result = $this->couponService->deleteById($request->id, $request->user()->id);

        if($result){
            return response()->json([
                'message' => 'coupon deleted successfully'
            ],200);
        }else{
            return response()->json([
                'message' => 'coupon not found'
            ],500);
        }

    }

}
