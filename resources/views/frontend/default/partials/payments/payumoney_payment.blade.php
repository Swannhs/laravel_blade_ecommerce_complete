@if (auth()->check() || session()->has('billing_address'))
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
            'amount' => $grandtotal,
            'firstname' => (auth()->check()) ? auth()->user()->first_name : session()->get('billing_address')['name'],
            'email' => (auth()->check()) ? auth()->user()->email : session()->get('billing_address')['email'],
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
    <div class="modal fade" id="PayUMoneyModal" tabindex="-1" role="dialog" aria-labelledby="PayUMoneyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('wallet.pay_u_money_payment') }}</h5>
                </div>
                <div class="modal-body">
                    <section class="send_query bg-white contact_form">
                        <form id="contactForm" action="{{$PAYU_BASE_URL}}" class="p-0" method="POST">
                            @csrf
                            <input type="hidden" name="method" value="PayUMoney">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="name" class="mb-2">{{ __('common.name') }}<span>*</span></label>
                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('common.name') }}" name="firstname" value="{{(auth()->check()) ? auth()->user()->first_name : session()->get('billing_address')['name']}}">
                                    <span class="invalid-feedback" role="alert" id="name"></span>
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="name" class="mb-2">{{ __('common.email') }}<span>*</span></label>
                                    <input type="email" required name="email" class="primary_input4 form-control mb_20" placeholder="{{ __('common.email') }}" value="{{(auth()->check()) ? auth()->user()->email : session()->get('billing_address')['email']}}">
                                    <span class="invalid-feedback" role="alert" id="email"></span>
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="name" class="mb-2">{{ __('common.amount') }}<span>*</span></label>
                                    <input type="number" min="0" step="{{step_decimal()}}" value="{{ $grandtotal }}" id="amount" name="amount" class="primary_input4 form-control mb_20">
                                    <span class="invalid-feedback" role="alert" id="name"></span>
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="name" class="mb-2">{{ __('common.mobile') }}<span>*</span></label>
                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('common.mobile') }}" name="phone" value="{{@old('mobile')}}">
                                    <span class="invalid-feedback" role="alert" id="mobile"></span>
                                </div>
                            </div>
                            <input type="hidden" name="key" value="{{ $MERCHANT_KEY }}"/>
                            <input type="hidden" name="txnid" value="{{ $txnid }}"/>
                            <input type="hidden" name="surl" value="{{ route('payumoney.success') }}"/>
                            <input type="hidden" name="furl" value="{{ route('payumoney.success') }}"/>
                            <input type="hidden" name="hash" value="{{ $hash }}"/>
                            <input type="hidden" name="service_provider" value="payu_paisa"/>
                            <input type="hidden" name="productinfo" value="Checkout"/>

                            <div class="send_query_btn d-flex justify-content-between mt-4">
                                <button type="button" class="btn_1" data-dismiss="modal">{{ __('common.cancel') }}</button>
                                <button class="btn_1" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endif
