@extends('frontend.default.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/checkout.css'))}}" />
@endsection
@section('breadcrumb')
    {{ __('Select Payment') }}
@endsection
@section('content')
    @include('frontend.default.partials._breadcrumb')
    <div id="mainDiv">
        <div class="checkout_v3_area">
            <div class="checkout_v3_left d-flex justify-content-end">
                <div class="checkout_v3_inner">
                    <div class="shiping_address_box checkout_form m-0">
                        <div class="billing_address">

                            <div class="row">
                                <div class="col-12">
                                    <div class="shipingV3_info mb_30">
                                        <div class="single_shipingV3_info d-flex align-items-start">
                                            <span>{{__('defaultTheme.contact')}}</span>
                                            <h5 class="m-0 flex-fill">
                                                @if(auth()->check())
                                                    {{auth()->user()->email != null?auth()->user()->email : auth()->user()->phone}}
                                                @else
                                                    {{$address->email}}
                                                @endif
                                            </h5>
                                            <a href="{{url('/checkout')}}" class="edit_info_text">{{__('common.change')}}</a>
                                        </div>
                                        <div class="single_shipingV3_info d-flex align-items-start">
                                            <span>{{__('defaultTheme.ship_to')}}</span>
                                            <h5 class="m-0 flex-fill">{{$address->address}}</h5>
                                            <a href="{{url('/checkout')}}" class="edit_info_text">{{__('common.change')}}</a>
                                        </div>
                                        @if(!isModuleActive('MultiVendor'))
                                            <div class="single_shipingV3_info d-flex align-items-start">
                                                <span>{{__('common.method')}}</span>
                                                <h5 class="m-0 flex-fill">{{$selected_shipping_method->method_name}} - {{single_price($shipping_cost)}}</h5>
                                                <a href="{{url()->previous()}}" class="edit_info_text">{{__('common.change')}}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb_10">
                                    <h3 class="check_v3_title2 mb-2 ">{{__('common.payment')}}</h3>
                                    <h6 class="shekout_subTitle_text">{{__('defaultTheme.all_transactions_are_secure_and_encrypted')}}.</h6>
                                </div>
                                <div class="col-12">
                                    <div id="accordion" class="checkout_acc_style1 mb_30" >
                                        @foreach($gateway_activations as $key => $payment)

                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                                            <label class="primary_bulet_checkbox">
                                                                <input type="radio" name="payment_method" class="payment_method" data-name="{{$payment->method}}" data-id="{{encrypt($payment->id)}}" value="{{$payment->id}}" {{$key == 0?'checked':''}}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <span>{{$payment->method}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$key}}" class="collapse {{$key == 0?'show':''}}" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @if($payment->method == 'Cash On Delivery')
                                                                <div class="col-lg-12 text-center mt_5 mb_25">
                                                                    <span></span>
                                                                </div>
                                                            @elseif($payment->method == 'Wallet')
                                                                <div class="col-lg-12 text-center mt_5 mb_25">
                                                                    <strong>{{__('common.balance')}}: {{single_price(auth()->user()->CustomerCurrentWalletAmounts)}}</strong>
                                                                    <br>
                                                                    <span></span>
                                                                </div>
                                                            @elseif($payment->method == 'Stripe')
                                                                <div class="col-lg-12 text-center mt_5 mb_25">
                                                                    <span></span>
                                                                </div>
                                                                <form action="{{route('frontend.order_payment')}}" method="post" id="stripe_form" class="stripe_form d-none">
                                                                    <input type="hidden" name="method" value="Stripe">
                                                                    <input type="hidden" name="amount" value="{{$total_amount}}">
                                                                    <button type="submit" id="stribe_submit_btn" class="btn_1 order_submit_btn">{{ __('defaultTheme.process_to_payment') }}</button>
                                                                    @csrf
                                                                    <script
                                                                        src="https://checkout.stripe.com/checkout.js"
                                                                        class="stripe-button"
                                                                        data-key="{{ env('STRIPE_KEY') }}"
                                                                        data-name="Stripe Payment"
                                                                        data-image="{{asset(asset_path(app('general_setting')->favicon))}}"
                                                                        data-locale="auto"
                                                                        data-currency="usd">
                                                                    </script>
                                                                </form>
                                                            @elseif(isModuleActive('Bkash') && $payment->method=="Bkash")
                                                                <form action="{{route('frontend.order_payment')}}" method="post" id="bkash_form" class="bkash_form d-done">
                                                                    @csrf
                                                                    @if(env('IS_BKASH_LOCALHOST') === "1")
                                                                        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
                                                                                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
                                                                        <script id="myScript"
                                                                                src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
                                                                    @else
                                                                        <script id="myScript"
                                                                                src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
                                                                    @endif

                                                                    <input type="hidden" name="method" value="{{$payment->method}}">
                                                                    <input type="hidden" name="type" value="Payment">
                                                                    <input type="hidden" name="amount" value="{{$total_amount}}">
                                                                    <input type="hidden" name="trxID" id="trxID" value="">

                                                                    <button type="button"  class="Payment_btn d-none" id="bKash_button"
                                                                            onclick="BkashPayment()">
                                                                        bkash
                                                                    </button>

                                                                    @php
                                                                        $type = 'Payment';
                                                                        $amount = $total_amount;
                                                                    @endphp
                                                                    @include('bkash::bkash-script',compact('type','amount'))

                                                                </form>

                                                            @elseif($payment->method == 'PayPal')
                                                                <form action="{{route('frontend.order_payment')}}" method="post" class="paypal_form_payment_23 d-none">
                                                                    @csrf
                                                                    <input type="hidden" name="method" value="Paypal">
                                                                    <input type="hidden" name="purpose" value="order_payment">
                                                                    <input type="hidden" name="amount" value="{{ $total_amount }}">

                                                                    <button type="submit" class="btn_1 order_submit_btn paypal_btn d-none">{{ __('defaultTheme.process_to_payment') }}</button>
                                                                </form>
                                                            @elseif($payment->method == 'PayStack')
                                                                <form action="{{route('frontend.order_payment')}}" method="post" id="paystack_form" class="paystack_form d-none">
                                                                    @csrf
                                                                    <input type="hidden" name="email" value="{{$address->email}}"> {{-- required --}}
                                                                    <input type="hidden" name="orderID" value="{{md5(uniqid(rand(), true))}}">
                                                                    <input type="hidden" name="amount" value="{{ $total_amount*100}}">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <input type="hidden" name="currency" value="NGN">

                                                                    <input type="hidden" name="method" value="Paystack">

                                                                    <button type="submit" class="btn_1 order_submit_btn" id="paystack_btn">{{ __('defaultTheme.process_to_payment') }}</button>

                                                                </form>
                                                            @elseif($payment->method == 'RazorPay')
                                                                <form action="{{route('frontend.order_payment')}}" method="POST" id="razor_form" class="razor_form d-none">
                                                                    <input type="hidden" name="method" value="RazorPay">
                                                                    <input type="hidden" name="amount" value="{{ $total_amount * 100 }}">


                                                                    <button type="submit" class="btn_1 order_submit_btn" id="razorpay_btn">{{ __('defaultTheme.process_to_payment') }}</button>
                                                                    @csrf
                                                                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_KEY') }}"
                                                                        data-amount="{{ $total_amount * 100 }}" data-name="{{str_replace('_', ' ',config('app.name') ) }}"
                                                                        data-description="Order Total" data-image="{{asset(asset_path(app('general_setting')->favicon))}}"
                                                                        data-prefill.name="{{$address->name}}"
                                                                        data-prefill.email="{{$address->email}}"
                                                                        data-theme.color="#ff7529">
                                                                    </script>
                                                                </form>
                                                            @elseif($payment->method == 'Instamojo')
                                                                <div class="col-lg-12">
                                                                    <form id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="method" value="Instamojo">
                                                                        <input type="hidden" name="amount" value="{{ $total_amount}}">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="name" placeholder="{{ __('common.name') }}" value="{{$address->name}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.email') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="email" placeholder="{{ __('common.email') }}" value="{{$address->email}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="mobile" placeholder="{{ __('common.mobile') }}" value="{{@old('mobile')}}">
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn_1 d-none" id="instamojo_btn" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                                                                    </form>
                                                                </div>
                                                            @elseif($payment->method == 'PayTM')
                                                                <div class="col-lg-12">
                                                                    <form id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="method" value="PayTm">
                                                                        <input type="hidden" name="amount" value="{{ $total_amount}}">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="name" placeholder="{{ __('common.name') }}" value="{{$address->name}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.email') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="email" placeholder="{{ __('common.email') }}" value="{{$address->email}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="mobile" placeholder="{{ __('common.mobile') }}" value="{{@old('mobile')}}">
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn_1 d-none" id="paytm_btn" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                                                                    </form>
                                                                </div>

                                                            @elseif($payment->method == 'Midtrans')
                                                                @php
                                                                    $unique_id = (auth()->check()) ? auth()->user()->id : rand(1111,99999);
                                                                @endphp
                                                                <form action="{{route('frontend.order_payment')}}" method="post" id="midtrans_payment_form" class="midtrans_payment_form d-none">
                                                                    @csrf
                                                                    <input type="hidden" name="amount" value="{{ $total_amount }}">
                                                                    <input type="hidden" name="ref_no" value="{{ rand(1111,99999).'-'.date('y-m-d').'-'.$unique_id }}">

                                                                    <input type="hidden" name="method" value="Midtrans">

                                                                    <button type="submit" class="btn_1 order_submit_btn" id="midtrans_btn">{{__('defaultTheme.process_to_payment')}}</button>
                                                                </form>
                                                            @elseif($payment->method == 'PayUMoney')
                                                                @php
                                                                    $MERCHANT_KEY = env('PAYU_MONEY_KEY');
                                                                    $SALT = env('PAYU_MONEY_SALT');
                                                                    // Merchant Key and Salt as provided by Payu.

                                                                    if (env('PAYU_MONEY_MODE') == "TEST_MODE") {
                                                                        $PAYU_BASE_URL = "https://test.payu.in/_payment";
                                                                    }
                                                                    else {
                                                                        $PAYU_BASE_URL = "https://secure.payu.in/_payment";
                                                                    }
                                                                    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
                                                                    $posted =  array(
                                                                        'key' => $MERCHANT_KEY,
                                                                        'txnid' => $txnid,
                                                                        'amount' => $total_amount,
                                                                        'firstname' => $address->name,
                                                                        'email' => $address->email,
                                                                        'phone' => null,
                                                                        'productinfo' => 'walletRecharge',
                                                                        'surl' => route('payumoney.success'),
                                                                        'furl' => route('payumoney.failed'),
                                                                        'service_provider' => 'payu_paisa',
                                                                        );

                                                                    $hash = '';
                                                                    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

                                                                    if(empty($posted['hash']) && sizeof($posted) > 0) {
                                                                        $hashVarsSeq = explode('|', $hashSequence);
                                                                        $hash_string = '';
                                                                        foreach($hashVarsSeq as $hash_var) {
                                                                            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                                                                            $hash_string .= '|';
                                                                        }
                                                                        $hash_string .= $SALT;

                                                                        $hash = strtolower(hash('sha512', $hash_string));
                                                                    }
                                                                @endphp

                                                                <div class="col-lg-12">
                                                                    <form id="contactForm" enctype="multipart/form-data" action="{{$PAYU_BASE_URL}}" class="p-0" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="method" value="PayUMoney">
                                                                        <input type="hidden" name="amount" value="{{ $total_amount}}">

                                                                        <input type="hidden" name="key" value="{{ $MERCHANT_KEY }}"/>
                                                                        <input type="hidden" name="txnid" value="{{ $txnid }}"/>
                                                                        <input type="hidden" name="surl" value="{{ route('payumoney.success') }}"/>
                                                                        <input type="hidden" name="furl" value="{{ route('payumoney.success') }}"/>
                                                                        <input type="hidden" name="hash" value="{{ $hash }}"/>
                                                                        <input type="hidden" name="service_provider" value="payu_paisa"/>
                                                                        <input type="hidden" name="productinfo" value="Checkout"/>

                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="name" placeholder="{{ __('common.name') }}" value="{{$address->name}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.email') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="email" placeholder="{{ __('common.email') }}" value="{{$address->email}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="mobile" placeholder="{{ __('common.mobile') }}" value="{{@old('mobile')}}">
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn_1 d-none" id="payumoney_btn" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                                                                    </form>
                                                                </div>
                                                            @elseif($payment->method == 'JazzCash')
                                                                @php
                                                                    if (env('Jazz_MODE') == "sandbox") {
                                                                        $PAYU_BASE_URL = "https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/";
                                                                    }
                                                                    else {
                                                                        $PAYU_BASE_URL = env('JAZZ_LIVE_URL');
                                                                    }
                                                                    $pp_Amount 	= $total_amount * 100;
                                                                    $DateTime 		= new \DateTime();
                                                                    $pp_TxnDateTime = $DateTime->format('YmdHis');
                                                                    $ExpiryDateTime = $DateTime;
                                                                    $ExpiryDateTime->modify('+' . 1 . ' hours');
                                                                    $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
                                                                    $pp_TxnRefNo = 'T'.$pp_TxnDateTime;
                                                                    $post_data =  array(
                                                                        "pp_Version" 			=> "2.0",
                                                                        "pp_IsRegisteredCustomer"=>"No",
                                                                        "pp_TxnType" 			=> "MPAY",
                                                                        "pp_Language" 			=> "EN",
                                                                        "pp_MerchantID" 		=> env('Jazz_MERCHANT_ID'),
                                                                        "pp_SubMerchantID" 		=> "",
                                                                        "pp_Password" 			=> env('Jazz_PASSWORD'),
                                                                        "pp_BankID" 			=> "",
                                                                        "pp_ProductID" 			=> "",
                                                                        "pp_TxnRefNo" 			=> $pp_TxnRefNo,
                                                                        "pp_Amount" 			=> $pp_Amount,
                                                                        "pp_TxnCurrency" 		=> "PKR",
                                                                        "pp_TxnDateTime" 		=> $pp_TxnDateTime,
                                                                        "pp_BillReference" 		=> "checkoutPay",
                                                                        "pp_Description" 		=> "Checkout Purpose Payment",
                                                                        "pp_TxnExpiryDateTime" 	=> $pp_TxnExpiryDateTime,
                                                                        "pp_ReturnURL" 			=> route('jazzcash.payment_status'),
                                                                        "pp_SecureHash" 		=> "",
                                                                        "ppmpf_1" 				=> "1",
                                                                        "ppmpf_2" 				=> "2",
                                                                        "ppmpf_3" 				=> "3",
                                                                        "ppmpf_4" 				=> "4",
                                                                        "ppmpf_5" 				=> "5",
                                                                    );

                                                                    $str = '';
                                                                    foreach($post_data as $key => $value){
                                                                        if(!empty($value)){
                                                                            $str = $str . '&' . $value;
                                                                        }
                                                                    }

                                                                    $str = env('Jazz_SALT').$str;

                                                                    $pp_SecureHash = hash_hmac('sha256', $str, env('Jazz_SALT'));

                                                                    $post_data['pp_SecureHash'] = $pp_SecureHash;
                                                                @endphp

                                                                <form id="contactForm" action="{{ $PAYU_BASE_URL }}" class="p-0" method="POST" class="d-none">

                                                                    @foreach($post_data as $key => $value)
                                                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                                    @endforeach
                                                                    <button class="btn_1 d-none" type="submit" id="jazzcash_btn">{{ __('wallet.continue_to_pay') }}</button>
                                                                </form>
                                                            @elseif($payment->method == 'Google Pay')
                                                                <a class="btn_1 pointer d-none" id="buyButton">{{ __('wallet.continue_to_pay') }}</a>
                                                            @elseif($payment->method == 'FlutterWave')
                                                                <div class="col-lg-12">
                                                                    <form id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="method" value="flutterwave">
                                                                        <input type="hidden" name="amount" value="{{ $total_amount}}">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="name" placeholder="{{ __('common.name') }}" value="{{$address->name}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.email') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="email" placeholder="{{ __('common.email') }}" value="{{$address->email}}">
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <label for="">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="text" required name="phone" placeholder="{{ __('common.mobile') }}" value="{{@old('phone')}}">
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn_1 d-none" id="flutterwave_btn" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                                                                    </form>
                                                                </div>
                                                            @elseif($payment->method == 'Bank Payment')
                                                                <div class="col-lg-12">
                                                                    <section class="send_query bg-white contact_form">
                                                                        <form name="bank_payment" id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="method" value="BankPayment">
                                                                            <div class="row">
                                                                                <div class="col-xl-6 col-md-6">
                                                                                    <label for="name" class="mb-2">{{ __('payment_gatways.bank_name') }}
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.bank_name') }}" name="bank_name" value="{{@old('bank_name')}}">
                                                                                    <span class="invalid-feedback" role="alert" id="bank_name"></span>
                                                                                </div>
                                                                                <div class="col-xl-6 col-md-6">
                                                                                    <label for="name" class="mb-2">{{ __('payment_gatways.branch_name') }}
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input type="text" required name="branch_name" class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.branch_name') }}" value="{{@old('branch_name')}}">
                                                                                    <span class="invalid-feedback" role="alert" id="owner_name"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-20">
                                                                                <div class="col-xl-6 col-md-6">
                                                                                    <label for="name" class="mb-2">{{ __('payment_gatways.account_number') }}
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.account_number') }}" name="account_number" value="{{@old('account_number')}}">
                                                                                    <span class="invalid-feedback" role="alert" id="account_number"></span>
                                                                                </div>
                                                                                <div
                                                                                    class="col-xl-6 col-md-6">
                                                                                    <label for="name" class="mb-2">{{ __('payment_gatways.account_holder') }}
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input type="text" required name="account_holder" class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.account_holder') }}" value="{{@old('account_holder')}}">
                                                                                    <span class="invalid-feedback" role="alert" id="account_holder"></span>
                                                                                </div>
                                                                                <input type="hidden" name="bank_amount" value="{{ $total_amount}}">

                                                                            </div>
                                                                            <div class="row  mb-20">

                                                                                <div
                                                                                    class="col-xl-12 col-md-12">
                                                                                    <label for="name" class="mb-2">{{ __('payment_gatways.cheque_slip') }}<span>*</span></label>
                                                                                    <input type="file" required name="image" class="primary_input4 form-control mb_20">
                                                                                    <span class="invalid-feedback" role="alert" id="amount_validation"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table class="table table-bordered">

                                                                                        <tr>
                                                                                            <td>{{ __('payment_gatways.bank_name') }}</td>
                                                                                            <td>{{env('BANK_NAME')}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>{{ __('payment_gatways.branch_name') }}</td>
                                                                                            <td>{{env('BRANCH_NAME')}}</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td>{{ __('payment_gatways.account_number') }}</td>
                                                                                            <td>{{env('ACCOUNT_NUMBER')}}</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td>{{ __('payment_gatways.account_holder') }}</td>
                                                                                            <td>{{env('ACCOUNT_HOLDER')}}</td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="send_query_btn d-flex justify-content-between">
                                                                                <button class="btn_1 d-none" id="bank_btn" type="submit">{{ __('common.payment') }}</button>
                                                                            </div>
                                                                        </form>
                                                                    </section>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="col-lg-12">

                                    <div class="row">
                                        <div class="col-12 mb_10">
                                            <h3 class="check_v3_title2 mb-2 ">{{__('common.billing_address')}}</h3>
                                        </div>
                                        <div class="col-12">
                                            <div id="accordion2" class="checkout_acc_style1 style2 mb_30" >
                                                <div class="card">
                                                    <div class="card-header" id="headingOne1">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link"  type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="{{$billing_address?'true':'false'}}" aria-controls="collapseTwo2">
                                                                <label class="primary_bulet_checkbox">
                                                                    <input type="radio" name="is_same_billing" value="1" {{$billing_address?'':'checked'}}>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span>{{__('defaultTheme.same_as_shipping_address')}}</span>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2" data-parent="#accordion2">
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo1">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="{{$billing_address?'true':'false'}}" aria-controls="collapseTwo" type="button">
                                                            <label class="primary_bulet_checkbox">
                                                                <input type="radio" name="is_same_billing" value="0" {{$billing_address?'checked':''}}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <span>{{__('defaultTheme.use_a_different_billing_address')}}</span>
                                                        </button>
                                                    </h5>
                                                    </div>
                                                    <div id="collapseTwo1" class="collapse {{$billing_address?'show':''}}" aria-labelledby="headingTwo1" data-parent="#accordion2">
                                                        <div class="card-body">
                                                            <div class="row">

                                                                @if(auth()->check())
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="name">{{__('defaultTheme.address_list')}} <span class="text-danger">*</span></label>
                                                                            <select class="form-control nc_select" name="address_id" id="address_id">
                                                                            <option value="0">{{__('defaultTheme.new_address')}}</option>
                                                                                @foreach (auth()->user()->customerAddresses->where('is_shipping_default',0) as $address)
                                                                                    <option value="{{$address->id}}" @if(isset($shipping_address) && $shipping_address->id == $address->id) selected @endif >{{$address->address}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <input type="hidden" id="address_id" value="0" name="address_id">
                                                                @endif
                                                                <div class="col-lg-6">
                                                                    <label for="name">{{__('common.name')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_name">{{ $errors->first('name') }}</span>
                                                                    <input class="form-control" type="text" id="name" name="name"
                                                                        placeholder="{{__('common.name')}}" value="{{isset($billing_address)?$billing_address->name:''}}">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label for="name">{{__('common.address')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_address">{{ $errors->first('address') }}</span>
                                                                    <input class="form-control" type="text" id="address" name="address"
                                                                        placeholder="{{__('common.address')}}" value="{{isset($billing_address)?$billing_address->address:''}}">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                <label for="name">{{__('common.email')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_email">{{ $errors->first('email') }}</span>
                                                                <input class="form-control" type="text" id="email" name="email"
                                                                    placeholder="{{__('common.email')}}" value="{{isset($billing_address)?$billing_address->email:''}}">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                <label for="name">{{__('common.phone')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_phone">{{ $errors->first('phone') }}</span>
                                                                <input class="form-control" type="text" id="phone" name="phone"
                                                                    placeholder="{{__('common.phone')}}" value="{{isset($billing_address)?$billing_address->phone:''}}">
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                <label>{{__('common.country')}} <span class="text-red">*</span></label>
                                                                <select class="primary_select nc_select" name="country" id="country" autocomplete="off">
                                                                    <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                                    @foreach ($countries as $key => $country)
                                                                        <option value="{{ $country->id }}" @if(isset($billing_address) && $billing_address->country == $country->id) selected @elseif(!isset($billing_address) && app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger" id="error_country">{{ $errors->first('country') }}</span>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                <label>{{__('common.state')}} <span class="text-red">*</span></label>
                                                                <select class="primary_select nc_select" name="state" id="state" autocomplete="off">
                                                                    <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                                    @if(app('general_setting')->default_country != null)
                                                                        @foreach ($states as $state)
                                                                            <option value="{{$state->id}}" @if(isset($billing_address) && $billing_address->state == $state->id) selected @elseif(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger" id="error_state">{{ $errors->first('state') }}</span>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                <label>{{__('common.city')}} <span class="text-red">*</span></label>

                                                                <select class="primary_select nc_select" name="city" id="city" autocomplete="off">
                                                                    <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                                    @foreach ($cities as $city)
                                                                        <option value="{{$city->id}}" @if(isset($billing_address) && $billing_address->city == $city->id) selected @endif>{{$city->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger" id="error_city">{{ $errors->first('city') }}</span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label for="postal_code">{{__('common.postal_code')}}</label>
                                                                    <input class="form-control" type="text" id="postal_code" name="postal_code" placeholder="{{__('common.postal_code')}}" value="{{isset($billing_address)?$billing_address->postal_code:''}}">
                                                                </div>
                                                                <input type="hidden" id="token" value="{{csrf_token()}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="check_v3_btns flex-wrap d-flex align-items-center">

                                                    <div id="btn_div">
                                                        @php
                                                            $payment_id = encrypt(0);
                                                            $url = '';
                                                            if(count($gateway_activations) > 0 && $gateway_activations[0]->id == 1 || count($gateway_activations) > 0 && $gateway_activations[0]->id == 2){
                                                                $gateway_id = (count($gateway_activations) > 0)?encrypt($gateway_activations[0]->id):0;
                                                                $url = url('/checkout?').'gateway_id='.$gateway_id.'&payment_id='.$payment_id.'&step=complete_order';
                                                                $pay_now_btn = '<a href="'.$url.'" id="payment_btn_trigger" class="btn_1 m-0 text-uppercase">Pay now</a>';
                                                            }else {
                                                                $method = '';
                                                                if(count($gateway_activations) > 0){
                                                                    $method = $gateway_activations[0]->method;
                                                                }
                                                                $pay_now_btn = '<a href="javascript:void(0)" id="payment_btn_trigger" data-type="'.$method.'" class="btn_1 m-0 text-uppercase">Pay now</a>';
                                                            }
                                                        @endphp


                                                        {!! $pay_now_btn !!}
                                                    </div>
                                                    <input type="hidden" value="{{encrypt(0)}}" id="off_payment_id">
                                                @if(isModuleActive('MultiVendor'))
                                                    <a href="{{url()->previous()}}" class="return_text">{{__('defaultTheme.return_to_information')}}</a>
                                                @else
                                                    <a href="{{url()->previous()}}" class="return_text">{{__('defaultTheme.return_to_shipping')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout_v3_right d-flex justify-content-start">
                <div class="order_sumery_box flex-fill">
                    @if(!isModuleActive('MultiVendor'))
                        @php
                            $total = 0;
                            $subtotal = 0;
                            $additional_shipping = 0;
                            $tax = 0;
                            $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['within_a_single_state'])->get();
                            $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                            $flatTax = \Modules\GST\Entities\GstTax::where('id', app('gst_config')['flat_tax_id'])->first();
                        @endphp
                        @foreach($cartData as $key => $cart)
                            @if($cart->product_type == 'product')
                                <div class="singleVendor_product_lists">
                                    <div class="singleVendor_product_list d-flex align-items-center">
                                        <div class="thumb single_thumb">
                                            <img src="
                                                @if($cart->product->product->product->product_type == 1)
                                                {{asset(asset_path($cart->product->product->product->thumbnail_image_source))}}
                                                @else
                                                {{asset(asset_path(@$cart->product->sku->variant_image?@$cart->product->sku->variant_image:@$cart->product->product->product->thumbnail_image_source))}}
                                                @endif
                                            " alt="">
                                        </div>
                                        <div class="product_list_content">
                                            <h4><a href="{{route('frontend.item.show',$cart->product->product->slug)}}">{{ \Illuminate\Support\Str::limit(@$cart->product->product->product_name, 28, $end='...') }}</a></h4>
                                            @if($cart->product->product->product->product_type == 2)
                                                @php
                                                    $countCombinatiion = count(@$cart->product->product_variations);
                                                @endphp
                                                <p>
                                                @foreach($cart->product->product_variations as $key => $combination)
                                                    @if($combination->attribute->name == 'Color')
                                                    {{$combination->attribute->name}}: {{$combination->attribute_value->color->name}}
                                                    @else
                                                    {{$combination->attribute->name}}: {{$combination->attribute_value->value}}
                                                    @endif

                                                    @if($countCombinatiion > $key +1)
                                                    ,
                                                    @endif
                                                @endforeach
                                                </p>
                                            @endif
                                            <h5 class="d-flex align-items-center"><span
                                                    class="product_count_text">{{$cart->qty}}<span>x</span></span>{{single_price($cart->price)}}</h5>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $subtotal += $cart->total_price;
                                    $additional_shipping += $cart->product->sku->additional_shipping;
                                @endphp

                                @if (file_exists(base_path().'/Modules/GST/'))
                                    @if ($address && app('gst_config')['enable_gst'] == "gst")
                                        @if (app('general_setting')->state_id == $address->state)

                                            @foreach ($sameStateTaxes as $key => $sameStateTax)
                                                @php
                                                    $gstAmount = $cart->total_price * $sameStateTax->tax_percentage / 100;
                                                    $tax += $gstAmount;
                                                @endphp
                                            @endforeach
                                        @else

                                            @foreach ($diffStateTaxes as $key => $diffStateTax)
                                                @php
                                                    $gstAmount = $cart->total_price * $diffStateTax->tax_percentage / 100;
                                                    $tax += $gstAmount;
                                                @endphp
                                            @endforeach
                                        @endif

                                    @else
                                        @php
                                            $gstAmount = $cart->total_price * $flatTax->tax_percentage / 100;
                                            $tax += $gstAmount;
                                        @endphp

                                    @endif

                                @endif

                            @else
                                <div class="singleVendor_product_lists">
                                    <div class="singleVendor_product_list d-flex align-items-center">
                                        <div class="thumb single_thumb">
                                            <img src="{{asset(asset_path(@$cart->giftCard->thumbnail_image))}}" alt="">
                                        </div>
                                        <div class="product_list_content">
                                            <h4><a href="{{route('frontend.gift-card.show',$cart->giftCard->sku)}}">{{ \Illuminate\Support\Str::limit(@$cart->giftCard->name, 28, $end='...') }}</a></h4>
                                            <h5 class="d-flex align-items-center"><span class="product_count_text" >{{$cart->qty}}<span>x</span></span>{{single_price($cart->price)}}</h5>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $subtotal += $cart->total_price;

                                @endphp
                            @endif
                        @endforeach

                        @php
                            $total = $subtotal + $tax + $shipping_cost;
                        @endphp
                    @endif
                    <h3 class="check_v3_title mb_25">{{__('common.order_summary')}}</h3>
                    @if(isModuleActive('MultiVendor'))
                        @php
                            $total = $total_amount;
                        @endphp
                    @endif
                    <div class="subtotal_lists">
                        <div class="single_total_list d-flex align-items-center">
                            <div class="single_total_left flex-fill">
                                <h4 >{{ __('common.subtotal') }}</h4>
                            </div>
                            <div class="single_total_right">
                                <span>+ {{single_price($subtotal_without_discount)}}</span>
                            </div>
                        </div>
                        <div class="single_total_list d-flex align-items-center flex-wrap">
                            <div class="single_total_left flex-fill">
                                <h4>{{__('common.shipping_charge')}}</h4>
                                <p>{{ __('defaultTheme.package_wise_shipping_charge') }}</p>
                            </div>
                            <div class="single_total_right">
                                <span>+ {{single_price(collect($shipping_cost)->sum())}}</span>
                            </div>
                        </div>
                        <div class="single_total_list d-flex align-items-center flex-wrap">
                            <div class="single_total_left flex-fill">
                                <h4>{{__('common.discount')}}</h4>
                            </div>
                            <div class="single_total_right">
                                <span>- {{single_price($discount)}}</span>
                            </div>
                        </div>
                        <div class="single_total_list d-flex align-items-center flex-wrap">
                            <div class="single_total_left flex-fill">
                                <h4>{{__('common.tax')}}/{{__('gst.gst')}}</h4>
                            </div>
                            <div class="single_total_right">
                                <span>+ {{single_price($tax_total)}}</span>
                            </div>
                        </div>
                        @isset($coupon_amount)
                            <div class="single_total_list d-flex align-items-center flex-wrap">
                                <div class="single_total_left flex-fill">
                                    <h4>{{__('common.coupon')}} {{__('common.discount')}}</h4>
                                </div>
                                <div class="single_total_right">
                                    <span>- {{single_price($coupon_amount)}}</span>
                                </div>
                            </div>
                            @php
                                $total = $total - $coupon_amount;
                            @endphp
                        @endisset
                        <div class="total_amount d-flex align-items-center flex-wrap">
                            <div class="single_total_left flex-fill">
                                <span class="total_text">{{__('common.total')}} (Incl. {{__('common.tax')}}/{{__('gst.gst')}})</span>
                            </div>
                            <div class="single_total_right">
                                <span class="total_text"> <span>{{single_price($total)}}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $(document).on('change', 'input[type=radio][name=payment_method]', function(){
                    let method = $(this).data('name');
                    $('#order_payment_method').val($(this).val());
                    let payment_id = $('#off_payment_id').val();
                    let gateway_id = $(this).data('id');
                    let baseUrl = $('#url').val();
                    if(method === 'Cash On Delivery'){
                        var url = baseUrl + '/checkout?gateway_id='+gateway_id+'&payment_id='+payment_id+'&step=complete_order';
                        $('#btn_div').html(`<a href="`+url+`" id="payment_btn_trigger" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    if(method === 'Wallet'){
                        var url = baseUrl + '/checkout?gateway_id='+gateway_id+'&payment_id='+payment_id+'&step=complete_order';
                        $('#btn_div').html(`<a href="`+url+`" id="payment_btn_trigger" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    if(method === 'Bkash'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Bkash" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    if(method === 'Stripe'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Stripe" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'PayPal'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayPal" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'PayStack'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayStack" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'RazorPay'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="RazorPay" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'Instamojo'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Instamojo" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'PayTM'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayTM" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'Midtrans'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Midtrans" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'PayUMoney'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayUMoney" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'JazzCash'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="JazzCash" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'Google Pay'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Google Pay" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'FlutterWave'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="FlutterWave" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }
                    else if(method === 'Bank Payment'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Bank Payment" class="btn_1 m-0 text-uppercase">Pay now</a>`);
                    }

                });

                $(document).on('click', '#payment_btn_trigger', function(){
                    let method = $(this).data('type');
                    let is_same_billing = $('input[type=radio][name=is_same_billing]:checked').val();
                    $('#error_name').text('');
                    $('#error_email').text('');
                    $('#error_phone').text('');
                    $('#error_address').text('');
                    $('#error_country').text('');
                    $('#error_state').text('');
                    $('#error_city').text('');
                    let is_true = 0;
                    if(is_same_billing == 0){
                        if($('#name').val() == ''){
                            $('#error_name').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#email').val() == ''){
                            $('#error_email').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#phone').val() == ''){
                            $('#error_phone').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#address').val() == ''){
                            $('#error_address').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#country').val() == ''){
                            $('#error_country').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#state').val() == ''){
                            $('#error_state').text('This Field is Required.');
                            is_true = 1;
                        }
                        if($('#city').val() == ''){
                            $('#error_city').text('This Field is Required.');
                            is_true = 1;
                        }
                        if(is_true === 1){
                            return false;
                        }
                        let data = {
                            address_id: $('#address_id').val(),
                            name: $('#name').val(),
                            email: $('#email').val(),
                            address: $('#address').val(),
                            phone: $('#phone').val(),
                            country: $('#country').val(),
                            state: $('#state').val(),
                            city: $('#city').val(),
                            postal_code: $('#postal_code').val(),
                            _token: $('#token').val()
                        }
                        $.post("{{route('frontend.checkout.billing.address.store')}}",data, function(response){
                            paymentAction(method);
                        }).fail(function(response) {
                            $('#error_name').text(response.responseJSON.errors.name);
                            $('#error_address').text(response.responseJSON.errors.address);
                            $('#error_email').text(response.responseJSON.errors.email);
                            $('#error_phone').text(response.responseJSON.errors.phone);
                            $('#error_country').text(response.responseJSON.errors.country);
                            $('#error_state').text(response.responseJSON.errors.state);
                            $('#error_city').text(response.responseJSON.errors.city);
                            return false;
                        });

                    }else{
                        paymentAction(method);
                    }

                });
                function paymentAction(method){
                    if(method == 'Stripe'){
                        $('#stribe_submit_btn').click();
                    }
                    else if(method == 'PayPal'){
                        $('.paypal_btn').click();
                    }
                    else if(method == 'PayStack'){
                        $('#paystack_btn').click();
                    }
                    else if(method == 'RazorPay'){
                        $('#razorpay_btn').click();
                    }
                    else if(method == 'Instamojo'){
                        $("#instamojo_btn").click();
                    }
                    else if(method == 'PayTM'){
                        $("#paytm_btn").click();
                    }
                    else if(method == 'Midtrans'){
                        $("#midtrans_btn").click();
                    }
                    else if(method == 'PayUMoney'){
                        $("#payumoney_btn").click();
                    }
                    else if(method == 'JazzCash'){
                        $("#jazzcash_btn").click();
                    }
                    else if(method == 'Google Pay'){
                        $("#buyButton").click();
                    }
                    else if(method == 'FlutterWave'){
                        $("#flutterwave_btn").click();
                    }
                    else if(method == 'Bank Payment'){
                        $("#bank_btn").click();
                    }
                    else if(method == 'Bkash'){
                        $("#bKash_button").click();
                    }
                }

                $(document).on('change', '#address_id', function(event) {
                    let data = {
                        _token:"{{csrf_token()}}",
                        id: $(this).val()
                    }
                    $('#pre-loader').show();
                    $.post("{{route('frontend.checkout.address.billing')}}",data, function(res){
                        $('#pre-loader').hide();
                        let address = res.address;
                        let states = res.states;
                        let cities = res.cities;
                        $('#name').val(address.name);
                        $('#address').val(address.address);
                        $('#email').val(address.email);
                        $('#phone').val(address.phone);
                        $('#postal_code').val(address.postal_code);
                        $('#country').val(address.country);

                        $('#state').empty();
                        $('#state').append(
                            `<option value="">Select from options</option>`
                        );
                        $.each(states, function(index, stateObj) {
                            $('#state').append('<option value="' + stateObj
                                .id + '">' + stateObj.name + '</option>');
                        });
                        $('#state').val(address.state);

                        $('#city').empty();
                        $('#city').append(
                            `<option value="">Select from options</option>`
                        );
                        $.each(cities, function(index, cityObj) {
                            $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });
                        $('#city').val(address.city);
                        $('select').niceSelect('update');

                    });
                });

                $(document).on('change', '#country', function(event) {
                    let country = $('#country').val();
                    $('#pre-loader').show();
                    if (country) {
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-state?country_id=' + country;

                        $('#state').empty();

                        $('#state').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#state').niceSelect('update');
                        $('#city').empty();
                        $('#city').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#city').niceSelect('update');
                        $.get(url, function(data) {

                            $.each(data, function(index, stateObj) {
                                $('#state').append('<option value="' + stateObj
                                    .id + '">' + stateObj.name + '</option>');
                            });

                            $('#state').niceSelect('update');
                            $('#pre-loader').hide();
                        });
                    }
                });

                $(document).on('change', '#state', function(event){
                    let state = $('#state').val();
                    $('#pre-loader').show();
                    if(state){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-city?state_id=' +state;


                        $('#city').empty();
                        $('#city').append(
                            `<option value="">Select from options</option>`
                        );
                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#city').niceSelect('update');
                            $('#pre-loader').hide();
                        });
                    }
                });

            });

        })(jQuery);
    </script>

    <script type="text/javascript">
        const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
        const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
        if (window.PaymentRequest) {
            const request = createPaymentRequest();

            request.canMakePayment()
            .then(function(result) {
                if (result) {
                // Display PaymentRequest dialog on interaction with the existing checkout button
                document.getElementById('buyButton')
                .addEventListener('click', onBuyClicked);
                }
            })
            .catch(function(err) {
                showErrorForDebugging(
                'canMakePayment() error! ' + err.name + ' error: ' + err.message);
            });
        } else {
            showErrorForDebugging('PaymentRequest API not available.');
        }

        /**
        * Show a PaymentRequest dialog after a user clicks the checkout button
        */
        function onBuyClicked() {
            createPaymentRequest()
            .show()
            .then(function(response) {
                // Dismiss payment dialog.
                response.complete('success');
                console.log(response);
                console.log(response.requestId);
                // handlePaymentResponse(response);
                storeData(response.requestId);
            })
            .catch(function(err) {
                showErrorForDebugging(
                    'show() error! ' + err.name + ' error: ' + err.message);
            });
        }

        /**
        * Define your unique Google Pay API configuration
        *
        * @returns {object} data attribute suitable for PaymentMethodData
        */
        function getGooglePaymentsConfiguration() {
            return {
                environment: '{{ env('GOOGLE_PAY_ENVIRONMENT') }}',
                apiVersion: 2,
                apiVersionMinor: 0,
                merchantInfo: {
                    // A merchant ID is available after approval by Google.
                    // 'merchantId':'12345678901234567890',
                    merchantName: '{{ env('GOOGLE_PAY_MERCHANT_NAME') }}'
                },
                allowedPaymentMethods: [{
                type: 'CARD',
                parameters: {
                    allowedAuthMethods: allowedCardAuthMethods,
                    allowedCardNetworks: allowedCardNetworks
                },
                tokenizationSpecification: {
                    type: 'PAYMENT_GATEWAY',
                    // Check with your payment gateway on the parameters to pass.
                    // @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway}
                    parameters: {
                    'gateway': '{{ env('GOOGLE_PAY_GATEWAY') }}',
                    'gatewayMerchantId': '{{ env('GOOGLE_PAY_MERCHANT_ID') }}'
                    }
                }
                }]
            };
        }

        /**
        * Create a PaymentRequest
        *
        * @returns {PaymentRequest}
        */
        function createPaymentRequest() {
            // Add support for the Google Pay API.
            const methodData = [{
                supportedMethods: 'https://google.com/pay',
                data: getGooglePaymentsConfiguration()
            }];
            // Add other supported payment methods.
            methodData.push({
                supportedMethods: 'basic-card',
                data: {
                supportedNetworks:
                    Array.from(allowedCardNetworks, (network) => network.toLowerCase())
                }
            });

            const details = {
                total: {label: 'Test Purchase', amount: {currency: 'USD', value: '{{ $total_amount }}'}}
            };

            const options = {
                requestPayerEmail: true,
                requestPayerName: true
            };

            return new PaymentRequest(methodData, details, options);
        }

        /**
        * Process a PaymentResponse
        *
        * @param {PaymentResponse} response returned when a user approves the payment request
        */
        function handlePaymentResponse(response) {
            const formattedResponse = document.createElement('pre');
            formattedResponse.appendChild(
            document.createTextNode(JSON.stringify(response.toJSON(), null, 2)));
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', formattedResponse);
        }

        /**
        * Display an error message for debugging
        *
        * @param {string} text message to display
        */
        function showErrorForDebugging(text) {
            const errorDisplay = document.createElement('code');
            errorDisplay.style.color = 'red';
            errorDisplay.appendChild(document.createTextNode(text));
            const p = document.createElement('p');
            p.appendChild(errorDisplay);
            // document.getElementById('gPayBtn').insertAdjacentElement('afterend', p);
        }

        function storeData(el)
        {
            $.post('{{ route('googlePay.payment_status') }}', {_token:'{{ csrf_token() }}', purpose:'order_payment', amount:'{{ $total_amount }}', requestId:el}, function(data){
            if(data == 0){
                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                location.reload()
            }
            else{
                toastr.success("{{__('common.transaction_successfully')}}","{{__('common.success')}}")
                location.replace(data);
            }
        });
        }
    </script>
@endpush
