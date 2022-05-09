<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="RAZOR_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.razor_key') }}</label>
                <input name="RAZOR_KEY" class="primary_input_field" value="{{ env('RAZOR_KEY') }}"
                    placeholder="{{ __('payment_gatways.razor_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="RazorPay Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="RAZORPAY_SECRET">
                <label class="primary_input_label" for="">{{ __('payment_gatways.razor_secret_key') }}</label>
                <input name="RAZORPAY_SECRET" class="primary_input_field" value="{{ env('RAZORPAY_SECRET') }}"
                    placeholder="{{ __('payment_gatways.razor_secret_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="Razor_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoRazor">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logoRazor" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'RazorPay')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'RazorPay')->first()->logo)
                <img id="logoRazorDiv" class=""
                    src="{{ showImage($gateway_activations->where('method', 'RazorPay')->first()->logo) }}" alt="">
                @else
                <img id="logoRazorDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
