<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="IM_API_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.api_key') }}</label>
                <input name="IM_API_KEY" class="primary_input_field" value="{{ env('IM_API_KEY') }}"
                    placeholder="{{ __('payment_gatways.api_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="Instamojo Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="IM_AUTH_TOKEN">
                <label class="primary_input_label" for="">{{ __('payment_gatways.auth_token') }}</label>
                <input name="IM_AUTH_TOKEN" class="primary_input_field" value="{{ env('IM_AUTH_TOKEN') }}"
                    placeholder="{{ __('payment_gatways.auth_token') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="IM_URL">
                <label class="primary_input_label" for="">{{ __('payment_gatways.instamojo_url') }}</label>
                <input name="IM_URL" class="primary_input_field" value="{{ env('IM_URL') }}"
                    placeholder="{{ __('payment_gatways.instamojo_url') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="Instamojo_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoInstamojo">{{ __('product.Browse') }}
                        </label>
                        <input type="file" class="d-none" name="logo" id="logoInstamojo" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'Instamojo')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'Instamojo')->first()->logo)
                <img id="logoInstamojoDiv" class=""
                    src="{{ showImage($gateway_activations->where('method', 'Instamojo')->first()->logo) }}" alt="">
                @else
                <img id="logoInstamojoDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
