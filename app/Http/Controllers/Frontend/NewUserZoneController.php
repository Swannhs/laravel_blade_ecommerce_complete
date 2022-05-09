<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NewUserZoneService;
use Illuminate\Http\Request;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CustomerCouponStore;
use Modules\Marketing\Entities\NewUserZoneCoupon;
use Modules\UserActivityLog\Traits\LogActivity;

class NewUserZoneController extends Controller
{
    protected $newUserZoneService;

    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->newUserZoneService = $newUserZoneService;
        $this->middleware('maintenance_mode');
    }

    public function show($slug)
    {
        $new_user_zone = $this->newUserZoneService->getById($slug);

        if(!auth()->check() && $new_user_zone->status == 0){
            return abort(404);
        }
        elseif(auth()->check() && $new_user_zone->status == 0){

            if(auth()->user()->role->type != 'superadmin' && auth()->user()->role->type != 'admin' && auth()->user()->role->type != 'staff'){
                return abort(404);
            }
        }

        $data['new_user_zone'] = $new_user_zone;
        $products = $new_user_zone->products()->whereHas('product', function($query){
            $query->where('status', 1)->whereHas('product', function($query){
                $query->where('status', 1);
            });
        })->paginate(12);
        $products->appends([
            'item' => 'product'
        ]);
        $data['products'] = $products;

        $data['allCategoryProducts'] = $this->newUserZoneService->getAllProductsForCategories($slug);
        $data['allCouponCategoryProducts'] = $this->newUserZoneService->getAllProductsForCouponCategories($slug);


        $data['coupon'] = $new_user_zone->coupon;

        $coupon_store_check = 0;
        if(auth()->check()){
            $is_coupon = CustomerCouponStore::where('coupon_id', $new_user_zone->coupon->coupon->id ?? '')->first();
            if(isset($is_coupon)){
                $coupon_store_check = 1;
            }else{
                $coupon_store_check = 0;
            }
        }
        $newUserZoneCoupon = NewUserZoneCoupon::where('new_user_zone_id',$new_user_zone->id)->first();
        $couponShow = 0;
        if($newUserZoneCoupon){
            $couponShow = 1;
        }
        $data['coupon_store_check'] = $coupon_store_check;
        $data['couponShow'] = $couponShow;

        return view(theme('pages.new_user_zone'),$data);
    }

    public function fetchProductData($slug){

        $new_user_zone = $this->newUserZoneService->getById($slug);
        $data['new_user_zone'] = $new_user_zone;
        $products = $new_user_zone->products()->whereHas('product', function($query){
            $query->where('status', 1)->whereHas('product', function($query){
                $query->where('status', 1);
            });
        })->paginate(12);
        $products->appends([
            'item' => 'product'
        ]);
        $data['products'] = $products;

        return view(theme('partials.new_user_zone_paginate_data._new_user_zone_product_paginate'),$data);

    }

    public function fetchCategoryData(Request $request, $slug){

        $category = $this->newUserZoneService->getCategoryById($request->parent_data);

        return view(theme('partials.new_user_zone_paginate_data._category_product_with_paginate'),compact('category'));
    }

    public function fetchAllCategoryData($slug){
        $allCategoryProducts = $this->newUserZoneService->getAllProductsForCategories($slug);
        return view(theme('partials.new_user_zone_paginate_data._category_all_product_with_paginate'),compact('allCategoryProducts'));
    }

    public function fetchAllCouponCategoryData($slug){
        $allCouponCategoryProducts = $this->newUserZoneService->getAllProductsForCouponCategories($slug);
        return view(theme('partials.new_user_zone_paginate_data._coupon_category_all_product_with_paginate'),compact('allCouponCategoryProducts'));
    }

    public function fetchCouponCategoryData(Request $request, $slug){
        $category = $this->newUserZoneService->getCouponCategoryById($request->parent_data);

        return view(theme('partials.new_user_zone_paginate_data._coupon_category_product_with_paginate'),compact('category'));
    }

    public function couponStore(Request $request, $slug){

        $coupon = Coupon::findOrFail($request->coupon_id);

        if(isset($coupon)){

            if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                $this->newUserZoneService->couponStore($request->except('_token'));
                LogActivity::successLog('coupon store successful.');
                $new_user_zone = $this->newUserZoneService->getById($slug);
                $coupon = $new_user_zone->coupon;
                $coupon_store_check = 0;
                if(auth()->check()){
                    $is_coupon = CustomerCouponStore::where('coupon_id', $new_user_zone->coupon->coupon->id)->first();
                    if(isset($is_coupon)){
                        $coupon_store_check = 1;
                    }else{
                        $coupon_store_check == 0;
                    }
                }
                return view(theme('partials.new_user_zone_paginate_data._coupon_code'),compact('coupon', 'coupon_store_check'));
            }else{
                return response()->json([
                    'error' => 'Coupon Is Expired.'
                ]);
            }
        }else{
            return response()->json([
                'error' => 'Coupon Is Invalid.'
            ]);
        }

    }
}
