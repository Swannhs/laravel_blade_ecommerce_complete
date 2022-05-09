<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\GST\Entities\GstTax;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Marketing\Entities\CouponUse;
/**
* @group Checkout
*
* APIs for customer Checkout
*/
class CheckoutController extends Controller
{
    /**
     * Checkout product list
     * @response{
     * "items": {
     *       "4": {
     *           "2": [
     *               {
     *                   "id": 1,
     *                   "user_id": 5,
     *                   "seller_id": 4,
     *                   "product_type": "product",
     *                   "product_id": 7,
     *                   "qty": 1,
     *                   "price": 6550,
     *                   "total_price": 6550,
     *                   "sku": null,
     *                   "is_select": 1,
     *                   "shipping_method_id": 2,
     *                   "created_at": "2021-06-10T12:29:09.000000Z",
     *                   "updated_at": "2021-06-12T04:25:20.000000Z",
     *                    "seller" : {
     *                      seller info....
     *                    },
     *                    "customer" : {
     *                      customer info....
     *                    },
     *                    "giftCard" : {
     *                      giftCard info....
     *                    },
     *                   "product": {
     *                       "id": 7,
     *                       "user_id": 4,
     *                       "product_id": 3,
     *                       "product_sku_id": "4",
     *                       "product_stock": 0,
     *                       "purchase_price": 0,
     *                       "selling_price": 6600,
     *                       "status": 1,
     *                       "created_at": "2021-05-29T10:28:14.000000Z",
     *                       "updated_at": "2021-05-30T04:32:25.000000Z",
     *                       "product": {
     *                           "id": 3,
     *                           "user_id": 4,
     *                           "product_id": 3,
     *                           "tax": 15,
     *                           "tax_type": "0",
     *                           "discount": 50,
     *                           "discount_type": "1",
     *                           "discount_start_date": "05/01/2021",
     *                           "discount_end_date": "06/30/2021",
     *                           "product_name": "KTM RC 390",
     *                           "slug": "ktm-rc-390-4",
     *                           "thum_img": null,
     *                           "status": 1,
     *                           "stock_manage": 0,
     *                           "is_approved": 0,
     *                           "min_sell_price": 6500,
     *                           "max_sell_price": 6500,
     *                           "total_sale": 1,
     *                           "avg_rating": 0,
     *                           "recent_view": "2021-05-29 16:28:14",
     *                           "created_at": "2021-05-29T10:28:14.000000Z",
     *                           "updated_at": "2021-05-30T04:29:14.000000Z",
     *                           "variantDetails": [],
     *                           "MaxSellingPrice": 6600,
     *                           "hasDeal": {
     *                               "id": 2,
     *                               "flash_deal_id": 1,
     *                               "seller_product_id": 3,
     *                               "discount": 50,
     *                               "discount_type": 1,
     *                               "status": 1,
     *                               "created_at": "2021-06-01T12:56:18.000000Z",
     *                               "updated_at": "2021-06-01T13:08:58.000000Z"
     *                           },
     *                           "rating": 0,
     *                           "product": {
     *                               "id": 3,
     *                               "product_name": "KTM RC 390",
     *                               "product_type": 1,
     *                               "unit_type_id": 1,
     *                               "brand_id": 2,
     *                               "category_id": 5,
     *                               "thumbnail_image_source": "uploads/images/29-05-2021/60b1e99781fbb.png",
     *                               "barcode_type": "C39",
     *                               "model_number": "ktm-rc-390",
     *                               "shipping_type": 0,
     *                               "shipping_cost": 0,
     *                               "discount_type": "1",
     *                               "discount": 0,
     *                               "tax_type": "0",
     *                               "tax": 15,
     *                               "pdf": null,
     *                               "video_provider": "youtube",
     *                               "video_link": null,
     *                               "description": "<p>test product</p>",
     *                               "specification": "<p>test product</p>",
     *                               "minimum_order_qty": 1,
     *                               "max_order_qty": 5,
     *                               "meta_title": null,
     *                               "meta_description": null,
     *                               "meta_image": null,
     *                               "is_physical": 1,
     *                               "is_approved": 1,
     *                               "display_in_details": 1,
     *                               "requested_by": 1,
     *                               "created_by": 1,
     *                               "slug": "ktm-rc-390",
     *                               "updated_by": null,
     *                               "created_at": "2021-05-29T07:13:28.000000Z",
     *                               "updated_at": "2021-05-29T07:13:28.000000Z"
     *                           },
     *                           "skus": [
     *                               {
     *                                   "id": 7,
     *                                   "user_id": 4,
     *                                   "product_id": 3,
     *                                   "product_sku_id": "4",
     *                                   "product_stock": 0,
     *                                   "purchase_price": 0,
     *                                   "selling_price": 6600,
     *                                   "status": 1,
     *                                   "created_at": "2021-05-29T10:28:14.000000Z",
     *                                   "updated_at": "2021-05-30T04:32:25.000000Z",
     *                                   "product_variations": []
     *                               }
     *                           ],
     *                           "reviews": []
     *                       }
     *                   },
     *                   "shipping_method": {
     *                       "id": 2,
     *                       "method_name": "Flat",
     *                       "logo": null,
     *                       "phone": null,
     *                       "shipment_time": "0-3 days",
     *                       "cost": 0,
     *                       "is_active": 1,
     *                       "created_at": null,
     *                       "updated_at": null
     *                   }
     *               }
     *           ]
     *       }
     *   },
     *  "same_state_gst_list": [
     *      same state gst info....
     *  ],
     *  "differant_state_gst_list": [
     *      differant state gst info....
     *  ],
     *
     *  "flat_gst": {
     *      flat gst info...
     *  },
     *
     *  "is_gst_enable": 0,
     *  "is_gst_module_enable": 1,
     *
     *   "message": "success"
     * }
     */

    public function list(Request $request){

        $query = Cart::where('user_id', $request->user()->id)->where('product_type', 'product')->where('is_select',1)->whereHas('product', function($query){
            return $query->where('status', 1)->whereHas('product', function($q){
                return $q->where('status', 1)->activeSeller();
            });
        })->orWhere('product_type', 'gift_card')->where('user_id', $request->user()->id)->where('is_select',1)->whereHas('giftCard', function($query){
            return $query->where('status', 1);
        });
        if(isModuleActive('MultiVendor')){
            $query = $query->with('shippingMethod', 'seller.SellerBusinessInformation', 'customer.customerShippingAddress', 'giftCard', 'product.product.product', 'product.sku', 'product.product_variations.attribute', 'product.product_variations.attribute_value.color')->where('is_select', 1)->get();
        }else{
            $query = $query->with('shippingMethod', 'customer.customerShippingAddress', 'giftCard', 'product.product.product', 'product.sku', 'product.product_variations.attribute', 'product.product_variations.attribute_value.color')->where('is_select', 1)->get();
        }
        $same_state_gst_list = GstTax::whereIn('id', app('gst_config')['within_a_single_state'])->get();
        $differant_state_gst_list = GstTax::whereIn('id', app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
        $flat_gst = GstTax::where('id', app('gst_config')['flat_tax_id'])->first();
        $is_gst_enable = 0;
        $is_gst_module_enable = 0;
        if(file_exists(base_path().'/Modules/GST/')){
            $is_gst_module_enable = 1;
        }
        if(app('gst_config')['enable_gst'] == "gst"){
            $is_gst_enable = 1;
        }
        if(count($query) > 0){
            $recs = new \Illuminate\Database\Eloquent\Collection($query);
            $cartItems = $recs->groupBy('seller_id')->transform(function($item, $k) {
                return $item->groupBy('shipping_method_id');
            });

            return response()->json([
                'items' => $cartItems,
                'same_state_gst_list' => $same_state_gst_list,
                'differant_state_gst_list' => $differant_state_gst_list,
                'flat_gst' => $flat_gst,
                'is_gst_enable' => $is_gst_enable,
                'is_gst_module_enable' => $is_gst_module_enable,
                'message' => 'success'
            ]);
        }else{
            return response()->json([
                'message' => 'select cart item first'
            ], 404);
        }

    }

    /**
     * Checkout coupon apply
     * @bodyParam coupon_code string required Code from coupon
     * @bodyParam shopping_amount double required Amount of shopping
     *
     * @response{
     * "coupon": {
     *       "id": 2,
     *       "title": "coupon on product",
     *       "coupon_code": "356966565645656",
     *       "coupon_type": 1,
     *       "start_date": "2021-06-06",
     *       "end_date": "2021-07-31",
     *       "discount": 20,
     *       "discount_type": 1,
     *       "minimum_shopping": null,
     *       "maximum_discount": null,
     *       "created_by": 1,
     *       "updated_by": null,
     *       "is_expire": 0,
     *       "is_multiple_buy": 1,
     *       "created_at": "2021-06-07T10:54:27.000000Z",
     *       "updated_at": "2021-06-07T10:54:27.000000Z"
     *   },
     *   "message": "success"
     * }
     */

    public function couponApply(Request $request){

        $request->validate([
            'coupon_code' => 'required',
            'shopping_amount' => 'required',
        ]);

        $coupon = Coupon::with('products.product')->where('coupon_code',$request->coupon_code)->first();

        if(isset($coupon)){
            if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                if($coupon->is_multiple_buy){
                    if($coupon->coupon_type == 1){
                        $carts = Cart::where('user_id',$request->user()->id)->where('is_select',1)->pluck('product_id');
                        $products = CouponProduct::whereHas('product',function($query) use($carts){
                            return $query->whereHas('skus', function($q) use($carts){
                                return $q->whereIn('id', $carts);
                            });
                        })->pluck('product_id');

                        if(count($products) > 0){
                            return response()->json([
                                'coupon' =>$coupon,
                                'message' => 'success'
                            ]);

                        }else{
                            return response()->json([
                                'error' => 'This Coupon is not available for selected products'
                            ]);
                        }

                    }elseif($coupon->coupon_type == 2){
                        if($request->shopping_amount < $coupon->minimum_shopping){
                            return response()->json([
                                'error' => 'You Have more purchase to get This Coupon.'
                            ]);
                        }else{
                            return response()->json([
                                'coupon' =>$coupon,
                                'message' => 'success'
                            ]);
                        }
                    }elseif($coupon->coupon_type == 3){
                        return response()->json([
                            'coupon' =>$coupon,
                            'message' => 'success'
                        ]);
                    }
                }else{
                    if(CouponUse::where('user_id',$request->user()->id)->where('coupon_id',$coupon->id)->first() == null){
                        if($coupon->coupon_type == 1){
                            $carts = Cart::where('user_id',auth()->user()->id)->where('is_select',1)->pluck('product_id');
                            $products = CouponProduct::whereHas('product',function($query) use($carts){
                                return $query->whereHas('skus', function($q) use($carts){
                                    return $q->whereIn('id', $carts);
                                });
                            })->pluck('product_id');
                            if(count($products) > 0){
                                return response()->json([
                                    'coupon' =>$coupon,
                                    'message' => 'success'
                                ]);
                            }else{
                                return response()->json([
                                    'error' => 'This Coupon is not available for selected products'
                                ]);
                            }

                        }elseif($coupon->coupon_type == 2){
                            if($request->shopping_amount < $coupon->minimum_shopping){
                                return response()->json([
                                    'error' => 'You Have more purchase to get This Coupon.'
                                ]);
                            }else{
                                return response()->json([
                                    'coupon' =>$coupon,
                                    'message' => 'success'
                                ]);
                            }

                        }elseif($coupon->coupon_type == 3){
                            return response()->json([
                                'coupon' =>$coupon,
                                'message' => 'success'
                            ]);
                        }

                    }else{
                        return response()->json([
                            'error' => 'This coupon already used'
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'error' => 'coupon is expired'
                ]);
            }
        }else{
            return response()->json([
                'error' => 'invalid Coupon'
            ]);
        }

    }

}
