<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponApplyRequest;
use App\Models\Cart;
use App\Services\CheckoutService;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Modules\GiftCard\Entities\GiftCard;
use \Modules\PaymentGateway\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Marketing\Entities\CouponUse;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Setup\Repositories\CityRepository;
use Modules\Setup\Repositories\StateRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class CheckoutController extends Controller
{
    use GoogleAnalytics4;

    protected $checkoutService;
    protected $paymentGatewayService;
    public function __construct(CheckoutService $checkoutService,PaymentGatewayService $paymentGatewayService)
    {
        $this->checkoutService = $checkoutService;
        $this->paymentGatewayService = $paymentGatewayService;
        $this->middleware('maintenance_mode');

    }

    public function index(Request $request)
    {
        $step = $request->get('step');

        $cartDataGroup = $this->checkoutService->getCartItem();

        $cartData = $cartDataGroup['cartData'];



        $giftCardExist = $cartDataGroup['gift_card_exist'];
        $customer = auth()->user();
        $shipping_address = null;
        if(auth()->check() && count(auth()->user()->customerAddresses) > 0){
            $shipping_address = auth()->user()->customerAddresses->where('is_shipping_default',1)->first();
            if($shipping_address){
                $states = (new StateRepository())->getByCountryId($shipping_address->country)->where('status', 1);
                $cities = (new CityRepository())->getByStateId($shipping_address->state)->where('status', 1);
            }else{
                $states = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
                $cities = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
            }

        }else{
            if(session()->has('shipping_address')){
                $shipping_address = (object) session()->get('shipping_address');
            }
            $states = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
            $cities = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
        }
        $countries = $this->checkoutService->getCountries();

        $gateway_activations = $this->checkoutService->getActivePaymentGetways();
        $shipping_methods = $this->checkoutService->get_active_shipping_methods();

        if(count($cartData) < 1){
            Toastr::warning(__('defaultTheme.please_product_select_from_cart_first'), __('common.warning'));
            return back();
        }

        if($step == 'select_shipping'){
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'country' => 'required'
            ]);
            if($request->get('note') != null){
                session()->put('order_note',$request->get('note'));
            }
            if($request->has('news_letter')){
                $email = '';
                if(auth()->check() && auth()->user()->email != null){
                    $email = auth()->user()->email;
                }else{
                    $email = $request->get('email');
                }
                $this->checkoutService->subscribeFromCheckout($email);
            }
            if(auth()->check()){
                $request->merge([
                    'is_shipping_default' => 1,
                    'is_billing_default' => 1
                ]);
                if($request->get('address_id') != 0){
                    $this->checkoutService->addressUpdate($request->only('address_id','name','address','email','phone','country','state','city','postal_code'));
                }else{
                    $this->checkoutService->addressStore($request->only('name','address','email','phone','country','state','city','postal_code'));
                }

            }else{
                $this->checkoutService->guestAddressStore($request->only('name','address','email','phone','country','state','city','postal_code'));
            }
            $address = $this->checkoutService->activeShippingAddress();
            $data = [
                'cartData' => $cartData,
                'gateway_activations' => $gateway_activations,
                'shipping_address' => $shipping_address,
                'shipping_methods' => $shipping_methods,
                'address' => $address
            ];

            return view(theme('pages.shipping_step'),$data);
        }
        elseif($step == 'select_payment'){
            if(isModuleActive('MultiVendor')){
                $request->validate([
                    'name' => 'required',
                    'address' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'country' => 'required'
                ]);
                if(auth()->check()){
                    $request->merge([
                        'is_shipping_default' => 1,
                        'is_billing_default' => 1
                    ]);
                    if($request->get('address_id') != 0){
                        $this->checkoutService->addressUpdate($request->only('address_id','name','address','email','phone','country','state','city','postal_code'));
                    }else{
                        $this->checkoutService->addressStore($request->only('name','address','email','phone','country','state','city','postal_code'));
                    }

                }else{
                    $this->checkoutService->guestAddressStore($request->only('name','address','email','phone','country','state','city','postal_code'));
                }
            }else{
                $request->validate([
                    'shipping_method' => 'required'
                ]);
            }
            if($request->get('note') != null){
                session()->put('order_note',$request->get('note'));
            }
            if($request->has('news_letter')){
                $email = '';
                if(auth()->check() && auth()->user()->email != null){
                    $email = auth()->user()->email;
                }else{
                    $email = $request->get('email');
                }
                $this->checkoutService->subscribeFromCheckout($email);
            }
            if(session()->has('infoCompleteOrder')){
                session()->forget('infoCompleteOrder');
            }
            $address = $this->checkoutService->activeShippingAddress();
            $coupon = [];
            if(isModuleActive('MultiVendor')){
                $total_amount = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['grand_total'];
                $subtotal_without_discount = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['subtotal'];
                $discount = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['discount'];
                $number_of_package = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['number_of_package'];
                $number_of_item = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['number_of_item'];
                $shipping_cost = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['shipping_cost'];
                $tax_total = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['tax_total'];
                $shipping_cost = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['shipping_cost'];
                $delivery_date = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['delivery_date'];
                $selected_shipping_method = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['shipping_method'];
                $packagewise_tax = $this->checkoutService->totalAmountForPayment($cartData,null,$address)['packagewise_tax'];
                if(Session::has('coupon_type')&&Session::has('coupon_discount')){
                    $coupon = $this->couponCount($subtotal_without_discount-$discount, collect($shipping_cost)->sum());
                }
            }else{
                $selected_shipping_method = $this->checkoutService->selectedShippingMethod($request->get('shipping_method'));
                $total_amount = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['grand_total'];
                $subtotal_without_discount = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['subtotal'];
                $discount = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['discount'];
                $number_of_package = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['number_of_package'];
                $number_of_item = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['number_of_item'];
                $shipping_cost = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['shipping_cost'];
                $tax_total = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['tax_total'];
                $delivery_date = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['delivery_date'];
                $packagewise_tax = $this->checkoutService->totalAmountForPayment($cartData,$selected_shipping_method,$address)['packagewise_tax'];
                if(Session::has('coupon_type')&&Session::has('coupon_discount')){
                    $coupon = $this->couponCount($subtotal_without_discount-$discount,$shipping_cost);
                }
            }
            if(!auth()->check() || auth()->check() && auth()->user()->CustomerCurrentWalletAmounts < $total_amount){
                $gateway_activations = $gateway_activations->whereNotIn('id',['2']);
            }
            if($giftCardExist > 0){
                $gateway_activations = $gateway_activations->whereNotIn('id',['1']);
            }
            $gateway_activations = $gateway_activations->get();
            $billing_address = $this->checkoutService->activeBillingAddress();

            $infoCompleteOrder = [
                'cartData' => $cartData,
                'total_amount' => $total_amount,
                'subtotal_without_discount' => $subtotal_without_discount,
                'discount' => $discount,
                'number_of_package' => $number_of_package,
                'number_of_item' => $number_of_item,
                'shipping_cost' => $shipping_cost,
                'selected_shipping_method' => $selected_shipping_method,
                'address' => $address,
                'gateway_activations' => $gateway_activations,
                'tax_total' => $tax_total,
                'delivery_date' => $delivery_date,
                'packagewise_tax' => $packagewise_tax,
            ];
            $infoCompleteOrder = array_merge($infoCompleteOrder,$coupon);
            session()->put('infoCompleteOrder', $infoCompleteOrder);
            $infoCompleteOrder['countries'] = $countries;
            $infoCompleteOrder['states'] = $states;
            $infoCompleteOrder['cities'] = $cities;
            $infoCompleteOrder['billing_address'] = $billing_address;
            return view(theme('pages.payment_step'),$infoCompleteOrder);
        }



        if($step == 'complete_order'){
            $request->validate([
                'payment_id' => 'required',
                'gateway_id' => 'required',
                'step' => 'required'
            ]);

            $infoCompleteOrder = session()->get('infoCompleteOrder');
            $infoCompleteOrder['order_payment_id'] = decrypt($request->get('payment_id'));
            $infoCompleteOrder['order_gateway_id'] = decrypt($request->get('gateway_id'));

            $delivery_date = $infoCompleteOrder['delivery_date'];

            $grand_total = $infoCompleteOrder['total_amount'];
            $coupon = [];
            if(isset($infoCompleteOrder['coupon_amount'])){
                $grand_total = $grand_total - $infoCompleteOrder['coupon_amount'];
                $coupon = [
                    'coupon_amount' => $infoCompleteOrder['coupon_amount'],
                    'coupon_id' => $infoCompleteOrder['coupon_id']
                ];
            }
            $orderData = [
                'grand_total' => $grand_total,
                'sub_total' => $infoCompleteOrder['subtotal_without_discount'],
                'discount_total' => $infoCompleteOrder['discount'],
                'number_of_item' => $infoCompleteOrder['number_of_item'],
                'number_of_package' => $infoCompleteOrder['number_of_package'],
                'shipping_cost' => $infoCompleteOrder['shipping_cost'],
                'shipping_method' => isModuleActive('MultiVendor')?$infoCompleteOrder['selected_shipping_method']:$infoCompleteOrder['selected_shipping_method']->id,
                'delivery_date' => $delivery_date,
                'order_payment_id' => decrypt($request->get('payment_id')),
                'payment_method' => decrypt($request->get('gateway_id')),
                'tax_total' => $infoCompleteOrder['tax_total'],
                'packagewiseTax' => $infoCompleteOrder['packagewise_tax']
            ];
            $orderData = array_merge($orderData,$coupon);
            $request =$request->merge($orderData);
            $orderController = App::make(OrderController::class);
            return $orderController->store($request);

        }



        $total_items = $this->checkoutService->totalAmountForPayment($cartData,null,null)['number_of_item'];
        $total_package = $this->checkoutService->totalAmountForPayment($cartData,null,null)['number_of_package'];
        $shipping_cost = $this->checkoutService->totalAmountForPayment($cartData,null,null)['shipping_cost'];
        $discount = $this->checkoutService->totalAmountForPayment($cartData,null,null)['discount'];
        return view(theme('pages.checkout'),compact('cartData','shipping_address','gateway_activations','countries', 'giftCardExist', 'states', 'cities','total_items','total_package','shipping_cost','discount'));
    }

    public function destroy(Request $request){
        $this->checkoutService->deleteProduct($request->except('_token'));
        LogActivity::successLog('product delete by checkout successful.');
        return $this->reloadWithData();
    }

    public function shippingAddressChange(Request $request){
        $this->checkoutService->shippingAddressChange($request->except('_token'));
        LogActivity::successLog('Shipping address change successful.');
        return $this->reloadWithData();
    }
    public function billingAddressChange(Request $request){
        $address = auth()->user()->customerAddresses->where('id',$request->id)->first();
        $states = (new StateRepository())->getByCountryId($address->country)->where('status', 1);
        $cities = (new CityRepository())->getByStateId($address->state)->where('status', 1);
        return response()->json([
            'address' => $address,
            'states' => $states,
            'cities' => $cities
        ],200);
    }

    public function couponApply(CouponApplyRequest $request){

        $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();

        if(isset($coupon)){
            if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                if($coupon->is_multiple_buy){
                    if($coupon->coupon_type == 1){
                        $carts = Cart::where('user_id',auth()->user()->id)->where('is_select',1)->pluck('product_id');

                        $products = CouponProduct::where('coupon_id', $coupon->id)->whereHas('product',function($query) use($carts){
                            return $query->whereHas('skus', function($q) use($carts){
                                return $q->whereIn('id', $carts);
                            });
                        })->pluck('product_id');
                        if(count($products) > 0){
                            Session::put('coupon_type', $coupon->coupon_type);
                            Session::put('coupon_discount', $coupon->discount);
                            Session::put('coupon_discount_type', $coupon->discount_type);
                            Session::put('coupon_products', $products);
                            Session::put('coupon_id', $coupon->id);
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
                            Session::put('coupon_type', $coupon->coupon_type);
                            Session::put('coupon_discount', $coupon->discount);
                            Session::put('coupon_discount_type', $coupon->discount_type);
                            Session::put('maximum_discount', $coupon->maximum_discount);
                            Session::put('coupon_id', $coupon->id);
                        }
                    }elseif($coupon->coupon_type == 3){
                        Session::put('coupon_type', $coupon->coupon_type);
                        Session::put('coupon_discount', $coupon->discount);
                        Session::put('coupon_discount_type', $coupon->discount_type);
                        Session::put('maximum_discount', $coupon->maximum_discount);
                        Session::put('coupon_id', $coupon->id);
                    }
                }else{
                    if(CouponUse::where('user_id',auth()->user()->id)->where('coupon_id',$coupon->id)->first() == null){
                        if($coupon->coupon_type == 1){
                            $carts = Cart::where('user_id',auth()->user()->id)->where('is_select',1)->pluck('product_id');
                            $products = CouponProduct::where('coupon_id', $coupon->id)->whereHas('product',function($query) use($carts){
                                return $query->whereHas('skus', function($q) use($carts){
                                    return $q->whereIn('id', $carts);
                                });
                            })->pluck('product_id');

                            if(count($products) > 0){
                                Session::put('coupon_type', $coupon->coupon_type);
                                Session::put('coupon_discount', $coupon->discount);
                                Session::put('coupon_discount_type', $coupon->discount_type);
                                Session::put('coupon_products', $products);
                                Session::put('coupon_id', $coupon->id);
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
                                Session::put('coupon_type', $coupon->coupon_type);
                                Session::put('coupon_discount', $coupon->discount);
                                Session::put('coupon_discount_type', $coupon->discount_type);
                                Session::put('maximum_discount', $coupon->maximum_discount);
                                Session::put('coupon_id', $coupon->id);
                            }

                        }elseif($coupon->coupon_type == 3){
                            Session::put('coupon_type', $coupon->coupon_type);
                            Session::put('coupon_discount', $coupon->discount);
                            Session::put('coupon_discount_type', $coupon->discount_type);
                            Session::put('maximum_discount', $coupon->maximum_discount);
                            Session::put('coupon_id', $coupon->id);
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
        return $this->reloadWithData();

    }
    public function couponDelete(){
        Session::forget('coupon_type');
        Session::forget('coupon_discount');
        Session::forget('coupon_discount_type');
        Session::forget('maximum_discount');
        Session::forget('maximum_products');
        Session::forget('coupon_id');
        return $this->reloadWithData();
    }

    private function couponCount($total_for_coupon,$shippingtotal){
        $coupon = 0;
        if(Session::has('coupon_type')&&Session::has('coupon_discount')){
            $coupon_type = Session::get('coupon_type');
            $coupon_discount = Session::get('coupon_discount');
            $coupon_discount_type = Session::get('coupon_discount_type');
            $coupon_id = Session::get('coupon_id');

            if($coupon_type == 1){
                $couponProducts = Session::get('coupon_products');
                if($coupon_discount_type == 0){

                    foreach($couponProducts as  $key => $item){
                        $cart = \App\Models\Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product',function($query) use($item){
                            $query->whereHas('product', function($q) use($item){
                                $q->where('id', $item);
                            });
                        })->first();
                        $coupon += ($cart->total_price/100)* $coupon_discount;
                    }
                }else{
                    if($total_for_coupon > $coupon_discount){
                        $coupon = $coupon_discount;
                    }else {
                        $coupon = $total_for_coupon;
                    }
                }

            }
            elseif($coupon_type == 2){

                if($coupon_discount_type == 0){

                    $maximum_discount = Session::get('maximum_discount');
                    $coupon = ($total_for_coupon/100)* $coupon_discount;

                    if($coupon > $maximum_discount && $maximum_discount > 0){
                        $coupon = $maximum_discount;
                    }
                }else{
                    $coupon = $coupon_discount;
                }
            }
            elseif($coupon_type == 3){
                $maximum_discount = Session::get('maximum_discount');
                $coupon = $shippingtotal;

                if($coupon > $maximum_discount && $maximum_discount > 0){
                    $coupon = $maximum_discount;
                }

            }
        }
        return [
            'coupon_amount' => $coupon,
            'coupon_id' => $coupon_id
        ];
    }


    private function reloadWithData()
    {
        $cartDataGroup = $this->checkoutService->getCartItem();
        $cartData = $cartDataGroup['cartData'];
        $giftCardExist = $cartDataGroup['gift_card_exist'];
        $customer = (auth()->check())? auth()->user() : null;
        $gateway_activations = $this->paymentGatewayService->gateway_active();
        $countries = $this->checkoutService->getCountries();
        $shipping_address = null;
        $total_items = $this->checkoutService->totalAmountForPayment($cartData,null,null)['number_of_item'];
        $total_package = $this->checkoutService->totalAmountForPayment($cartData,null,null)['number_of_package'];
        $shipping_cost = $this->checkoutService->totalAmountForPayment($cartData,null,null)['shipping_cost'];
        $discount = $this->checkoutService->totalAmountForPayment($cartData,null,null)['discount'];

        if(auth()->check() && count(auth()->user()->customerAddresses)>0){
            $shipping_address = auth()->user()->customerAddresses->where('is_shipping_default',1)->first();
            if($shipping_address){
                $states = (new StateRepository())->getByCountryId($shipping_address->country)->where('status', 1);
                $cities = (new CityRepository())->getByStateId($shipping_address->state)->where('status', 1);
            }else{
                $states = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
                $cities = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
            }

        }else{
            $states = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
            $cities = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
        }
        if ($customer != null) {
            return response()->json([
                'MainCheckout' =>  (string)view(theme('partials._checkout_details'),compact('cartData','giftCardExist','shipping_address','gateway_activations','countries', 'states', 'cities','total_items','total_package','shipping_cost','discount'))
            ]);
        }
        else {
            return response()->json([
                'MainCheckout' =>  (string)view(theme('partials._checkout_details'),compact('cartData','giftCardExist','customer','gateway_activations','countries', 'states', 'cities','total_items','total_package','shipping_cost','discount'))
            ]);
        }
    }

    public function billingAddressStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:30',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'postal_code' => 'required'
        ]);
        try {
            $result = $this->checkoutService->billingAddressStore($request->except('_token'));
            if($result === 1){
                return response()->json([
                    'msg' => 'success'
                ],200);
            }
            return response()->json([
                'msg' => 'error'
            ],500);

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'msg' => 'error'
            ],500);
        }

    }
}
