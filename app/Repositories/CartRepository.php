<?php
namespace App\Repositories;

use App\Models\Cart;
use App\Traits\GoogleAnalytics4;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ShippingMethod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Modules\GiftCard\Entities\GiftCard;

class CartRepository{

    use GoogleAnalytics4;
    protected $cart;

    public function __construct(Cart $cart){
        $this->cart = $cart;
    }


    public function store_old($data){
        $customer = auth()->user();
        $total_price = $data['price']*$data['qty'];
        $is_out_of_stock = 0;
        if($customer){
            $product = $this->cart::where('user_id',$customer->id)->where('product_id',$data['product_id'])->where('seller_id', $data['seller_id'])->where('product_type',$data['type'])->first();


            if($data['type'] == 'product' && $product){
                $sku = SellerProductSKU::where('id', $data['product_id'])->first();
                if($sku->product_stock <= $sku->product->product->minimum_order_qty && $sku->product->stock_manage == 1){
                    $is_out_of_stock = 1;
                }
            }

            if($is_out_of_stock == 0){
                if($product){
                    $product->update([
                        'qty' => $product->qty+$data['qty'],
                        'total_price' => $product->total_price + $total_price
                    ]);
                }else{
                    $this->cart::create([
                        'user_id' => $customer->id,
                        'product_type' => ($data['type'] == 'gift_card') ? 'gift_card' : 'product',
                        'product_id' => $data['product_id'],
                        'price' => $data['price'],
                        'qty' => $data['qty'],
                        'total_price' => $total_price,
                        'seller_id' => $data['seller_id'],
                        'shipping_method_id' => $data['shipping_method_id'],
                        'sku' => null,
                        'is_select' => 1
                    ]);
                }
            }else{
                return 'out_of_stock';
            }

        }else{

            $cartData = [];
            $cartData['product_type'] = ($data['type'] == 'gift_card') ? 'gift_card' : 'product';
            $cartData['product_id'] = intval($data['product_id']);
            $cartData['cart_id'] = rand(1111,1000000).Str::random(40);
            $cartData['price'] = intval($data['price']);
            $cartData['qty'] = intval($data['qty']);
            $cartData['total_price'] = $data['price']*$data['qty'];
            $cartData['seller_id'] = intval($data['seller_id']);
            $cartData['shipping_method_id'] = intval($data['shipping_method_id']);
            $cartData['sku'] = null;
            $cartData['is_select'] = 1;

            if(Session::has('cart')){
                $foundInCart = false;
                $cart = collect();

                foreach (Session::get('cart') as $key => $cartItem){
                    if($cartItem['product_id'] == $data['product_id']){
                        if($data['type'] == 'product'){
                            $sku = SellerProductSKU::where('id', $data['product_id'])->first();
                            if($sku->product_stock <= $sku->product->product->minimum_order_qty && $sku->product->stock_manage == 1){
                                $is_out_of_stock = 1;
                            }
                        }
                    }

                    if($is_out_of_stock == 0){
                        if($cartItem['product_id'] == $data['product_id'] && $cartItem['shipping_method_id'] == $data['shipping_method_id'] && $cartItem['product_type'] == $data['type'] && $cartItem['seller_id'] == $data['seller_id']){

                            $foundInCart = true;
                            $cartItem['qty'] += $cartData['qty'];
                            $cartItem['total_price'] +=$cartData['total_price'];
                        }
                        $cart->push($cartItem);
                    }else{
                        return 'out_of_stock';
                    }

                }

                if (!$foundInCart) {
                    $cart->push($cartData);
                }
                Session::put('cart', $cart);
            }
            else{
                $cart = collect([$cartData]);
                Session::put('cart', $cart);
            }
        }
    }

    public function store($data){

        $total_price = $data['price']*$data['qty'];
        $is_out_of_stock = 0;
        if(auth()->check()){
            $product = $this->cart::where('user_id',auth()->id())->where('product_id',$data['product_id'])->where('seller_id', $data['seller_id'])->where('product_type',$data['type'])->first();
        }else{
            $product = $this->cart::where('session_id',session()->getId())->where('product_id',$data['product_id'])->where('seller_id', $data['seller_id'])->where('product_type',$data['type'])->first();
        }


        if($data['type'] == 'product' && $product){
            $sku = SellerProductSKU::where('id', $data['product_id'])->first();
            if($sku->product_stock <= $sku->product->product->minimum_order_qty && $sku->product->stock_manage == 1){
                $is_out_of_stock = 1;
            }
        }

        if($is_out_of_stock == 0){
            if($product){
                $product->update([
                    'qty' => $product->qty+$data['qty'],
                    'total_price' => $product->total_price + $total_price
                ]);
            }else{
                $user_id = null;
                $session_id = null;
                if(auth()->check()){
                    $user_id = auth()->id();
                }else{
                    $session_id = session()->getId();
                }
                $this->cart::create([
                    'user_id' => $user_id,
                    'session_id' => $session_id,
                    'product_type' => ($data['type'] == 'gift_card') ? 'gift_card' : 'product',
                    'product_id' => $data['product_id'],
                    'price' => $data['price'],
                    'qty' => $data['qty'],
                    'total_price' => $total_price,
                    'seller_id' => $data['seller_id'],
                    'shipping_method_id' => $data['shipping_method_id'],
                    'sku' => null,
                    'is_select' => 1
                ]);
                //ga4
                if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
                    $e_productName = 'Product';
                    $e_sku = 'sku';
                    if($data['type'] == 'product'){
                        $product = SellerProductSKU::find($data['product_id']);
                        if($product){
                            $e_productName = $product->product->product_name;
                            $e_sku = $product->sku->sku;
                        }
                    }else{
                        $product = GiftCard::find($data['product_id']);
                        if($product){
                            $e_productName = $product->name;
                            $e_sku = $product->sku;

                        }
                    }
                    $eData = [
                        'name' => 'add_to_cart',
                        'params' => [
                            "currency" => currencyCode(),
                            "value"=> 1,
                            "items" => [
                                [
                                    "item_id"=> $e_sku,
                                    "item_name"=> $e_productName,
                                    "currency"=> currencyCode(),
                                    "price"=> $data['price']
                                ]
                            ],
                        ],
                    ];
                    $this->postEvent($eData);
                }
                //end ga4
            }
        }else{
            return 'out_of_stock';
        }

    }

    public function update($data){
        if($data['cart_id']){
            foreach($data['cart_id'] as $key => $id){
                $cart = Cart::where('id', $id)->first();
                $cart->update([
                    'qty' => $data['qty'][$key],
                    'total_price' => $cart->price * $data['qty'][$key]
                ]);
            }
            return true;
        }
        return false;
    }

    public function updateCartShippingInfo($data){
        if (auth()->check()) {
            $product =  $this->cart::findOrFail($data['cartId']);
            $product->update([
                'shipping_method_id' => $data['shipping_method_id']
            ]);
        }else {
            if(Session::has('cart')){
                $cart = session()->get('cart', collect([]));
                $cart = $cart->map(function ($object, $key) use ($data) {
                    if($object['cart_id'] == $data['cartId']){
                        $object['shipping_method_id'] = intval($data['shipping_method_id']);
                    }
                    return $object;
                });
                Session::put('cart', $cart);
            }
        }
    }

    public function getCartData(){
        $cart_ids =[];
        if(auth()->check()){
            $cart_ids = $this->cart::where('user_id',auth()->user()->id)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('user_id',auth()->user()->id)->where('product_type', 'gift_card')->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->pluck('id')->toArray();
        }else{
            $cart_ids = $this->cart::where('session_id',session()->getId())->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('session_id',session()->getId())->where('product_type', 'gift_card')->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->pluck('id')->toArray();
        }
        $query = $this->cart::with('product.product')->whereIn('id',$cart_ids)->where('is_select', 1)->get();
        $cartData = $query->groupBy('seller_id');
        
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

        return [
            'shipping_charge' => $shipping_charge,
            'cartData' => $cartData
        ];

    }

    function group_by($key, $data) {
        $result = array();
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }


    public function updateQty($data){

        $product =  $this->cart::findOrFail($data['id']);

        $product->update([
            'qty' => $data['qty'],
            'total_price' => $product->price *$data['qty']
        ]);
        return 1;
    }

    public function selectAll($data){
        $carts = [];
        if(auth()->check()){
            $carts = $this->cart::where('user_id',auth()->user()->id)->get();

        }else{
            $carts = $this->cart::where('session_id',session()->getId())->get();
        }

        foreach($carts as $key => $cart){
            $cart->update([
                'is_select' => intval($data['checked'])
            ]);
        }

        return 1;
    }
    public function selectAllSeller($data){
        $carts = [];
        if(auth()->check()){
            $carts = $this->cart::where('user_id',auth()->user()->id)->get();

        }else{
            $carts = $this->cart::where('session_id',session()->getId())->get();
        }
        foreach($carts as $key => $cart){
            if($cart->seller_id == $data['seller_id']){
                $cart->update([
                    'is_select' => intval($data['checked'])
                ]);
            }
        }
        return 1;
    }
    public function selectItem($data){
        $cart = null;
        if(auth()->check()){
            $cart = $this->cart::where('user_id',auth()->user()->id)->where('product_id',$data['product_id'])->where('product_type', $data['product_type'])->firstorFail();
        }else{
            $cart = $this->cart::where('session_id',session()->getId())->where('product_id',$data['product_id'])->where('product_type', $data['product_type'])->firstorFail();
        }
        if($cart){
            $cart->update([
                'is_select' => intval($data['checked'])
            ]);
        }
        return 1;
    }

    public function deleteCartProduct($data){

        $cartItem = $this->cart::findOrFail($data['id']);

        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $e_productName = 'Product';
            $e_sku = 'sku';
            if($cartItem['product_type'] == 'product'){
                $product = SellerProductSKU::find($cartItem['product_id']);
                if($product){
                    $e_productName = $product->product->product_name;
                    $e_sku = $product->sku->sku;
                }
            }else{
                $product = GiftCard::find($cartItem['product_id']);
                if($product){
                    $e_productName = $product->name;
                    $e_sku = $product->sku;

                }
            }
            $eData = [
                'name' => 'remove_from_cart',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 1,
                    "items" => [
                        [
                            "item_id"=> $e_sku,
                            "item_name"=> $e_productName,
                            "currency"=> currencyCode(),
                            "price"=> $cartItem['price']
                        ]
                    ],
                ],
            ];
            $this->postEvent($eData);
        }
        //end ga4

        return $cartItem->delete();
    }
    public function deleteAll(){
        if(auth()->check()){
            $carts = $this->cart::where('user_id',auth()->user()->id)->get();

        }else{
            $carts = $this->cart::where('session_id',session()->getId())->get();
        }
        foreach($carts as $cart){
            $cart->delete();
        }
        return 1;
    }
}
