<div class="col-md-12 mb-20">
    <div class="box_header_right">
        <div class=" float-none pos_tab_btn justify-content-start">
            @php
                $methods = [];
                foreach($gateway_activations->where('id','>',2)->where('active_status', 1) as $method){
                    $methods[] = $method;
                }
            @endphp
            <ul class="nav nav_list" role="tablist">
                @if(@$gateway_activations->where('method', 'PayPal')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'PayPal') active show @endif" href="#paypalTab" role="tab"
                        data-toggle="tab" id="1" aria-selected="true">{{__('payment_gatways.paypal')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'Stripe')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'Stripe') active show @endif" href="#stripeTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.stripe')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'PayStack')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'PayStack') active show @endif" href="#paystackTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.paystack')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'RazorPay')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'RazorPay') active show @endif" href="#razorpayTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.razorpay')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'PayTM')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'PayTM') active show @endif" href="#paytmTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.paytm')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'Instamojo')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'Instamojo') active show @endif" href="#instamojoTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.instamojo')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'Midtrans')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'Midtrans') active show @endif" href="#midtransTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.midtrans')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'PayUMoney')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'PayUMoney') active show @endif" href="#payumoneyTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.payumoney')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'JazzCash')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'JazzCash') active show @endif" href="#jazzcashTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.jazzcash')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'Google Pay')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'Google Pay') active show @endif" href="#google_payTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.google_pay')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'FlutterWave')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'FlutterWave') active show @endif" href="#flutterWaveTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.flutter_wave_payment')}}</a>
                </li>
                @endif
                @if(@$gateway_activations->where('method', 'Bank Payment')->first()->active_status == 1)
                <li class="nav-item mb-2">
                    <a class="nav-link @if(@$methods[0]->method == 'Bank Payment') active show @endif" href="#bankTab" role="tab" data-toggle="tab" id="1"
                        aria-selected="true">{{__('payment_gatways.bank_payment')}}</a>
                </li>
                @endif

                @if(isModuleActive('Bkash') && @$gateway_activations->where('method', 'Bkash')->first()->active_status == 1)
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(@$methods[0]->method == 'Bkash') active show @endif" href="#bkashTab" role="tab" data-toggle="tab" id="1"
                           aria-selected="true">{{__('payment_gatways.bkash')}}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="white_box_30px mb_30">
        <div class="tab-content">


            @if(@$gateway_activations->where('method', 'PayPal')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'PayPal') active show @endif" id="paypalTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('payment_gatways.paypal_configuration') }}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'PayPal')->first()->logo) }}" alt="">
                                </div>

                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.paypal_config')

                </div>
            @endif

            @if(@$gateway_activations->where('method', 'Stripe')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'Stripe') active show @endif" id="stripeTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.stripe_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Stripe')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.stripe_config')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'PayStack')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'PayStack') active show @endif" id="paystackTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.paystack_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'PayStack')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.paystack_config')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'RazorPay')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'RazorPay') active show @endif" id="razorpayTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.razorpay_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'RazorPay')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.razorpay_config')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'PayTM')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'PayTM') active show @endif" id="paytmTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.paytm_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'PayTM')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.paytm_config')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'Instamojo')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'Instamojo') active show @endif" id="instamojoTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.instamojo_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Instamojo')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.instamojo_config')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'Midtrans')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'Midtrans') active show @endif" id="midtransTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.midtrans_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Midtrans')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.midtrans_configuration')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'PayUMoney')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'PayUMoney') active show @endif" id="payumoneyTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.payumoney_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'PayUMoney')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.payumoney_configuration')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'JazzCash')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'JazzCash') active show @endif" id="jazzcashTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.jazzcash_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'JazzCash')->first()->logo) }}" alt="" >
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.jazzcash_configuration')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'Google Pay')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'Google Pay') active show @endif" id="google_payTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.google_pay_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Google Pay')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.google_pay_configuration')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'FlutterWave')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if(@$methods[0]->method == 'FlutterWave') active show @endif" id="flutterWaveTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.flutter_wave_payment_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'FlutterWave')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.flutter_wave_payment_configuration')
                </div>
            @endif
            @if(@$gateway_activations->where('method', 'Bank Payment')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if($methods[0]->method == 'Bank Payment') active show @endif" id="bankTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.bank_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Bank Payment')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('paymentgateway::components.bank_config')
                </div>
            @endif

            @if(isModuleActive('Bkash') &&  @$gateway_activations->where('method', 'Bkash')->first()->active_status == 1)
                <div role="tabpanel" class="tab-pane fade @if($methods[0]->method == 'Bkash') active show @endif" id="bkashTab">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('payment_gatways.bkash_configuration')}}</h3>
                            <ul class="d-flex">
                                <div class="img_logo_div">
                                    <img src="{{ showImage(@$gateway_activations->where('method', 'Bkash')->first()->logo) }}" alt="">
                                </div>
                            </ul>
                        </div>
                    </div>
                    @include('bkash::bkash_config')
                </div>
            @endif
        </div>
    </div>
</div>
