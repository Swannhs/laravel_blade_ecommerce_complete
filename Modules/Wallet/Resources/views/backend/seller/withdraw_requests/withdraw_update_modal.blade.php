
<div class="modal fade admin-query" id="Withdraw_EditModal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('wallet.modify_your_amount_to_withdraw') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form  action="{{route('my-wallet.withdraw_request_update')}}" method="post" id="withdraw_update_form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 mb-3">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>{{__('wallet.running_balance')}}</th>
                                            <td class="edit_running_balance text-nowrap"></td>
                                        </tr>
                                        <tr>
                                            <th>{{__('wallet.pending_withdraw_request_balance')}}</th>
                                            <td class="edit_pending_withdraw_balance text-nowrap"></td>
                                        </tr>
                                        <tr>
                                            <th>{{__('wallet.remaining_balance')}}</th>
                                            <td class="edit_remaining_balance text-nowrap"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" class="id" value="">
                        <input type="hidden" name="this_data_amount" id="this_data_amount" value="">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('wallet.amount') }} <span class="text-danger">*</span></label>
                                <input name="amount" class="primary_input_field edit_amount" placeholder="{{ __('wallet.amount') }}" step="{{step_decimal()}}" type="number" min="0" value="0">
                                <span class="text-danger" id="amount_error_update"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('wallet.update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
