
<div class="modal fade admin-query" id="Withdraw_Modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('wallet.details_info') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form class="withdrawRequestStatus" method="post">
                    <div class="row">
                        @if($transaction->status != 1 && permissionCheck('wallet.withdraw_request_status_update'))
                        <div class="col-lg-12 statusDiv">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for=""> <strong>{{ __('wallet.Approval') }}</strong> </label>
                                <select class="primary_select mb-25" name="status" id="status">
                                    <option {{$transaction->status == 0?'selected':''}} value="0">{{ __('common.pending') }}</option>
                                    <option {{$transaction->status == 1?'selected':''}} value="1">{{ __('common.approved') }}</option>
                                    <option {{$transaction->status == 2?'selected':''}} value="2">{{ __('common.declined') }}</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <input type="hidden" name="edit_id" class="edit_id" value="{{$transaction->id}}">
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <table class="table Crm_table_active3">
                                        <tr>
                                            <th>{{ __('common.name') }}</th>
                                            <td class="name">{{@$transaction->user->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.email') }}</th>
                                            <td class="email">{{@$transaction->user->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.username') }}</th>
                                            <td class="user_name">{{@$transaction->user->user_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('wallet.running_balance') }}</th>
                                            <td class="running_balance">{{ @$transaction->user->SellerCurrentWalletAmounts }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('wallet.pending_withdraw_request_balance') }}</th>
                                            <td class="pending_withdraw_balance">{{@$transaction->user->SellerPendingWithdrawAmounts}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('wallet.remaining_balance') }}</th>
                                            <td class="remaining_balance">{{@$transaction->user->SellerCurrentWalletAmounts - @$transaction->user->SellerPendingWithdrawAmounts}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('wallet.requested_amount') }}</th>
                                            <td class="amount">{{single_price($transaction->amount)}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>{{ __('common.bank_name') }}</th>
                                            <td class="bank_name">{{@$transaction->user->SellerBankAccount->bank_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.account_number') }}</th>
                                            <td class="bank_account_number">{{@$transaction->user->SellerBankAccount->bank_account_number}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.branch_name') }}</th>
                                            <td class="bank_branch_name">{{@$transaction->user->SellerBankAccount->bank_branch_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.routing_number') }}</th>
                                            <td class="bank_routing_number">{{@$transaction->user->SellerBankAccount->bank_routing_number}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('wallet.bank_ibn') }}</th>
                                            <td class="bank_ibn">{{@$transaction->user->SellerBankAccount->bank_ibn}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('common.type') }}</th>
                                            <td class="type">{{@$transaction->type}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if($transaction->status != 1 && permissionCheck('wallet.withdraw_request_status_update'))
                        <div class="col-lg-12 text-center btnDiv">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn radius_30px mr-10 fix-gr-bg link_btn" id="save_status"><i class="ti-check"></i>{{ __('wallet.update') }}
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
