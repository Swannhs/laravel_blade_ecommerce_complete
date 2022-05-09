
<div class="modal fade admin-query" id="Recharge_Modal_Offline">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('wallet.enter_your_amount_to_recharge') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form  action="{{route('wallet_recharge.offline')}}" method="post" id="recharge_form">
                    @csrf
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.user') }} {{ __('common.type') }}<span class="text-danger">*</span></label>
                                <select class="primary_select mb-25" name="role_id" id="role_id">
                                    <option value="4">Customer</option>
                                    @if(isModuleActive('MultiVendor'))
                                    <option value="5">Seller</option>
                                    @endif
                                </select>
                                <span class="text-danger" id="role_id_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                <select class="primary_select mb-25" name="user_id" id="user_id">
                                    <option value="" selected disabled>{{__('common.select_one')}}</option>
                                    @foreach ($users as $key => $user)
                                        <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="user_id_error"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('wallet.amount') }} <span class="text-danger">*</span></label>
                                <input name="recharge_amount" id="amount_id" class="primary_input_field" placeholder="{{ __('wallet.amount') }}" type="number" min="0" value="0">
                                <span class="text-danger" id="recharge_amount_error"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('wallet.any_comment') }} <span class="text-danger">*</span></label>
                                <textarea class="primary_textarea height_112 payment_method" id="comment_id" placeholder="{{ __('wallet.any_comment') }}" max-maxlength="255" name="payment_method" spellcheck="false"></textarea>
                                <span class="text-danger" id="comment_error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('wallet.continue') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
