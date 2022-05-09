<?php
namespace Modules\InhouseOrder\Repositories;

use App\Models\GuestOrderDetail;
use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Models\OrderProductDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Modules\GST\Entities\OrderPackageGST;
use Modules\InhouseOrder\Entities\InhouseOrderCart;
use Modules\PaymentGateway\Entities\PaymentMethod;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Setup\Entities\Country;

class InhouseOrderRepository
{
    public function getProducts(){

        return SellerProduct::where('status', 1)->latest()->activeSeller()->get();
    }

    public function getCountries(){
        return Country::where('status', 1)->orderBy('name')->get();
    }

    public function getVariantByProduct($id){
        
        return SellerProduct::where('status', 1)->where('id', $id)->first();
    }

    public function productTypeCheck($id){
        $product = SellerProduct::findOrFail($id);
        if($product->product->product_type == 1){
            return 'single_product';
        }else{
            return 'variant_product';
        }
        return false;
    }

    public function addToCart($id){
        $product = SellerProduct::findOrFail($id);

        $selling_price = 0;
        $productSKU = $product->skus->first();
        $actual_selling_price = $productSKU->selling_price;

        if($product->hasDeal){
            $selling_price = selling_price($actual_selling_price,$product->hasDeal->discount_type, $product->hasDeal->discount);
        }
        else{

            if($product->hasDiscount == 'yes'){
                $selling_price = selling_price($actual_selling_price, $product->discount_type, $product->discount);
            }else{
                $selling_price = $actual_selling_price;
            }
        }

        $exsitCheck = InhouseOrderCart::where('product_id', $product->skus->first()->id)->first();
        $is_out_of_stock = 0;

        if($exsitCheck){
            if($productSKU->product_stock <= $productSKU->product->product->minimum_order_qty && $productSKU->product->stock_manage == 1){
                $is_out_of_stock = 1;
            }
        }

        if($is_out_of_stock == 0){
            if($exsitCheck){
                $exsitCheck->update([
                    'qty' => $exsitCheck->qty + 1,
                    'price' => $exsitCheck->price + $selling_price,
                    'total_price' => $exsitCheck->total_price + $selling_price
                ]);
            }else{
                InhouseOrderCart::create([
                    'seller_id' => $product->user_id,
                    'product_id' => $product->skus->first()->id,
                    'qty' => 1,
                    'price' => $selling_price,
                    'total_price' => $selling_price,
                    'sku' => null,
                    'is_select' => 1,
                    'shipping_method_id' => $product->product->shippingMethods->first()->shipping_method_id
                ]);
    
            }
        }else{
            return 'out_of_stock';
        }

        return 'done';

    }

    public function storeVariantProductToCart($data){

        $productSKU = SellerProductSKU::findOrFail($data['product_id']);
        $exsitCheck = InhouseOrderCart::where('product_id', $data['product_id'])->first();
        $is_out_of_stock = 0;
        
        if($exsitCheck){
            if($productSKU->product_stock <= $productSKU->product->product->minimum_order_qty && $productSKU->product->stock_manage == 1){
                $is_out_of_stock = 1;
            }
        }

        if($is_out_of_stock == 0){
            if($exsitCheck){
            
                $exsitCheck->update([
                    'qty' => $exsitCheck->qty + $data['qty'],
                    'price' => $data['price'],
                    'total_price' => $exsitCheck->total_price + $data['price']
                ]);
            }else{
                InhouseOrderCart::create([
                    'seller_id' => $productSKU->product->user_id,
                    'product_id' => $data['product_id'],
                    'qty' => $data['qty'],
                    'price' => $data['price'],
                    'total_price' => $data['price'] * $data['qty'],
                    'sku' => null,
                    'is_select' => 1,
                    'shipping_method_id' => $data['shipping_method_id']
                ]);
            }
        }else{
            return 'out_of_stock';
        }

        return 'done';

    }

    public function getInhouseCartData(){
        $query = InhouseOrderCart::where('is_select', 1)->whereHas('product', function($query){
            return $query->where('status', 1)->whereHas('product', function($q){
                return $q->activeSeller();
            });
        })->get();

        $recs = new \Illuminate\Database\Eloquent\Collection($query);

        $grouped = $recs->groupBy('seller_id')->transform(function($item, $k) {
            return $item->groupBy('shipping_method_id');
        });

        return $grouped;

    }

    public function changeShippingMethod($data){

        $cartProduct = InhouseOrderCart::findOrFail($data['product_id']);
        return $cartProduct->update([
            'shipping_method_id' => $data['method_id']
        ]);
    }

    public function changeQty($data){

        $cartProduct = InhouseOrderCart::findOrFail($data['product_id']);
        return $cartProduct->update([
            'qty' => isset($data['qty'])?$data['qty']:1,
            'total_price' => isset($data['qty'])?$data['qty'] * $cartProduct->price:1 * $cartProduct->price
        ]);
    }

    public function getPaymentMethods(){
        return PaymentMethod::where('method','Cash On Delivery')->first();
    }

    public function deleteById($id){
        $cart_product =  InhouseOrderCart::findOrFail($id);
        $cart_product->delete();
        return true;
    }

    public function addressSave($data){
        if(Session::has('inhouse_order_shipping_address')){
            Session::forget('inhouse_order_shipping_address');
        }
        if(Session::has('inhouse_order_billing_address')){
            Session::forget('inhouse_order_billing_address');
        }

        $cartData = [];
        $cartData['shipping_name'] = $data['shipping_name'];
        $cartData['shipping_email'] = $data['shipping_email'];
        $cartData['shipping_phone'] = $data['shipping_phone'];
        $cartData['shipping_address'] = $data['shipping_address'];
        $cartData['shipping_city'] = $data['shipping_city'];
        $cartData['shipping_state'] = $data['shipping_state'];
        $cartData['shipping_country'] = $data['shipping_country'];
        $cartData['shipping_postcode'] = $data['shipping_postcode'];
        $cartData['is_bill_address'] = $data['is_bill_address'];

        Session::put('inhouse_order_shipping_address', $cartData);

        if($data['is_bill_address'] == 1){
            $shippingData = [];
            $shippingData['billing_name'] = $data['billing_name'];
            $shippingData['billing_email'] = $data['billing_email'];
            $shippingData['billing_phone'] = $data['billing_phone'];
            $shippingData['billing_address'] = $data['billing_address'];
            $shippingData['billing_city'] = $data['billing_city'];
            $shippingData['billing_state'] = $data['billing_state'];
            $shippingData['billing_country'] = $data['billing_country'];
            $shippingData['billing_postcode'] = $data['billing_postcode'];

            Session::put('inhouse_order_billing_address', $shippingData);
        }

        return true;

    }

    public function resetAddress(){
        if(Session::has('inhouse_order_shipping_address')){
            Session::forget('inhouse_order_shipping_address');
        }
        if(Session::has('inhouse_order_billing_address')){
            Session::forget('inhouse_order_billing_address');
        }

        return true;
    }

    public function store($data){

        $query = InhouseOrderCart::where('is_select', 1)->get();

        $recs = new \Illuminate\Database\Eloquent\Collection($query);
        $grouped = $recs->groupBy('seller_id')->transform(function($item, $k) {
            return $item->groupBy('shipping_method_id');
        });

        $customer_email =  session()->get('inhouse_order_shipping_address')['shipping_email'];
        $customer_phone =  session()->get('inhouse_order_shipping_address')['shipping_phone'];



        $order = Order::create([
            'customer_id' =>  null,
            'order_number' => rand(11,99).date('ymdhis'),
            'payment_type' => $data['payment_method'],
            'order_type' => 'inhouse_order',
            'is_paid' => 0,
            'is_confirmed' => 1,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_shipping_address' => session()->get('inhouse_order_shipping_address')['shipping_state'],
            'customer_billing_address' => session()->get('inhouse_order_billing_address')?session()->get('inhouse_order_billing_address')['billing_state']:session()->get('inhouse_order_shipping_address')['shipping_state'],
            'grand_total' => $data['grand_total'],
            'sub_total' => $data['sub_total'],
            'discount_total' => $data['discount_total'],
            'shipping_total' => $data['shipping_charge'],
            'number_of_package' => $data['number_of_package'],
            'number_of_item' => $data['total_quantity'],
            'order_status' => 0,
            'order_payment_id' =>  null,
            'tax_amount' => $data['tax_total']
        ]);

        GuestOrderDetail::create([
            'order_id' => $order->id,
            'guest_id' => $order->id.date('ymd-his'),
            'shipping_name' => session()->get('inhouse_order_shipping_address')['shipping_name'],
            'shipping_email' => session()->get('inhouse_order_shipping_address')['shipping_email'],
            'shipping_phone' => session()->get('inhouse_order_shipping_address')['shipping_phone'],
            'shipping_address' => session()->get('inhouse_order_shipping_address')['shipping_address'],
            'shipping_city_id' => session()->get('inhouse_order_shipping_address')['shipping_city'],
            'shipping_state_id' => session()->get('inhouse_order_shipping_address')['shipping_state'],
            'shipping_country_id' => session()->get('inhouse_order_shipping_address')['shipping_country'],
            'shipping_post_code' => session()->get('inhouse_order_shipping_address')['shipping_postcode'],

            'billing_name' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_name'] : session()->get('inhouse_order_shipping_address')['shipping_name'],
            'billing_email' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_email'] : session()->get('inhouse_order_shipping_address')['shipping_email'],
            'billing_phone' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_phone'] : session()->get('inhouse_order_shipping_address')['shipping_phone'],
            'billing_address' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_address'] : session()->get('inhouse_order_shipping_address')['shipping_address'],
            'billing_city_id' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_city'] : session()->get('inhouse_order_shipping_address')['shipping_city'],
            'billing_state_id' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_state'] : session()->get('inhouse_order_shipping_address')['shipping_state'],
            'billing_country_id' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_country'] : session()->get('inhouse_order_shipping_address')['shipping_country'],
            'billing_post_code' => (session()->has('inhouse_order_billing_address')) ? session()->get('inhouse_order_billing_address')['billing_postcode'] : session()->get('inhouse_order_shipping_address')['shipping_postcode']
        ]);

        $val = 0;
        foreach($grouped as $key => $items){
            foreach($items as $key => $packages){

                $index_no = $val + 1;
                $packageData = OrderPackageDetail::create([
                    'order_id' => $order->id,
                    'seller_id' => $key,
                    'package_code' => 'TRK - ' . rand(4554555,45754575),
                    'number_of_product' => count($packages),
                    'shipping_cost' => $data['shipping_cost'][$val],
                    'shipping_date' => $data['delivery_date'][$val],
                    'shipping_method' => $data['shipping_method'][$val],
                    'tax_amount' => $data['packagewiseTax'][$val],
                ]);


                if (file_exists(base_path().'/Modules/GST/')) {
                    if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax") {
                        if (!empty($data['gst_package_'.$index_no])) {
                            foreach ($data['gst_package_'.$index_no] as $k => $gst_id) {
                                OrderPackageGST::create([
                                    'package_id' => $packageData->id,
                                    'gst_id' => $gst_id,
                                    'amount' => $data['gst_amounts_package_'.$index_no][$k],
                                ]);
                            }
                        }
                    }
                }


                foreach($packages as $key => $product){

                    OrderProductDetail::create([
                        'package_id' => $packageData->id,
                        'type' => 'product',
                        'product_sku_id' => $product->product_id,
                        'qty' => $product->qty,
                        'price' => $product->price,
                        'total_price' => $product->total_price,
                        'tax_amount' => tax_count($product->price, $product->product->product->tax, $product->product->product->tax_type) * $product->qty
                    ]);
                }
                $val ++;
            }
        }

        InhouseOrderCart::truncate();

        if(Session::has('inhouse_order_shipping_address')){
            Session::forget('inhouse_order_shipping_address');
        }
        if(Session::has('inhouse_order_billing_address')){
            Session::forget('inhouse_order_billing_address');
        }

        return true;
    }

    public function inhouseOrderList(){
        return Order::where('order_type', 'inhouse_order')->latest();
    }

}
