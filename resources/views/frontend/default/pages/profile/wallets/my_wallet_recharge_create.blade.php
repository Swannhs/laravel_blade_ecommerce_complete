@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{ __('customer_panel.my_wallet_recharge') }}
@endsection

@section('styles')
    <style>
        .bank_btn{
            padding: 20px 80px;
        }
    </style>
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="dashboard_item">
                    <div class="row">
                        <div class="col-12">
                            <h4>{{ __('common.recharge_amount') }} : {{ single_price($recharge_amount) }}</h4>
                        </div>
                        <div class="col-12">
                            <div class="deposit_lists_wrapper mb-50">
                                @if ($payment_gateways->where('method','Stripe')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <form action="{{route('my-wallet.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="method" value="Stripe">
                                            <input type="hidden" name="amount" value="{{ $recharge_amount }}">

                                            <!-- single_deposite_item  -->
                                            <button type="submit">
                                                <img src="{{showImage($gateway_activations->where('method', 'Stripe')->first()->logo)}}" alt="">
                                            </button>
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
                                    </div>
                                @endif

                                    @if(isModuleActive('Bkash') && $payment_gateways->where('method','Bkash')->first()->active_status == 1)

                                        <form action="{{route('my-wallet.store')}}" method="post" id="bkash_form" class="bkash_form">
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

                                            <input type="hidden" name="method" value="Bkash">
                                            <input type="hidden" name="type" value="wallet_recharge">
                                            <input type="hidden" name="amount" value="{{$recharge_amount}}">
                                            <input type="hidden" name="trxID" id="trxID" value="">

                                            <button type="button"  class="Payment_btn" id="bKash_button" onclick="BkashPayment()">
                                                <img src="{{showImage($gateway_activations->where('method', 'Bkash')->first()->logo)}}" alt="">
                                            </button>

                                            @php
                                                $type = 'wallet_recharge';
                                                $amount = $recharge_amount;
                                            @endphp
                                            @include('bkash::bkash-script',compact('type','amount'))

                                        </form>

                                    @endif

                                @if ($payment_gateways->where('method','RazorPay')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <form action="{{ route('my-wallet.store') }}" method="POST">
                                            <input type="hidden" name="method" value="RazorPay">
                                            <input type="hidden" name="amount" value="{{ $recharge_amount * 100 }}">

                                            <button type="submit">
                                                <img src="{{showImage($gateway_activations->where('method', 'RazorPay')->first()->logo)}}" alt="">
                                            </button>
                                            @csrf
                                            <script
                                                src="https://checkout.razorpay.com/v1/checkout.js"
                                                data-key="{{ env('RAZOR_KEY') }}"
                                                data-amount="{{ $recharge_amount * 100 }}"
                                                data-name="{{str_replace('_', ' ',config('app.name') ) }}"
                                                data-description="Wallet Recharge"
                                                data-image="{{asset(asset_path(app('general_setting')->favicon))}}"
                                                data-prefill.name="{{ auth()->user()->username }}"
                                                data-prefill.email="{{ auth()->user()->email }}"
                                                data-theme.color="#ff7529">
                                            </script>
                                        </form>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','PayPal')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <form action="{{route('my-wallet.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="method" value="Paypal">
                                            <input type="hidden" name="purpose" value="wallet_recharge">
                                            <input type="hidden" name="amount" value="{{ $recharge_amount }}">

                                            <button type="submit">
                                                <img src="{{showImage($gateway_activations->where('method', 'PayPal')->first()->logo)}}" alt="">
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','PayStack')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <form action="{{ route('my-wallet.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ @Auth::user()->email}}"> {{-- required --}}
                                            <input type="hidden" name="orderID" value="{{md5(uniqid(rand(), true))}}">
                                            <input type="hidden" name="amount" value="{{ $recharge_amount*100}}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="currency" value="NGN">
                                            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}

                                            <input type="hidden" name="method" value="Paystack">

                                            <button type="submit">
                                                <img src="{{showImage($gateway_activations->where('method', 'PayStack')->first()->logo)}}">
                                            </button>

                                        </form>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','Bank Payment')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="{{$gateway_activations->where('method', 'Bank Payment')->first()->logo == null?'bank_btn':''}}">
                                            <img src="{{showImage($gateway_activations->where('method', 'Bank Payment')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','PayTM')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#PayTMModal">
                                            <img src="{{showImage($gateway_activations->where('method', 'PayTM')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','Instamojo')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#InstamojoModal">
                                            <img src="{{showImage($gateway_activations->where('method', 'Instamojo')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','Midtrans')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <form action="{{ route('my-wallet.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="method" value="Midtrans">
                                            <input type="hidden" name="amount" value="{{ $recharge_amount * 100 }}">
                                            <input type="hidden" name="ref_no" value="{{ rand(1111,99999).'-'.date('y-m-d').'-'.auth()->user()->id }}">
                                            <button type="submit">
                                                <img src="{{showImage($gateway_activations->where('method', 'Midtrans')->first()->logo)}}" alt="">
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','PayUMoney')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#PayUMoneyModal">
                                            <img src="{{showImage($gateway_activations->where('method', 'PayUMoney')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if ($payment_gateways->where('method','JazzCash')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#JazzCashModal">
                                            <img src="{{showImage($gateway_activations->where('method', 'JazzCash')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if (@$payment_gateways->where('method','Google Pay')->first()->active_status == 1)
                                    <div class="single_deposite" id="gPayBtn">
                                        <a id="buyButton">
                                            <img src="{{showImage($gateway_activations->where('method', 'Google Pay')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif

                                @if (@$payment_gateways->where('method','FlutterWave')->first()->active_status == 1)
                                    <div class="single_deposite">
                                        <a href="#" data-toggle="modal" data-target="#FlutterWaveModal">
                                            <img src="{{showImage($gateway_activations->where('method', 'FlutterWave')->first()->logo)}}" alt="">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include(theme('pages.profile.wallets.components._bank_payment_modal'))
@include(theme('pages.profile.wallets.components._instamojo_payment_modal'))
@include(theme('pages.profile.wallets.components._paytm_payment_modal'))
@include(theme('pages.profile.wallets.components._payumoney_payment_modal'))
@include(theme('pages.profile.wallets.components._jazzcash_payment_modal'))
@include(theme('pages.profile.wallets.components._google_pay_script'))
@include(theme('pages.profile.wallets.components._flutter_wave_payment_modal'))
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($) {
        	"use strict";
            $(document).ready(function() {
                $(".stripe-button-el").remove();
                $(".razorpay-payment-button").hide();

                $('#bankpayment_submit_btn').removeAttr('disabled');
                $('#paytm_submit_btn').removeAttr('disabled');
                $('#intamojo_submit_btn').removeAttr('disabled');
                $('#payumoney_submit_btn').removeAttr('disabled');
                $('#flatter_wave_submit_btn').removeAttr('disabled');

                $(document).on('submit', '#bank_payment_form', function(event){

                    $('#bank_name').text('');
                    $('#branch_name').text('');
                    $('#account_number').text('');
                    $('#account_holder').text('');

                    let name = $('#bank_payment_form > div > div:nth-child(3) > div:nth-child(1) > input').val();
                    let branch_name = $('#bank_payment_form > div > div:nth-child(3) > div:nth-child(2) > input').val();
                    let account_number = $('#bank_payment_form > div > div:nth-child(4) > div:nth-child(1) > input').val();
                    let account_holder = $('#bank_payment_form > div > div:nth-child(4) > div:nth-child(2) > input').val();

                    let val_check = 0;
                    if(name == ''){
                        $('#bank_name').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(branch_name == ''){
                        $('#branch_name').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(account_number == ''){
                        $('#account_number').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(account_holder == ''){
                        $('#account_holder').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(val_check == 1){
                        event.preventDefault();
                    }

                });

                $(document).on('submit', '#paytm_form', function(event){

                    $('#paytm_form > div:nth-child(3) > div:nth-child(1) > span').text('');
                    $('#paytm_form > div:nth-child(3) > div:nth-child(2) > span').text('');
                    $('#error_mobile').text('');
                    $('#paytm_form > div.row.mb-20 > div:nth-child(2) > span').text('');

                    let name = $('#paytm_form > div:nth-child(3) > div:nth-child(1) > input').val();
                    let email = $('#paytm_form > div:nth-child(3) > div:nth-child(2) > input').val();
                    let mobile = $('#paytm_form > div.row.mb-20 > div:nth-child(1) > input').val();
                    let amount = $('#paytm_form > div.row.mb-20 > div:nth-child(2) > input').val();

                    let val_check = 0;
                    if(name == ''){
                        $('#paytm_form > div:nth-child(3) > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(email == ''){
                        $('#paytm_form > div:nth-child(3) > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(mobile == ''){
                        $('#error_mobile').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(amount == ''){
                        $('#paytm_form > div.row.mb-20 > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }


                });

                $(document).on('submit', '#instamojo_form', function(event){

                    $('#instamojo_form > div:nth-child(3) > div:nth-child(1) > span').text('');
                    $('#instamojo_form > div:nth-child(3) > div:nth-child(2) > span').text('');
                    $('#instamojo_form > div.row.mb-20 > div:nth-child(1) > span').text('');
                    $('#instamojo_form > div.row.mb-20 > div:nth-child(2) > span').text('');

                    let name = $('#instamojo_form > div:nth-child(3) > div:nth-child(1) > input').val();
                    let email = $('#instamojo_form > div:nth-child(3) > div:nth-child(2) > input').val();
                    let mobile = $('#instamojo_form > div.row.mb-20 > div:nth-child(1) > input').val();
                    let amount = $('#instamojo_form > div.row.mb-20 > div:nth-child(2) > input').val();

                    let val_check = 0;
                    if(name == ''){
                        $('#instamojo_form > div:nth-child(3) > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(email == ''){
                        $('#instamojo_form > div:nth-child(3) > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(mobile == ''){
                        $('#instamojo_form > div.row.mb-20 > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(amount == ''){
                        $('#instamojo_form > div.row.mb-20 > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }
                });

                $(document).on('submit', '#payumoney_form', function(event){
                    $('#payumoney_form > div.row > div:nth-child(1) > span').text('');
                    $('#payumoney_form > div.row > div:nth-child(2) > span').text('');
                    $('#payumoney_form > div.row > div:nth-child(3) > span').text('');
                    $('#payumoney_form > div.row > div:nth-child(4) > span').text('');

                    let name = $('#payumoney_form > div.row > div:nth-child(1) > input').val();
                    let email = $('#payumoney_form > div.row > div:nth-child(2) > input').val();
                    let mobile = $('#payumoney_form > div.row > div:nth-child(3) > input').val();
                    let amount = $('#payumoney_form > div.row > div:nth-child(4) > input').val();

                    let val_check = 0;
                    if(name == ''){
                        $('#payumoney_form > div.row > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(email == ''){
                        $('#payumoney_form > div.row > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(mobile == ''){
                        $('#payumoney_form > div.row > div:nth-child(3) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(amount == ''){
                        $('#payumoney_form > div.row > div:nth-child(4) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }
                });

                $(document).on('submit', '#flatter_wave_form', function(event){
                    $('#flatter_wave_form > div:nth-child(3) > div:nth-child(1) > span').text('');
                    $('#flatter_wave_form > div:nth-child(3) > div:nth-child(2) > span').text('');
                    $('#flatter_wave_form > div.row.mb-20 > div:nth-child(1) > span').text('');
                    $('#flatter_wave_form > div.row.mb-20 > div:nth-child(2) > span').text('');

                    let name = $('#flatter_wave_form > div:nth-child(3) > div:nth-child(1) > input').val();
                    let email = $('#flatter_wave_form > div:nth-child(3) > div:nth-child(2) > input').val();
                    let mobile = $('#flatter_wave_form > div.row.mb-20 > div:nth-child(1) > input').val();
                    let amount = $('#flatter_wave_form > div.row.mb-20 > div:nth-child(2) > input').val();

                    let val_check = 0;
                    if(name == ''){
                        $('#flatter_wave_form > div:nth-child(3) > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(email == ''){
                        $('#flatter_wave_form > div:nth-child(3) > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(mobile == ''){
                        $('#flatter_wave_form > div.row.mb-20 > div:nth-child(1) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }
                    if(amount == ''){
                        $('#flatter_wave_form > div.row.mb-20 > div:nth-child(2) > span').text("{{__('validation.this_field_is_required')}}");
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }
                });

            });
        })(jQuery);

    </script>

@endpush
