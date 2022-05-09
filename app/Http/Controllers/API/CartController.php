<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
/**
* @group Cart
*
* APIs for customer cart
*/
class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;

    }

    /**
     * Cart List
     * @response{
     *      "carts": {
     *           "4": [
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
     *                   "is_select": 0,
     *                   "shipping_method_id": 2,
     *                   "created_at": "2021-06-10T12:29:09.000000Z",
     *                   "updated_at": "2021-06-10T12:29:09.000000Z",
     *                   "product": {
     *                       
     *                   },
     *                   "shipping_method": {
     *                       "id": 1,
     *                       "method_name": "Email Delivery (within 24 Hours)",
     *                       "logo": null,
     *                       "phone": null,
     *                       "shipment_time": "12-24 hrs",
     *                       "cost": 0,
     *                       "is_active": 1,
     *                       "created_at": null,
     *                       "updated_at": null
     *                   },
     *                   "seller": {
     *                       seller info
     *                       
     *                   },
     *                   "customer": {
     *                   customer info...
     *                   },
     *                   "gift_card": {
     *                       giftcard info....
     *                   },
     *                   "product": {
     *                       product info...
     *                   }
     *               }
     *           ]
     *       },
     *      "shipping_charge" : "90"
     *      ,
     *       "message": "success"
     * }
     */
    
    public function list(Request $request){

        $cart_ids = Cart::where('user_id',$request->user()->id)->where('product_type', 'product')->whereHas('product', function($query){
            return $query->where('status', 1)->whereHas('product', function($q){
                return $q->where('status', 1)->activeSeller();
            });
        })->orWhere('user_id',$request->user()->id)->where('product_type', 'gift_card')->whereHas('giftCard', function($query){
            return $query->where('status', 1);
        })->pluck('id')->toArray();

        $query = Cart::with('shippingMethod','seller', 'customer','giftCard','product.product.product','product.sku','product.product.product.shippingMethods.shippingMethod','product.product_variations.attribute', 'product.product_variations.attribute_value.color')->whereIn('id',$cart_ids)->where('is_select', 1)->get();
        $carts = $query->groupBy('seller_id');
        $recs = new \Illuminate\Database\Eloquent\Collection($query);
        $recs = new \Illuminate\Database\Eloquent\Collection($query);
        $grouped = $recs->groupBy('seller_id')->transform(function($item, $k) {
            return $item->groupBy('shipping_method_id');
        });

        $shipping_charge = 0;
        $method_shipping_cost = 0;
        $additional_charge = 0;
        foreach($grouped as $key => $group){
            foreach($group as $key=> $item){
                 $method_shipping_cost += $item[0]->shippingMethod->cost;
                 foreach($item as $key => $data){
                    if($data->product_type != "gift_card" && $data->product->sku->additional_shipping > 0){
                        $additional_charge +=  $data->product->sku->additional_shipping;
                    }
                 }
            }

        }
        $shipping_charge = $method_shipping_cost + $additional_charge;


        if(count($carts) > 0){
            return response()->json([
                'carts' => $carts,
                'shipping_charge' => $shipping_charge,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'cart is empty',
                'shipping_charge' => $shipping_charge,
            ],404);
        }
    }

    /**
     * Add to cart
     * 
     * @bodyParam product_id number required product sku id
     * @bodyParam qty number required product quantity
     * @bodyParam price number required product price
     * @bodyParam seller_id number required seller id
     * @bodyParam shipping_method_id number required shipping method id
     * @bodyParam product_type string required product or giftcard
     * 
     * @response 201{
     *      'message' : 'product added succcessfully'
     * }
     */

    public function addToCart(Request $request){
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'product_type' => 'required',
            'seller_id' => 'required',
            'shipping_method_id' => 'required',
        ]);
        
        $customer = $request->user();
        $total_price = $request->price*$request->qty;
        if($customer){
            $product = Cart::where('user_id',$customer->id)->where('product_id',$request->product_id)->where('product_type',$request->product_type)->first();
            if($product){
                $product->update([
                    'qty' => $product->qty+$request->qty,
                    'total_price' => $product->total_price + $total_price
                ]);
            }else{
                Cart::create([
                    'user_id' => $customer->id,
                    'product_type' => ($request->product_type == 'gift_card') ? 'gift_card' : 'product',
                    'product_id' => $request->product_id,
                    'price' => $request->price,
                    'qty' => $request->qty,
                    'total_price' => $total_price,
                    'seller_id' => $request->seller_id,
                    'shipping_method_id' => $request->shipping_method_id,
                    'sku' => null,
                    'is_select' => 1
                ]);
            }

            return response()->json([
                'message' => 'product added succcessfully'
            ], 201);

        }else{
            return response()->json([
                'message' => 'Unauthenticated.'
            ]);
        }
    }

    /**
     * Remove From Cart
     * @bodyParam id number required item id
     * 
     * @response 203{
     *      'message' : 'removed successfully'
     * }
     * 
     */

    public function removeFromCart(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $cart = Cart::where('user_id',$request->user()->id)->where('id', $request->id)->first();
        if($cart){
            $cart->delete();
            return response()->json([
                'message' => 'removed successfully'
            ],203);
        }else{
            return response()->json([
                'message' => 'cart item not found'
            ], 404);
        }

    }

    /**
     * Remove All from cart
     * @response 203{
     *     'message' : 'removed all successfully' 
     * }
     */

    public function removeAllFromCart(Request $request){
        $carts = Cart::where('user_id', $request->user()->id)->pluck('id');
        if(count($carts) > 0){
            Cart::destroy($carts);

            return response()->json([
                'message' => 'removed all successfully'
            ], 203);
        }else{
            return response()->json([
                'message' => 'cart is empty'
            ]);
        }
        
    }

    /**
     * Select Unselect Cart Item
     * 
     * @bodyParam id number required item id
     * @bodyParam checked boolean required checked or not
     * 
     * @response{
     *      'message' : 'select successfully'
     * }
     * 
     */

    public function selectItem(Request $request){
        $request->validate([
            'id' => 'required',
            'checked' => 'required'
        ]);

        $product = Cart::where('user_id', $request->user()->id)->where('id', $request->id)->first();
        if($product){
            $product->update([
                'is_select' => $request->checked
            ]);

            if($request->checked == 1){
                return response()->json([
                    'message' => 'select successfully'
                ],200);
            }else{
                return response()->json([
                    'message' => 'unselect successfully'
                ],200);
            }
            
        }else{
            return response()->json([
                'message' => 'cart item not found'
            ],404);
        }
    }
    /**
     * Select unselect Seller Wise
     * @bodyParam seller_id number required seller id 
     * @bodyParam checked boolean required checked or not
     * @response{
     *      'messge' : 'select successfully'
     * }
     * 
     */

    public function selectSellerItem(Request $request){
        $request->validate([
            'seller_id' => 'required',
            'checked' => 'required'
        ]);
        
        $products = Cart::where('user_id',$request->user()->id)->where('seller_id', $request->seller_id)->get();
        if(count($products) > 0){
            foreach($products as $key => $product){
                $product->update([
                    'is_select' => $request->checked
                ]);
            }
            if($request->checked == 1){
                return response()->json([
                    'messge' => 'select successfully'
                ],200);
            }else{
                return response()->json([
                    'messge' => 'unselect successfully'
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'product not found'
            ],404);
        }
    }

    /**
     * Select unselect All Item
     * @bodyParam checked boolean required checked or not
     * @response{
     *     'messge' : 'select successfully'
     * }
     */

    public function selectAll(Request $request){
        $request->validate([
            'checked' => 'required'
        ]);
        $products = Cart::where('user_id',$request->user()->id)->get();
        if(count($products) > 0){
            foreach($products as $key => $product){
                $product->update([
                    'is_select' => $request->checked
                ]);
            }
            if($request->checked == 1){
                return response()->json([
                    'messge' => 'select successfully'
                ],200);
            }else{
                return response()->json([
                    'messge' => 'unselect successfully'
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'product not found'
            ],404);
        }
    }

    /**
     * Quantity update
     * @bodyParam id number required item id
     * @bodyParam qty number required item quantity
     * @response 202{
     *      'message' : 'qty updated successfully'
     * }
     * 
     */

    public function updateQty(Request $request){
        $request->validate([
            'id' => 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        $product = Cart::where('user_id', $request->user()->id)->where('id', $request->id)->first();
        if($product){
            $product->update([
                'qty' => $request->qty,
                'total_price' => $request->qty * $product->price
            ]);

            return response()->json([
                'message' => 'qty updated successfully'
            ],202);
            
        }else{
            return response()->json([
                'message' => 'cart item not found'
            ],404);
        }
    }

    /**
     * Shipping method update update
     * @bodyParam id number required item id
     * @bodyParam shipping_method_id number required shipping method id
     * @response 202{
     *      'message' : 'shipping method updated successfully'
     * }
     * 
     */

    public function updateShippingMethod(Request $request){
        $request->validate([
            'id' => 'required',
            'shipping_method_id' => 'required'
        ]);

        $product = Cart::where('user_id', $request->user()->id)->where('id', $request->id)->first();
        if($product){
            $product->update([
                'shipping_method_id' => $request->shipping_method_id,
            ]);

            return response()->json([
                'message' => 'shipping method updated successfully'
            ],202);
            
        }else{
            return response()->json([
                'message' => 'cart item not found'
            ],404);
        }
    }
}
