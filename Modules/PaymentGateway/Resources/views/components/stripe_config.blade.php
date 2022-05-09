<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="STRIPE_KEY">
                <label class="primary_input_label" for="">{{ __('payment_gatways.stripe_key') }}</label>
                <input name="STRIPE_KEY" class="primary_input_field" value="{{ env('STRIPE_KEY') }}"
                    placeholder="{{ __('payment_gatways.stripe_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="STRIPE_USER_NAME">
                <label class="primary_input_label" for="">{{ __('payment_gatways.stripe_user_name') }}</label>
                <input name="STRIPE_USER_NAME" class="primary_input_field" value="{{ env('STRIPE_USER_NAME') }}"
                    placeholder="{{ __('payment_gatways.stripe_user_name') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="Stripe Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="STRIPE_SECRET">
                <label class="primary_input_label" for="">{{ __('payment_gatways.stripe_secret_key') }}</label>
                <input name="STRIPE_SECRET" class="primary_input_field" value="{{ env('STRIPE_SECRET') }}"
                    placeholder="{{ __('payment_gatways.stripe_secret_key') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="logoStripe_file"
                        placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logoStripe">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logoStripe" />
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'Stripe')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'Stripe')->first()->logo)
                <img id="logoStripeDiv" class=""
                    src="{{ showImage($gateway_activations->where('method', 'Stripe')->first()->logo) }}" alt="">
                @else
                <img id="logoStripeDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
