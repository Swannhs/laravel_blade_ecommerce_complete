<div class="modal fade admin-query" id="Item_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('general_settings.edit_currency_info') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('currencies.update', $currency->id) }}" method="POST" id="currencyEditForm">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                <input name="name" class="primary_input_field name" value="{{ $currency->name }}" placeholder="" type="text" required>
                                <span class="text-danger">{{$errors->first("name")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('general_settings.code') }} <span class="text-danger">*</span></label>
                                <input name="code" class="primary_input_field name" value="{{ $currency->code }}" placeholder="" type="text" required>
                                <span class="text-danger">{{$errors->first("code")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('general_settings.symbol') }} <span class="text-danger">*</span></label>
                                <input name="symbol" class="primary_input_field name" value="{{ $currency->symbol }}" placeholder="$" type="text" required>
                                <span class="text-danger">{{$errors->first("symbol")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('general_settings.convert_rate') }} 1 {{app('general_setting')->currency_code}} = ? <span class="text-danger">*</span></label>
                                <input name="convert_rate" class="primary_input_field convert_rate" value="{{ $currency->convert_rate }}" min="0" type="number" step="any" required>
                                <span class="text-danger">{{$errors->first("convert_rate")}}</span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
