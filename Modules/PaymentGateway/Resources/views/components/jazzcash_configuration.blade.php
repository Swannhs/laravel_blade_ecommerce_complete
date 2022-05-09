<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-2 mt-20 mb-30">
            <input type="hidden" name="types[]" value="JAZZ_MODE">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="JAZZ_MODE" @if (env("JAZZ_MODE")=="sandbox" ) checked @endif
                            id="mode_check_4" value="sandbox" class="common-radio relationButton read-only-input">
                        <label for="mode_check_4">{{ __('payment_gatways.sandbox') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 mt-20 mb-30">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="JAZZ_MODE" id="live_mode_check_3" @if (env("JAZZ_MODE")=="live" )
                            checked @endif value="live" class="common-radio relationButton read-only-input">
                        <label for="live_mode_check_3">{{ __('payment_gatways.live') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="JAZZ_MERCHANT_ID">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_id') }}</label>
                <input name="JAZZ_MERCHANT_ID" class="primary_input_field" value="{{ env('JAZZ_MERCHANT_ID') }}"
                    placeholder="{{ __('payment_gatways.merchant_id') }}" type="text">
            </div>
        </div>
        <input type="hidden" name="name" value="JazzCash Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="JAZZ_PASSWORD">
                <label class="primary_input_label" for="">{{ __('payment_gatways.password') }}</label>
                <input name="JAZZ_PASSWORD" class="primary_input_field" value="{{ env('JAZZ_PASSWORD') }}"
                    placeholder="{{ __('payment_gatways.password') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="JAZZ_SALT">
                <label class="primary_input_label" for="">{{ __('payment_gatways.salt_id') }}</label>
                <input name="JAZZ_SALT" class="primary_input_field" value="{{ env('JAZZ_SALT') }}"
                    placeholder="{{ __('payment_gatways.salt_id') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="JAZZ_LIVE_URL">
                <label class="primary_input_label" for="">{{ __('payment_gatways.live_url') }}</label>
                <input name="JAZZ_LIVE_URL" class="primary_input_field" value="{{ env('JAZZ_LIVE_URL') }}"
                    placeholder="{{ __('payment_gatways.live_url') }}" type="text">
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="JazzCash_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoJazzCash">{{ __('product.Browse') }}
                        </label>
                        <input type="file" class="d-none" name="logo" id="logoJazzCash" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ @$gateway_activations->where('method', 'JazzCash')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'JazzCash')->first()->logo)
                <img id="logoJazzCashDiv" class=""
                    src="{{ showImage(@$gateway_activations->where('method', 'JazzCash')->first()->logo) }}" alt="">
                @else
                <img id="logoJazzCashDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
