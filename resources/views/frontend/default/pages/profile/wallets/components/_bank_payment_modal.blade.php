<div class="modal fade admin-query" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('payment_gatways.bank_payment') }}</h5>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <form name="bank_payment" enctype="multipart/form-data" action="{{route('my-wallet.store')}}"
                class="single_account-form" method="POST" id="bank_payment_form">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="method" value="BankPayment">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('payment_gatways.bank_name') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.bank_name') }}"
                                name="bank_name" value="{{@old('bank_name')}}">
                            <span class="text-danger" id="bank_name"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('payment_gatways.branch_name') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" name="branch_name" class="primary_input4 form-control mb_20"
                                placeholder="{{ __('payment_gatways.branch_name') }}" value="{{@old('branch_name')}}">
                            <span class="text-danger" id="branch_name"></span>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('payment_gatways.account_number') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" class="primary_input4 form-control mb_20" placeholder="{{ __('payment_gatways.account_number') }}"
                                name="account_number" value="{{@old('account_number')}}">
                            <span class="text-danger" id="account_number"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('payment_gatways.account_holder') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" name="account_holder" class="primary_input4 form-control mb_20"
                                placeholder="{{ __('payment_gatways.account_holder') }}" value="{{@old('account_holder')}}">
                            <span class="text-danger" id="account_holder"></span>
                        </div>
                        <input type="hidden" name="deposit_amount" value="{{ $recharge_amount}}">

                    </div>

                    <div class="row  mb-20">

                        <div class="col-xl-12 col-md-12">
                            <label for="name" class="mb-2">{{ __('wallet.cheque_slip') }}</label>
                            <input type="file" name="image" class="primary_input4 form-control mb_20">
                            <span class="text-danger" id="cheque"></span>
                        </div>
                    </div>

                    <fieldset class="mt-3">
                        <legend>{{ __('payment_gatways.bank_account_info') }}
                        </legend>
                        <table class="table table-bordered">

                            <tr>
                                <td>{{ __('payment_gatways.bank_name') }}</td>
                                <td>{{env('BANK_NAME')}}</td>
                            </tr>
                            <tr>
                                <td>{{ __('payment_gatways.branch_name') }}</td>
                                <td>{{env('BRANCH_NAME')}}</td>
                            </tr>

                            <tr>
                                <td>{{ __('payment_gatways.account_number') }}</td>
                                <td>{{env('ACCOUNT_NUMBER')}}</td>
                            </tr>

                            <tr>
                                <td>{{ __('payment_gatways.account_holder') }}</td>
                                <td>{{env('ACCOUNT_HOLDER')}}</td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="theme_line_btn btn_1"
                        data-dismiss="modal">{{ __('common.cancel') }}</button>
                    <button class="theme_btn btn_1" type="submit" id="bankpayment_submit_btn"
                        disabled>{{ __('common.payment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
