<form action="{{ route('payment_gateway.configuration') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="BANK_NAME">
                <label class="primary_input_label" for="">{{ __('payment_gatways.bank_name') }}</label>
                <input name="BANK_NAME" class="primary_input_field" value="{{ env('BANK_NAME') }}" placeholder="{{ __('payment_gatways.bank_name') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="BRANCH_NAME">
                <label class="primary_input_label" for="">{{ __('payment_gatways.branch_name') }}</label>
                <input name="BRANCH_NAME" class="primary_input_field" value="{{ env('BRANCH_NAME') }}" placeholder="{{ __('payment_gatways.branch_name') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <input type="hidden" name="name" value="Bank Payment Configuration">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="ACCOUNT_NUMBER">
                <label class="primary_input_label" for="">{{ __('payment_gatways.account_number') }}</label>
                <input name="ACCOUNT_NUMBER" class="primary_input_field" value="{{ env('ACCOUNT_NUMBER') }}" placeholder="{{ __('payment_gatways.account_number') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <input type="hidden" name="types[]" value="ACCOUNT_HOLDER">
                <label class="primary_input_label" for="">{{ __('payment_gatways.account_holder') }}</label>
                <input name="ACCOUNT_HOLDER" class="primary_input_field" value="{{ env('ACCOUNT_HOLDER') }}" placeholder="{{ __('payment_gatways.account_holder') }}" type="text">
                <span class="text-danger" id="edit_name_error"></span>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('payment_gatways.gateway_logo') }} (400x166)PX</label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="bank_image_file" placeholder="{{ __('payment_gatways.gateway_logo') }}" readonly="" />
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="logobank">{{ __('product.Browse') }} </label>
                        <input type="file" class="d-none" name="logo" id="logobank"/>
                    </button>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <input type="hidden" name="id" value="{{ $gateway_activations->where('method', 'Bank Payment')->first()->id }}">
            <div class="logo_div">
                @if ($gateway_activations->where('method', 'Bank Payment')->first()->logo)
                    <img id="BankImgDiv" class="" src="{{ showImage($gateway_activations->where('method', 'Bank Payment')->first()->logo) }}" alt="">
                @else
                    <img id="BankImgDiv" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
        </div>
    </div>
</form>
