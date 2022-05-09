<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-lg-2 mt-20 mb-30">
            <input type="hidden" name="types[]" value="MIDTRANS_ENVIRONMENT">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="MIDTRANS_ENVIRONMENT" @if (env("MIDTRANS_ENVIRONMENT")=="sandbox" ) checked @endif
                            id="MIDTRANS_ENVIRONMENT_mode_check_1" value="sandbox" class="common-radio relationButton read-only-input">
                        <label for="MIDTRANS_ENVIRONMENT_mode_check_1">{{ __('payment_gatways.sandbox') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 mt-20 mb-30">
            <div class="input-effect">
                <div class="input-effect">
                    <div class="text-left float-left">
                        <input type="radio" name="MIDTRANS_ENVIRONMENT" id="MIDTRANS_ENVIRONMENT_live_mode_check_1" @if (env("MIDTRANS_ENVIRONMENT")=="live" ) checked @endif value="live" class="common-radio relationButton read-only-input">
                        <label for="MIDTRANS_ENVIRONMENT_live_mode_check_1">{{ __('payment_gatways.live') }}</label>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="name" value="Midtrans Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="MIDTRANS_MERCHANT_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_server_key') }}</label>
                <input name="MIDTRANS_MERCHANT_KEY" class="primary_input_field" value="{{ env('MIDTRANS_MERCHANT_KEY') }}" placeholder="{{ __('payment_gatways.merchant_server_key') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="MIDTRANS_CLIENT_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_client_key') }}</label>
                <input name="MIDTRANS_CLIENT_KEY" class="primary_input_field" value="{{ env('MIDTRANS_CLIENT_KEY') }}" placeholder="{{ __('payment_gatways.merchant_client_key') }}" type="text">
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="logoMidtrans_file" placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoMidtrans">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logoMidtrans"/>
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'Midtrans')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'Midtrans')->first()->logo)
                    <img id="logoMidtransDiv" class="" src="{{ showImage($gateway_activations->where('method', 'Midtrans')->first()->logo) }}" alt="">
                @else
                    <img id="logoMidtransDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
