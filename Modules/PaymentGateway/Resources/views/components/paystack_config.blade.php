<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYSTACK_MERCHANT_EMAIL">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paystack_merchant_email') }}</label>
                <input name="PAYSTACK_MERCHANT_EMAIL" class="primary_input_field"
                    value="{{ env('PAYSTACK_MERCHANT_EMAIL') }}"
                    placeholder="{{ __('payment_gatways.paystack_merchant_email') }}" type="email">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYSTACK_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paystack_key') }}</label>
                <input name="PAYSTACK_KEY" class="primary_input_field" value="{{ env('PAYSTACK_KEY') }}"
                    placeholder="{{ __('payment_gatways.paystack_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="Paystack Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYSTACK_SECRET">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paystack_secret_key') }}</label>
                <input name="PAYSTACK_SECRET" class="primary_input_field" value="{{ env('PAYSTACK_SECRET') }}"
                    placeholder="{{ __('payment_gatways.paystack_secret_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="PAYSTACK_PAYMENT_URL">
                <label class="primary_input_label" for="">{{ __('payment_gatways.paystack_payment_url') }}</label>
                <input name="PAYSTACK_PAYMENT_URL" class="primary_input_field" value="{{ env('PAYSTACK_PAYMENT_URL') }}"
                    placeholder="{{ __('payment_gatways.paystack_payment_url') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="logoPaystack_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoPaystack">{{ __('product.Browse') }}
                        </label>
                        <input type="file" class="d-none" name="logo" id="logoPaystack" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'PayStack')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'PayStack')->first()->logo)
                <img id="logoPaystackDiv" class=""
                    src="{{ showImage($gateway_activations->where('method', 'PayStack')->first()->logo) }}" alt="">
                @else
                <img id="logoPaystackDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
