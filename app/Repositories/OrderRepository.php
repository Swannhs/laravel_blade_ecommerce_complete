<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Models\OrderProductDetail;
use App\Models\OrderPayment;
use App\Models\GuestOrderDetail;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponUse;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Marketing\Entities\ReferralUse;
use Modules\Wallet\Entities\BankPayment;
use \Modules\Wallet\Repositories\WalletRepository;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\GST\Entities\OrderPackageGST;
use Modules\GiftCard\Entities\GiftCard;

class OrderRepository
{
    use GoogleAnalytics4;
    public function myPurchaseOrderList()
    {
        return Order::with('customer', 'packages', 'packages.products')->where('customer_id', auth()->user()->id)->latest()->paginate(8, ['*'], 'myPurchaseOrderList');
    }

    public function myPurchaseOrderListwithRN($data)
    {
        return Order::with('customer', 'packages', 'packages.products')->where('customer_id', auth()->user()->id)->latest()->paginate($data, ['*'], 'myPurchaseOrderList');
    }

    public function myPurchaseOrderListNotPaid()
    {
        return Order::with('customer', 'packages', 'packages.products')->where('customer_id', auth()->user()->id)->where('is_paid', 0)->latest()->paginate(8, ['*'], 'myPurchaseOrderListNotPaid');
    }

    public function myPurchaseOrderPackageListRecieved()
    {
        $customer_id = auth()->user()->id;
        return OrderPackageDetail::whereHas('order', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        })->where('delivery_status', 3)->latest()->paginate(8, ['*'], 'toRecievedList');
    }

    public function myPurchaseOrderPackageListShipped()
    {
        $customer_id = auth()->user()->id;
        return OrderPackageDetail::whereHas('order', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        })->where('delivery_status', 2)->latest()->paginate(8, ['*'], 'toShipped');
    }

    public function orderFindByID($id)
    {
        return Order::with('customer', 'packages', 'packages.seller', 'packages.delivery_states', 'shipping_address', 'billing_address', 'packages.products', 'packages.products.seller_product_sku.product_variations')->findOrFail($id);
    }

    public function orderFindByOrderID($order_id)
    {
        return Order::with('customer', 'packages', 'packages.seller', 'packages.delivery_states', 'shipping_address', 'billing_address', 'packages.products', 'packages.products.seller_product_sku.product_variations')->where('order_number',$order_id)->first();
    }

    public function orderPackageFindByID($id)
    {
        return OrderPackageDetail::findOrFail($id);
    }

    public function orderFindByOrderNumber($data, $user = null)
    {
        $order = null;
        if ($user != null) {
            $order = Order::with('customer', 'packages.seller', 'packages.delivery_states', 'shipping_address', 'billing_address', 'packages.products.seller_product_sku.product.product', 'packages.products.seller_product_sku.product_variations.attribute', 'packages.products.seller_product_sku.product_variations.attribute_value.color', 'packages.products.seller_product_sku.sku')
                ->where('order_number', $data['order_number'])->where('customer_id', $user->id)->orWhere('order_number', $data['order_number'])->where('customer_id', null)
                ->first();
        } else {
            $order = Order::with('customer', 'packages.seller', 'packages.delivery_states', 'shipping_address', 'billing_address', 'packages.products.seller_product_sku.product.product', 'packages.products.seller_product_sku.product_variations.attribute', 'packages.products.seller_product_sku.product_variations.attribute_value.color', 'packages.products.seller_product_sku.sku')
                ->where('order_number', $data['order_number'])->where('customer_id', null)
                ->first();
        }

        if ($order) {
            if ($order->customer_id) {
                return $order;
            } else {

                if (app('general_setting')->track_order_by_secret_id) {
                    if (isset($data['secret_id']) && $order->guest_info->guest_id == $data['secret_id']) {
                        return $order;
                    }elseif(auth()->check()){
                        return $order;
                    }
                     else {
                        return "Invalid Secret ID";
                    }
                } else {
                    return $order;
                }
            }
        } else {
            return "Invalid Tracking ID";
        }
    }

    public function orderStore($data)
    {
        $checkoutRepo = new CheckoutRepository();
        if (auth()->check()) {
            $query =  Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('user_id',auth()->user()->id)->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();

            $customer_email = $checkoutRepo->activeShippingAddress()->email;
            $customer_phone = $checkoutRepo->activeShippingAddress()->phone;
        } else {

            $query =  Cart::where('session_id',session()->getId())->where('is_select',1)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('session_id',session()->getId())->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();

            $customer_email = $checkoutRepo->activeShippingAddress()->email;
            $customer_phone = $checkoutRepo->activeShippingAddress()->phone;
        }


        $recs = new \Illuminate\Database\Eloquent\Collection($query);

        if(isModuleActive('MultiVendor')){
            $productList = $recs->groupBy('seller_id')->transform(function($item, $k) {
                return $item->groupBy('shipping_method_id');
            });
        }else{
            $productList = $recs;
        }

        $billing_address_id = null;
        $shipping_address_id = null;
        if(auth()->check()){
            $shipping_address_id = $checkoutRepo->activeShippingAddress()->id;

            if($checkoutRepo->activeBillingAddress() == null){
                $billing_address_id = $shipping_address_id;
            }else{
                $billing_address_id = $checkoutRepo->activeBillingAddress()->id;
            }
        }

        $order = Order::create([
            'customer_id' => (auth()->check()) ? auth()->user()->id : null,
            'order_number' => rand(11, 99).date('ymdhis'),
            'payment_type' => $data['payment_method'],
            'is_paid' => ($data['payment_method'] == 2) ? 1 : 0,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_shipping_address' => $shipping_address_id,
            'customer_billing_address' => $billing_address_id,
            'grand_total' => $data['grand_total'],
            'sub_total' => $data['sub_total'],
            'discount_total' => $data['discount_total'],
            'shipping_total' => isModuleActive('MultiVendor')?collect($data['shipping_cost'])->sum():$data['shipping_cost'],
            'number_of_package' => $data['number_of_package'],
            'number_of_item' => $data['number_of_item'],
            'order_status' => 0,
            'order_payment_id' => ($data['order_payment_id'] != 0) ? $data['order_payment_id'] : null,
            'tax_amount' => $data['tax_total'],
            'note' => session()->has('order_note')?session()->get('order_note'):null
        ]);

        if (!auth()->check()) {
            $shipping_address = (object) session()->get('shipping_address');
            if(session()->has('billing_address')){
                $billing_address = (object) session()->get('billing_address');
            }else{
                $billing_address = $shipping_address;
            }
            GuestOrderDetail::create([
                'order_id' => $order->id,
                'guest_id' => $order->id . '-' . date('ymd-his'),
                'billing_name' => $billing_address->name,
                'billing_email' => $billing_address->email,
                'billing_phone' => $billing_address->phone,
                'billing_address' => $billing_address->address,
                'billing_city_id' => $billing_address->city,
                'billing_state_id' => $billing_address->state,
                'billing_country_id' => $billing_address->country,
                'billing_post_code' => $billing_address->postal_code,
                'shipping_name' => $shipping_address->name,
                'shipping_email' => $shipping_address->email,
                'shipping_phone' => $shipping_address->phone,
                'shipping_address' => $shipping_address->address,
                'shipping_city_id' => $shipping_address->city,
                'shipping_state_id' => $shipping_address->state,
                'shipping_country_id' => $shipping_address->country,
                'shipping_post_code' => $shipping_address->postal_code
            ]);
        }


        $val = 0;
        $e_items = [];
        if(isModuleActive('MultiVendor')){
            foreach ($productList as $key => $items) {
                $seller_id = $key;
                foreach ($items as $key => $products) {
                    $index_no = $val + 1;
                    $package = OrderPackageDetail::create([
                        'order_id' => $order->id,
                        'seller_id' => $seller_id,
                        'package_code' => 'TRK - ' . rand(4554555, 45754575),
                        'number_of_product' => count($products),
                        'shipping_cost' => $data['shipping_cost'][$val],
                        'shipping_date' => $data['delivery_date'][$val],
                        'shipping_method' => $data['shipping_method'][$val],
                        'tax_amount' => $data['packagewiseTax'][$val],
                        'delivery_status' => 1
                    ]);

                    // if (file_exists(base_path() . '/Modules/GST/')) {
                    //     if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax") {
                    //         if (!empty($data['gst_package_' . $index_no])) {
                    //             foreach ($data['gst_package_' . $index_no] as $k => $gst_id) {
                    //                 OrderPackageGST::create([
                    //                     'package_id' => $package->id,
                    //                     'gst_id' => $gst_id,
                    //                     'amount' => $data['gst_amounts_package_' . $index_no][$k],
                    //                 ]);
                    //             }
                    //         }
                    //     }
                    // }

                    $val++;

                    foreach ($products as $key => $product) {
                        if ($product->product_type == "gift_card") {
                            $seller_product = GiftCard::findOrFail($product->product_id);

                            if (isModuleActive('Affiliate') ) {
                                //if guest checkout process guest variable will be true otherwise false.
                                if(auth()->check() && auth()->user()->isReferralUser){
                                    Event::dispatch(new ReferralPayment(auth()->id(),$product->giftCard->id,$product->total_price));
                                }else{
                                    //if guest checkout process user_id will be 0
                                    Event::dispatch(new ReferralPayment(0,$product->giftCard->id,$product->total_price));
                                }
                            }

                            $e_items[]=[
                                "item_id"=> $product->gigtCard->sku,
                                "item_name"=> $product->gigtCard->name,
                                "currency"=> currencyCode(),
                                "price"=> $product->price
                            ];

                        } else {
                            $seller_product = SellerProductSKU::findOrFail($product->product_id)->product;
                            $seller_product->update([
                                'total_sale' => $seller_product->total_sale + $product->qty
                            ]);
                            if ($seller_product->product->category_id != null || $seller_product->product->category_id != 0) {
                                $category = $seller_product->product->category;
                                $seller_product->product->category->update(['total_sale' => $category->total_sale + $product->qty]);
                            }
                            if ($seller_product->product->brand_id != null || $seller_product->product->brand_id != 0) {
                                $brand = $seller_product->product->brand;
                                $seller_product->product->brand->update(['total_sale' => $brand->total_sale + $product->qty]);
                            }
                            if (isModuleActive('Affiliate') ) {
                                //if guest checkout process guest variable will be true otherwise false.
                                if(auth()->check() && auth()->user()->isReferralUser){
                                    Event::dispatch(new ReferralPayment(auth()->id(),$product->product->product->id,$product->total_price));
                                }else{
                                    //if guest checkout process user_id will be 0
                                    Event::dispatch(new ReferralPayment(0,$product->product->product->id,$product->total_price));
                                }
                            }
                            $e_items[]=[
                                "item_id"=> $product->product->sku->sku,
                                "item_name"=> $product->product->product->product_name,
                                "currency"=> currencyCode(),
                                "price"=> $product->price
                            ];
                        }



                        OrderProductDetail::create([
                            'package_id' => $package->id,
                            'type' => $product->product_type,
                            'product_sku_id' => $product->product_id,
                            'qty' => $product->qty,
                            'price' => $product->price,
                            'total_price' => $product->total_price,
                            'tax_amount' => ($product->product_type == "product") ? (tax_count($product->price, $product->product->product->tax, $product->product->product->tax_type) * $product->qty) : 0
                        ]);

                    }
                }
            }
        }
        //for single vendor
        else{
            $package = OrderPackageDetail::create([
                'order_id' => $order->id,
                'seller_id' => 1,
                'package_code' => 'TRK - ' . rand(4554555, 45754575),
                'number_of_product' => count($productList),
                'shipping_cost' => $data['shipping_cost'],
                'shipping_date' => $data['delivery_date'],
                'shipping_method' => $data['shipping_method'],
                'tax_amount' => $data['tax_total'],
                'delivery_status' => 1
            ]);
            foreach($productList as $key => $product){
                OrderProductDetail::create([
                    'package_id' => $package->id,
                    'type' => $product->product_type,
                    'product_sku_id' => $product->product_id,
                    'qty' => $product->qty,
                    'price' => $product->price,
                    'total_price' => $product->total_price,
                    'tax_amount' => 0
                ]);

                if($product->product_type == 'product'){
                    $e_items[]=[
                        "item_id"=> $product->product->sku->sku,
                        "item_name"=> $product->product->product->product_name,
                        "currency"=> currencyCode(),
                        "price"=> $product->price
                    ];
                }
                else{
                    $e_items[]=[
                        "item_id"=> $product->gigtCard->sku,
                        "item_name"=> $product->gigtCard->name,
                        "currency"=> currencyCode(),
                        "price"=> $product->price
                    ];
                }




                if (isModuleActive('Affiliate') ) {
                    if($product->product_type == 'product'){
                        //if guest checkout process guest variable will be true otherwise false.
                        if(auth()->check() && auth()->user()->isReferralUser){
                            Event::dispatch(new ReferralPayment(auth()->id(),$product->product->product->id,$product->total_price));
                        }else{
                            //if guest checkout process user_id will be 0
                            Event::dispatch(new ReferralPayment(0,$product->product->product->id,$product->total_price));
                        }
                    }else{
                        //if guest checkout process guest variable will be true otherwise false.
                        if(auth()->check() && auth()->user()->isReferralUser){
                            Event::dispatch(new ReferralPayment(auth()->id(),$product->giftCard->id,$product->total_price));
                        }else{
                            //if guest checkout process user_id will be 0
                            Event::dispatch(new ReferralPayment(0,$product->giftCard->id,$product->total_price));
                        }
                    }
                    
                }
            }
        }


        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $eData = [
                'name' => 'add_payment_info',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 1,
                    "payment_type"=> $data['payment_method'],
                    "items" => $e_items,
                ],
            ];
            $this->postEvent($eData);
        }
        //end ga4


        if (auth()->check()) {
            $carts = Cart::where('user_id', auth()->user()->id)->where('is_select', 1)->pluck('id');
            Cart::destroy($carts);
        }else{
            $carts = Cart::where('session_id',session()->getId())->where('is_select', 1)->pluck('id');
            Cart::destroy($carts);
        }
        // ga4
        $ga_transaction_id = 0;

        if ($data['payment_method'] == 1) {
            $order_payment = $this->orderPaymentDone($data['grand_total'], 1, "none", (auth()->check()) ? auth()->user() : null);
            $order->update([
                'order_payment_id' => $order_payment->id
            ]);
            // ga4
            $ga_transaction_id = $order_payment->id;
        }

        if ($data['payment_method'] == 2) {
            $user_type = (auth()->check()) ? "registered" : "guest";
            $customer_id = ($order->customer_id) ? $order->customer_id : $order->guest_info->id;
            $wallet_service = new WalletRepository;
            $wallet_service->cartPaymentData($order->id, $data['grand_total'], "Cart Payment", $customer_id, $user_type);
            $order_payment = $this->orderPaymentDone($data['grand_total'], 2, "none", (auth()->check()) ? auth()->user() : null);
            $order->update([
                'order_payment_id' => $order_payment->id
            ]);
            // ga4
            $ga_transaction_id = $order_payment->id;
        }


        if ($data['payment_method'] == 7) {
            $bank_details = BankPayment::find(session()->get("bank_detail_id"));
            $bank_details->itemable_id = $data['payment_id'];
            $bank_details->itemable_type = "App\Models\OrderPayment";
            $bank_details->save();
            session()->forget("bank_detail_id");
        }

        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $ga_transaction_id = $data['payment_id'];
            $eData = [
                'name' => 'purchase',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 12.21,
                    "transaction_id"=> $ga_transaction_id,
                    "items" => $e_items,
                ],
            ];
            $this->postEvent($eData);
        }
        //end ga4

        if (auth()->check()) {
            $referral_code = ReferralCode::where('user_id', auth()->user()->id)->first();
            if (!isset($referral_code)) {
                ReferralCode::create([
                    'user_id' => auth()->user()->id,
                    'referral_code' => auth()->user()->id . rand(111111111, 999999999),
                    'status' => 1
                ]);
            }
            $referral_use = ReferralUse::where('user_id', auth()->user()->id)->where('is_use', 0)->first();
            if (isset($referral_use)) {
            }

            if (isset($data['coupon_id'])) {
                $coupon = Coupon::findOrFail($data['coupon_id']);
                $couponUse = CouponUse::where('user_id', auth()->user()->id)->where('coupon_id', $data['coupon_id'])->first();
                if (isset($couponUse)) {
                    if ($coupon->is_multiple_buy == 1) {
                        CouponUse::create([
                            'user_id' => auth()->user()->id,
                            'coupon_id' => $data['coupon_id'],
                            'order_id' => $order->id,
                            'discount_amount' => $data['coupon_amount'],
                        ]);
                    }
                } else {
                    CouponUse::create([
                        'user_id' => auth()->user()->id,
                        'coupon_id' => $data['coupon_id'],
                        'order_id' => $order->id,
                        'discount_amount' => $data['coupon_amount'],
                    ]);
                }
            }
        }

        Session::forget('coupon_type');
        Session::forget('coupon_discount');
        Session::forget('coupon_discount_type');
        Session::forget('maximum_discount');
        Session::forget('maximum_products');
        Session::forget('coupon_id');
        Session::forget('order_note');
        Session::forget('billing_address');

        return $order;
    }


    public function orderStoreForAPI($user = null, $data)
    {

        if ($user != null) {
            $query = Cart::where('user_id', $user->id)->where('is_select', 1)->get();

            $recs = new \Illuminate\Database\Eloquent\Collection($query);
            $productList = $recs->groupBy('seller_id')->transform(function ($item, $k) {
                return $item->groupBy('shipping_method_id');
            });


            $customer_email = $data['customer_email'];
            $customer_phone = $data['customer_phone'];
        } else {
        }

        $order = Order::create([
            'customer_id' => ($user != null) ? $user->id : null,
            'order_number' => rand(11, 99) . date('ymdhis'),
            'payment_type' => $data['payment_method'],
            'is_paid' => 0,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_shipping_address' => ($user != null) ? $data['customer_shipping_address'] : null,
            'customer_billing_address' => ($user != null) ? $data['customer_billing_address'] : null,
            'grand_total' => $data['grand_total'],
            'sub_total' => $data['sub_total'],
            'discount_total' => $data['discount_total'],
            'shipping_total' => $data['shipping_total'],
            'number_of_package' => $data['number_of_package'],
            'number_of_item' => $data['number_of_item'],
            'order_status' => 0,
            'order_payment_id' => ($data['payment_id'] != 0) ? $data['payment_id'] : null,
            'tax_amount' => $data['tax_total']
        ]);


        $val = 0;
        foreach ($productList as $key => $items) {
            $seller_id = $key;
            foreach ($items as $key => $products) {
                $index_no = $val + 1;
                $package = OrderPackageDetail::create([
                    'order_id' => $order->id,
                    'seller_id' => $seller_id,
                    'package_code' => 'TRK - ' . rand(4554555, 45754575),
                    'number_of_product' => count($products),
                    'shipping_cost' => $data['shipping_cost'][$val],
                    'shipping_date' => $data['delivery_date'][$val],
                    'shipping_method' => $data['shipping_method'][$val],
                    'tax_amount' => $data['packagewiseTax'][$val],
                ]);

                if (file_exists(base_path() . '/Modules/GST/')) {
                    if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax") {
                        if (!empty($data['gst_package_' . $index_no])) {
                            foreach ($data['gst_package_' . $index_no] as $k => $gst_id) {
                                OrderPackageGST::create([
                                    'package_id' => $package->id,
                                    'gst_id' => $gst_id,
                                    'amount' => $data['gst_amounts_package_' . $index_no][$k],
                                ]);
                            }
                        }
                    }
                }


                $val++;

                if ($user != null) {
                    foreach ($products as $key => $product) {
                        if ($product->product_type == "gift_card") {
                            $seller_product = GiftCard::find($product->product_id);
                        } else {
                            $seller_product = SellerProductSKU::find($product->product_id)->product;
                            $seller_product->update([
                                'total_sale' => $seller_product->total_sale + $product->qty
                            ]);
                            if ($seller_product->product->category_id != null || $seller_product->product->category_id != 0) {
                                $category = $seller_product->product->category;
                                $seller_product->product->category->update(['total_sale' => $category->total_sale + $product->qty]);
                            }
                            if ($seller_product->product->brand_id != null || $seller_product->product->brand_id != 0) {
                                $brand = $seller_product->product->brand;
                                $seller_product->product->brand->update(['total_sale' => $brand->total_sale + $product->qty]);
                            }
                        }

                        $orer = OrderProductDetail::create([
                            'package_id' => $package->id,
                            'type' => $product['product_type'],
                            'product_sku_id' => $product->product_id,
                            'qty' => $product->qty,
                            'price' => $product->price,
                            'total_price' => $product->total_price,
                            'tax_amount' => ($product->product_type == "product") ? (tax_count($product->price, $product->product->product->tax, $product->product->product->tax_type) * $product->qty) : 0
                        ]);
                    }
                } else {
                    foreach ($products as $key => $product) {

                        if ($product['product_type'] == "gift_card") {
                            $seller_product = GiftCard::find($product['product_id']);
                        } else {
                            $seller_product = SellerProductSKU::find($product['product_id'])->product;
                            $seller_product->update([
                                'total_sale' => $seller_product->total_sale + $product['qty']
                            ]);
                            if ($seller_product->product->category_id != null || $seller_product->product->category_id != 0) {
                                $category = $seller_product->product->category;
                                $seller_product->product->category->update(['total_sale' => $category->total_sale + $product['qty']]);
                            }
                            if ($seller_product->product->brand_id != null || $seller_product->product->brand_id != 0) {
                                $brand = $seller_product->product->brand;
                                $seller_product->product->brand->update(['total_sale' => $brand->total_sale + $product['qty']]);
                            }
                        }

                        OrderProductDetail::create([
                            'package_id' => $package->id,
                            'type' => $product['product_type'],
                            'product_sku_id' => $product['product_id'],
                            'qty' => $product['qty'],
                            'price' => $product['price'],
                            'total_price' =>  $product['total_price'],
                            'tax_amount' => ($product->product_type == "product") ? (tax_count($product->price, $product->product->product->tax, $product->product->product->tax_type) * $product->qty) : 0
                        ]);
                    }
                }
            }
        }
        if ($user != null) {
            $carts = Cart::where('user_id', $user->id)->where('is_select', 1)->get();
            foreach ($carts as $cart) {
                $cart->delete();
            }
        }

        if ($data['payment_method'] == 1) {
            $order_payment = $this->orderPaymentDone($data['grand_total'], 1, "none", $user);
            $order->update([
                'order_payment_id' => $order_payment->id
            ]);
        }

        if ($data['payment_method'] == 2) {
            $user_type = ($user != null) ? "registered" : "guest";
            $customer_id = ($order->customer_id) ? $order->customer_id : $order->guest_info->id;
            $wallet_service = new WalletRepository;
            $wallet_service->cartPaymentData($order->id, $data['grand_total'], "Cart Payment", $customer_id, $user_type);
            $order_payment = $this->orderPaymentDone($data['grand_total'], 2, "none", $user);
            $order->update([
                'order_payment_id' => $order_payment->id
            ]);
        }

        if ($data['payment_method'] == 7) {
            $bank_details = BankPayment::find($data['bank_details_id']);
            $bank_details->itemable_id = $data['payment_id'];
            $bank_details->itemable_type = "App\Models\OrderPayment";
            $bank_details->save();
        }

        if ($user != null) {
            $referral_code = ReferralCode::where('user_id', $user->id)->first();
            if (!isset($referral_code)) {
                ReferralCode::create([
                    'user_id' => $user->id,
                    'referral_code' => $user->id . rand(111111111, 999999999),
                    'status' => 1
                ]);
            }
            $referral_use = ReferralUse::where('user_id', $user->id)->where('is_use', 0)->first();
            if (isset($referral_use)) {
            }

            if (isset($data['coupon_id'])) {
                $coupon = Coupon::findOrFail($data['coupon_id']);
                $couponUse = CouponUse::where('user_id', $user->id)->where('coupon_id', $data['coupon_id'])->first();
                if (isset($couponUse)) {
                    if ($coupon->is_multiple_buy == 1) {
                        CouponUse::create([
                            'user_id' => $user->id,
                            'coupon_id' => $data['coupon_id'],
                            'order_id' => $order->id,
                            'discount_amount' => $data['coupon_amount'],
                        ]);
                    }
                } else {
                    CouponUse::create([
                        'user_id' => $user->id,
                        'coupon_id' => $data['coupon_id'],
                        'order_id' => $order->id,
                        'discount_amount' => $data['coupon_amount'],
                    ]);
                }
            }
        }

        return $order;
    }

    public function orderPaymentDone($amount, $method, $response, $user = null)
    {
        if($method != 1 && $method != 2 && $method != 7){
            $old_tnx = OrderPayment::where('txn_id', $response)->first();
            if($old_tnx){
                return 'failed';
            }else{
                $order_payment = OrderPayment::create([
                    'user_id' => ($user != null) ? $user->id : null,
                    'amount' => $amount,
                    'payment_method' => $method,
                    'txn_id' => $response,
                ]);
                return $order_payment;
            }
        }
        $order_payment = OrderPayment::create([
            'user_id' => ($user != null) ? $user->id : null,
            'amount' => $amount,
            'payment_method' => $method,
            'txn_id' => $response,
        ]);
        return $order_payment;
    }

    public function orderPaymentDelete($id)
    {
        return OrderPayment::findOrFail($id)->delete();
    }

    public function getOrderToShip($user_id)
    {

        return OrderPackageDetail::with('order.shipping_address', 'order.billing_address', 'seller', 'delivery_states', 'products.seller_product_sku.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color', 'products.seller_product_sku.sku','products.giftCard')->where('delivery_status', '>', 1)->where('delivery_status', '<=', 2)->whereHas('order', function ($query) use ($user_id) {
            $query->where('customer_id', $user_id)->where('is_confirmed', 1);
        })->get();
    }
    public function getOrderToReceive($user_id)
    {
        return OrderPackageDetail::with('order.shipping_address', 'order.billing_address', 'seller', 'delivery_states', 'products.seller_product_sku.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color', 'products.seller_product_sku.sku','products.giftCard')->where('delivery_status', '>', 2)->where('delivery_status', '<=', 3)->whereHas('order', function ($query) use ($user_id) {
            $query->where('customer_id', $user_id)->where('is_confirmed', 1);
        })->get();
    }

    public function getNumberOfOrdersCancelled($user){
        $orders = Order::where('customer_id', $user->id)->where('is_cancelled', 1)->pluck('id');
        return count($orders);
    }
}
