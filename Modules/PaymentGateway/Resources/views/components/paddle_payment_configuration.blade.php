<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PADDLE_SANDBOX">
                <label class="primary_input_label" for="">{{ __('payment_gatways.environment') }}</label>
                <select class="primary_select mb-25" name="PADDLE_SANDBOX" id="PADDLE_SANDBOX" required>
                    <option value="false" @if (env('PADDLE_SANDBOX')=="true" ) selected @endif>
                        {{ __('payment_gatways.sandbox_environment') }}</option>
                    <option value="true" @if (env('PADDLE_SANDBOX')=="false" ) selected @endif>
                        {{ __('payment_gatways.production_environment') }}</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="name" value="Paddle Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PADDLE_VENDOR_ID">
                <label class="primary_input_label" for="">{{ __('payment_gatways.vendor_id') }}</label>
                <input name="PADDLE_VENDOR_ID" class="primary_input_field" value="{{ env('PADDLE_VENDOR_ID') }}"
                    placeholder="{{ __('payment_gatways.vendor_id') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PADDLE_PUBLIC_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.public_key') }}</label>
                <input name="PADDLE_PUBLIC_KEY" class="primary_input_field" value="{{ env('PADDLE_PUBLIC_KEY') }}"
                    placeholder="{{ __('payment_gatways.public_key') }}" type="text">
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PADDLE_VENDOR_AUTH_CODE">
                <label class="primary_input_label" for="">{{ __('payment_gatways.vendor_auth_code') }}</label>
                <input name="PADDLE_VENDOR_AUTH_CODE" class="primary_input_field"
                    value="{{ env('PADDLE_VENDOR_AUTH_CODE') }}"
                    placeholder="{{ __('payment_gatways.vendor_auth_code') }}" type="text">
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="logoPaddle_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoPaddle">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logoPaddle" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'Paddle')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'Paddle')->first()->logo)
                <img id="logoPaddleDiv"
                    src="{{ showImage($gateway_activations->where('method', 'Paddle')->first()->logo) }}" alt="">
                @else
                <img id="logoPaddleDiv" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
