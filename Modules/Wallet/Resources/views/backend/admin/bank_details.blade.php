
<div class="modal fade admin-query" id="bankDetails">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('wallet.details') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                    <div class="QA_table">
                        <!-- table-responsive -->
                        <div class="table-responsive">
                            <table class="table pos_table pt-0 shadow_none pb-0 ">
                                <tbody>
                                    <tr>
                                        <th scope="col">{{__('common.bank_name')}}</th>
                                        <td id="bank_name"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{__('common.branch_name')}}</th>
                                        <td id="branch_name"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{__('common.account_number')}}</th>
                                        <td id="account_number"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{__('wallet.account_holder')}}</th>
                                        <td id="account_holder"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{__('wallet.check')}}</th>
                                        <td>
                                            <img src="" id="check" alt="" width="120px" height="46px">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
