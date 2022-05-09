
    <form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_ENVIRONMENT">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paytm_environment') }}</label>
                <input name="PAYTM_ENVIRONMENT" class="primary_input_field" value="{{ env('PAYTM_ENVIRONMENT') }}"
                    placeholder="{{ __('payment_gatways.paytm_environment') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="Paytm Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_MERCHANT_ID">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_id') }}</label>
                <input name="PAYTM_MERCHANT_ID" class="primary_input_field" value="{{ env('PAYTM_MERCHANT_ID') }}"
                    placeholder="{{ __('payment_gatways.merchant_id') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_MERCHANT_WEBSITE">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_website') }}</label>
                <input name="PAYTM_MERCHANT_WEBSITE" class="primary_input_field"
                    value="{{ env('PAYTM_MERCHANT_WEBSITE') }}"
                    placeholder="{{ __('payment_gatways.merchant_website') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_MERCHANT_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.merchant_key') }}</label>
                <input name="PAYTM_MERCHANT_KEY" class="primary_input_field" value="{{ env('PAYTM_MERCHANT_KEY') }}"
                    placeholder="{{ __('payment_gatways.merchant_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_CHANNEL">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paytm_channel') }}</label>
                <input name="PAYTM_CHANNEL" class="primary_input_field" value="{{ env('PAYTM_CHANNEL') }}"
                    placeholder="{{ __('payment_gatways.paytm_channel') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYTM_INDUSTRY_TYPE">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paytm_industry_type') }}</label>
                <input name="PAYTM_INDUSTRY_TYPE" class="primary_input_field" value="{{ env('PAYTM_INDUSTRY_TYPE') }}"
                    placeholder="{{ __('payment_gatways.paytm_industry_type') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="Paytm_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoPaytm">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logoPaytm" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'PayTM')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'PayTM')->first()->logo)
                <img id="logoPaytmDiv" class=""
                    src="{{ showImage($gateway_activations->where('method', 'PayTM')->first()->logo) }}" alt="">
                @else
                <img id="logoPaytmDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
