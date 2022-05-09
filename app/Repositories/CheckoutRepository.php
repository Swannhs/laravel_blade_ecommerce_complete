<?php
namespace App\Repositories;

use App\Models\Cart;
use App\Models\Subscription;
use App\Traits\GoogleAnalytics4;
use Illuminate\Support\Facades\Session;
use Modules\Customer\Entities\CustomerAddress;
use Modules\GiftCard\Entities\GiftCard;
use Modules\PaymentGateway\Entities\PaymentMethod;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Setup\Entities\Country;
use Modules\Shipping\Entities\ShippingMethod;

class CheckoutRepository{

    use GoogleAnalytics4;

    public function __construct(){

    }
    public function getCartItem_old()
    {
        if(!auth()->check()){
            $carts = Session::get('cart', collect());


            $product_ids = $carts->where('product_type', 'product')->pluck('product_id')->toArray();
            $product_ids = SellerProductSKU::where('status', 1)->whereIn('id', $product_ids)->whereHas('product', function($query){
                    return $query->where('status', 1)->activeSeller();
            })->pluck('id')->toArray();

            $giftcard_ids = $carts->where('product_type', 'gift_card')->pluck('product_id')->toArray();
            $giftcard_ids = GiftCard::where('status', 1)->whereIn('id', $giftcard_ids)->pluck('id')->toArray();

            $cart_product = $carts->where('product_type', 'product')->whereIn('product_id', $product_ids);
            $cart_giftcard = $carts->where('product_type', 'gift_card')->whereIn('product_id', $giftcard_ids);

            $carts  = $cart_product->merge($cart_giftcard);

            $recs = new \Illuminate\Database\Eloquent\Collection($carts);

            $grouped = $recs->where('is_select',1)->groupBy('seller_id')->transform(function($item, $k) {
                return $item->groupBy('shipping_method_id');
            });
        }else {

            $query =  Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();

            $recs = new \Illuminate\Database\Eloquent\Collection($query);
            $grouped = $recs->groupBy('seller_id')->transform(function($item, $k) {
                return $item->groupBy('shipping_method_id');
            });
        }
        $group['gift_card_exist'] = count($recs->where('product_type', 'gift_card')->where('is_select', 1));
        $group['cartData'] = $grouped;
        return $group;
    }


    public function getCartItem()
    {
        $carts = [];

        if(auth()->check()){
            $carts = Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('user_id',auth()->user()->id)->where('is_select',1)->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();
        }else{
            $carts = Cart::where('session_id',session()->getId())->where('is_select',1)->where('product_type', 'product')->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->where('status', 1)->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('session_id',session()->getId())->where('is_select',1)->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();
        }
        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $e_productName = 'Product';
            $e_sku = 'sku';
            $e_items = [];
            foreach ($carts as $c){
                if($c['product_type'] == 'product'){
                    $e_product = SellerProductSKU::find($c['product_id']);
                    if($e_product){
                        $e_productName = $e_product->product->product_name;
                        $e_sku = $e_product->sku->sku;
                    }
                }else{
                    $e_product = GiftCard::find($c['product_id']);
                    if($e_product){
                        $e_productName = $e_product->name;
                        $e_sku = $e_product->sku;

                    }
                }
                $e_items[]=[
                    "item_id"=> $e_sku,
                    "item_name"=> $e_productName,
                    "currency"=> currencyCode(),
                    "price"=> $c['price']
                ];
            }

            $eData = [
                'name' => 'begin_checkout',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 1,
                    "items" => $e_items,
                ],
            ];
            $this->postEvent($eData);
        }
        //end ga4



        if(!isModuleActive('MultiVendor')){
            $group['cartData'] = $carts;
        }else{
            $recs = new \Illuminate\Database\Eloquent\Collection($carts);
            $grouped = $recs->groupBy('seller_id')->transform(function($item, $k) {
                return $item->groupBy('shipping_method_id');
            });
            $group['cartData'] = $grouped;
        }
        $group['gift_card_exist'] = count($carts->where('product_type', 'gift_card')->where('is_select', 1));
        return $group;
    }


    public function deleteProduct($data){
        $product = Cart::where('user_id',auth()->user()->id)->where('id',$data['id'])->firstOrFail();
        return $product->delete();
    }

    public function addressStore($data){
        $prev_addresses = CustomerAddress::where('customer_id', auth()->id())->get();
        foreach($prev_addresses as $address_old){
            $address_old->update([
                'is_shipping_default' => 0,
                'is_billing_default' => 0
            ]);
        }
        return CustomerAddress::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'postal_code' => $data['postal_code'],
            'is_shipping_default' => 1,
            'is_billing_default' => 1,
            'customer_id' => auth()->user()->id
        ]);
    }
    public function addressUpdate($data){
        $address = CustomerAddress::where('customer_id', auth()->id())->where('id', $data['address_id'])->first();
        $other_addresses = CustomerAddress::where('customer_id', auth()->id())->where('id','!=', $data['address_id'])->get();

        foreach($other_addresses as $address_old){
            $address_old->update([
                'is_shipping_default' => 0,
                'is_billing_default' => 0
            ]);
        }
        $address->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'is_shipping_default' => 1,
            'is_billing_default' => 1
        ]);
    }

    public function get_active_shipping_methods(){
        return ShippingMethod::where('is_active',1)->where('is_approved', 1)->get();
    }

    public function guestAddressStore($data)
    {
        $cartData = [];
        $cartData['name'] = $data['name'];
        $cartData['email'] = $data['email'];
        $cartData['phone'] = $data['phone'];
        $cartData['address'] = $data['address'];
        $cartData['city'] = $data['city'];
        $cartData['state'] = $data['state'];
        $cartData['country'] = $data['country'];
        $cartData['postal_code'] = $data['postal_code'];
        Session::put('shipping_address', $cartData);
        return true;
    }

    public function billingAddressStore($data){
        if(auth()->check()){
            $prev_address = CustomerAddress::where('customer_id', auth()->id())->where('is_billing_default', 1)->first();
            if($prev_address){
                $prev_address->update([
                    'is_billing_default' => 0
                ]);
            }

            if($data['address_id'] == 0){
                CustomerAddress::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'postal_code' => $data['postal_code'],
                    'is_shipping_default' => 0,
                    'is_billing_default' => 1,
                    'customer_id' => auth()->user()->id
                ]);
            }else{
                CustomerAddress::where('customer_id', auth()->id())->where('id',$data['address_id'])->first()->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'country' => $data['country'],
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'postal_code' => $data['postal_code'],
                    'is_shipping_default' => 0,
                    'is_billing_default' => 1
                ]);
            }
            return 1;
        }else{
            $address = [];
            $address['name'] = $data['name'];
            $address['email'] = $data['email'];
            $address['phone'] = $data['phone'];
            $address['address'] = $data['address'];
            $address['city'] = $data['city'];
            $address['state'] = $data['state'];
            $address['country'] = $data['country'];
            $address['postal_code'] = $data['postal_code'];
            Session::put('billing_address', $address);
            return 1;
        }
        return 0;

    }

    public function shippingAddressChange($data){
        if($data['id'] != 0){
            $address = CustomerAddress::where('customer_id',auth()->user()->id)->where('is_shipping_default',1)->first();
            if($address){
                $address->update([
                    'is_shipping_default' => 0
                ]);
            }
            CustomerAddress::findOrFail($data['id'])->update([
                'is_shipping_default' => 1
            ]);
        }else{
            $addresses = CustomerAddress::where('customer_id',auth()->user()->id)->get();
            foreach ($addresses as $address){
                $address->update([
                    'is_shipping_default' => 0,
                    'is_billing_default' => 0
                ]);
            }
        }
        return true;
    }
    public function subscribeFromCheckout($email){
        $old_sub = Subscription::where('email', $email)->first();
        if(!$old_sub){
            Subscription::create([
                'email' =>$email,
                'status' => 1
            ]);
        }
        return true;
    }


    public function getCountries(){
        return Country::where('status', 1)->orderBy('name')->get();
    }

    public function activeShippingAddress(){
        if(auth()->check()){
            $address = auth()->user()->customerShippingAddress;
        }else{
            $address = (object) session()->get('shipping_address');
        }
        return $address;
    }

    public function activeBillingAddress(){
        $billingAddress = null;
        if(auth()->check()){
            $billingAddress = auth()->user()->customerAddresses->where('is_billing_default',1)->where('is_shipping_default',0)->first();
        }else{
            if(session()->has('billing_address')){
                $billingAddress = (object) session()->get('billing_address');
            }
        }
        return $billingAddress;
    }

    public function selectedShippingMethod($id){
        return ShippingMethod::find($id);
    }

    public function totalAmountForPayment($cartData, $shipping=null, $address=null){
        $total = 0;
        $tax = 0;
        $subtotal = 0;
        $actual_price = 0;
        $packagewise_tax = [];
        if(isModuleActive('MultiVendor')){
            $shipping_cost = [];
            $delivery_date = [];
            $shipping_method = [];
        }else{
            $shipping_cost = 0;
            $delivery_date = '';
            $shipping_method = null;
        }
        $additional_shipping = 0;
        $discount = 0;
        $number_of_item = 0;
        $number_of_package = 0;
        $is_digital_product = 0;
        $is_physical_product = 0;
        $gstAmount = 0;
        $e_items = [];
        if(isModuleActive('MultiVendor')){

            foreach($cartData as $seller_id => $cartItems){
                foreach($cartItems as $key => $packages){
                    $number_of_package += 1;
                    $package_tax = 0;
                    foreach($packages as $cart){
                        $actual_price += ($cart->price * $cart->qty);
                        if($cart->product_type == 'product'){
                            if(file_exists(base_path().'/Modules/GST/') && $cart->product->product->product->is_physical == 1){
                                if($address != null && app('gst_config')['enable_gst'] == "gst"){
                                    if(app('general_setting')->state_id == $address->state){
                                        $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['within_a_single_state'])->get();
                                        foreach($sameStateTaxes as $key => $sameStateTax){
                                            $gstAmount = ($cart->total_price * $sameStateTax->tax_percentage) / 100;
                                            $tax += $gstAmount;
                                            $package_tax += $gstAmount;
                                        }
                                    }
                                    else{
                                        $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                                        foreach ($diffStateTaxes as $key => $diffStateTax){
                                            $gstAmount = ($cart->total_price * $diffStateTax->tax_percentage) / 100;
                                            $tax += $gstAmount;
                                            $package_tax += $gstAmount;
                                        }
                                    }
                                }else{
                                    $flatTax = \Modules\GST\Entities\GstTax::where('id', app('gst_config')['flat_tax_id'])->first();
                                    $gstAmount = ($cart->total_price * $flatTax->tax_percentage) / 100;
                                    $tax += $gstAmount;
                                    $package_tax += $gstAmount;
                                }
                            }
                            $additional_shipping += $cart->product->sku->additional_shipping;
                            if($cart->product->product->product->is_physical == 0){
                                $is_digital_product  = 1;
                            }else{
                                $is_physical_product = 1;
                            }
                            $subtotal +=  ($cart->product->selling_price * $cart->qty);
                            $e_items[]=[
                                "item_id"=> $cart->product->sku->sku,
                                "item_name"=> $cart->product->product->product_name,
                                "currency"=> currencyCode(),
                                "price"=> $cart->price
                            ];
                        }else{
                            $subtotal +=  ($cart->giftCard->selling_price * $cart->qty);
                            $is_digital_product  = 1;
                            $e_items[]=[
                                "item_id"=> $cart->giftCard->sku,
                                "item_name"=> $cart->giftCard->name,
                                "currency"=> currencyCode(),
                                "price"=> $cart->price
                            ];
                        }
                        $number_of_item += $cart->qty;
                    }
                    $packagewise_tax[] = $package_tax;
                    if($packages[0]->shippingMethod->cost > 0){
                        $shipping_cost[] = $packages[0]->shippingMethod->cost + $additional_shipping;
                    }else{
                        $shipping_cost[] = 0;
                    }
                    // generate delivery date
                    $delivery_date[] = $this->generateDeliveryDate($packages[0]->shippingMethod);
                    $shipping_method[] = $packages[0]->shippingMethod->id;
                }
            }

        }
        else{
            foreach($cartData as $key => $cart){
                $actual_price += ($cart->price * $cart->qty);
                if($cart->product_type == 'product'){
                    $subtotal +=  ($cart->product->selling_price * $cart->qty);
                    if(file_exists(base_path().'/Modules/GST/') && $cart->product->product->product->is_physical == 1){
                        if($address!=null && app('gst_config')['enable_gst'] == "gst"){
                            if(app('general_setting')->state_id == $address->state){
                                $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['within_a_single_state'])->get();
                                foreach($sameStateTaxes as $key => $sameStateTax){
                                    $gstAmount = ($cart->total_price * $sameStateTax->tax_percentage) / 100;
                                    $tax += $gstAmount;
                                }
                            }
                            else{
                                $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                                foreach ($diffStateTaxes as $key => $diffStateTax){
                                    $gstAmount = ($cart->total_price * $diffStateTax->tax_percentage) / 100;
                                    $tax += $gstAmount;
                                }
                            }
                        }
                        else{
                            $flatTax = \Modules\GST\Entities\GstTax::where('id', app('gst_config')['flat_tax_id'])->first();
                            $gstAmount = ($cart->total_price * $flatTax->tax_percentage) / 100;
                            $tax += $gstAmount;
                        }
                    }
                    $additional_shipping += $cart->product->sku->additional_shipping;
                    if($cart->product->product->product->is_physical == 0){
                        $is_digital_product  = 1;
                    }else{
                        $is_physical_product = 1;
                    }
                    $e_items[]=[
                        "item_id"=> $cart->product->sku->sku,
                        "item_name"=> $cart->product->product->product_name,
                        "currency"=> currencyCode(),
                        "price"=> $cart->price
                    ];
                }else{
                    $subtotal +=  ($cart->giftCard->selling_price * $cart->qty);
                    $is_digital_product  = 1;
                    $e_items[]=[
                        "item_id"=> $cart->giftCard->sku,
                        "item_name"=> $cart->giftCard->name,
                        "currency"=> currencyCode(),
                        "price"=> $cart->price
                    ];
                }
                $number_of_item += $cart->qty;
                $packagewise_tax[] = $gstAmount;
            }
            if($shipping!=null){
                if($shipping->cost > 0){
                    $shipping_cost = $shipping->cost + $additional_shipping;
                }else{
                    $shipping_cost = $shipping->cost;
                }
                //delivery_date generate
                $delivery_date = $this->generateDeliveryDate($shipping);
                $shipping_method = $shipping->id;
            }
            if($is_digital_product == 1 && $is_physical_product == 1){
                $number_of_package = 2;
            }else{
                $number_of_package = 1;
            }
        }

        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $eData = [
                'name' => 'add_shipping_info',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 1,
                    "items" => $e_items,
                ],
            ];
            $this->postEvent($eData);
        }
        //end ga4

        if(isModuleActive('MultiVendor')){
            $t_shipping = collect($shipping_cost)->sum();
            $total = $actual_price + $tax + $t_shipping;
        }else{
            $total = $actual_price + $tax + $shipping_cost;
        }

        $discount = $subtotal - $actual_price;
        return [
            'grand_total' => $total,
            'subtotal' => $subtotal,
            'actual_total' => $actual_price,
            'discount' => $discount,
            'number_of_item' => $number_of_item,
            'number_of_package' => $number_of_package,
            'shipping_cost' => $shipping_cost,
            'tax_total' => $tax,
            'delivery_date' => $delivery_date,
            'shipping_method' => $shipping_method,
            'packagewise_tax' => $packagewise_tax
        ];
    }

    public function getActivePaymentGetways(){
        return PaymentMethod::where('active_status', 1);
    }

    private function generateDeliveryDate($shipping){
        $shipment_time = $shipping->shipment_time;
        $shipment_time = explode(" ", $shipment_time);
        $dayOrOur = $shipment_time[1];

        $shipment_time = explode("-", $shipment_time[0]);
        $start_ = $shipment_time[0];
        $end_ = $shipment_time[1];
        $date = date('d-m-Y');
        $start_date = date('d M', strtotime($date. '+ '.$start_.' '.$dayOrOur));
        $end_date = date('d M', strtotime($date. '+ '.$end_.' '.$dayOrOur));

        if($dayOrOur == 'days' || $dayOrOur == 'Days' ||$dayOrOur == 'Day'){
            $delivery_date = 'Est arrival date: '. $start_date.' '.'-'.' '.$end_date;
        }else{
            $delivery_date = 'Est arrival time: '. $shipping->shipment_time;
        }
        return $delivery_date;
    }
}
