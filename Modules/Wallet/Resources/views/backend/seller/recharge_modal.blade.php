
<div class="modal fade admin-query" id="Recharge_Modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('wallet.enter_your_amount_to_recharge') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form  action="{{route('my-wallet.recharge_create')}}" method="post" id="recharge_form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('wallet.amount') }} <span class="text-danger">*</span></label>
                                <input name="recharge_amount" id="recharge_amount" class="primary_input_field" placeholder="{{ __('wallet.amount') }}" type="number" step="{{step_decimal()}}" min="0" value="0">
                                <span class="text-danger" id="recharge_amount_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('wallet.continue') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
