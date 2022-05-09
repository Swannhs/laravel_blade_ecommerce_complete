<div id="show_item_modal">
    <div class="modal fade" id="item_show">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('frontendCms.show pricing') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_edit_form">
                    <h5>{{__('common.name')}}: <p class="d-inline" id="show_name"></p></h5>
                    <h5>{{__('frontendCms.monthly_cost')}}: <p class="d-inline" id="show_monthly_cost"></p></h5>
                    <h5>{{__('frontendCms.yearly_cost')}}: <p class="d-inline" id="show_yearly_cost"></p></h5>
                    <h5>{{__('frontendCms.team_size')}}: <p class="d-inline" id="show_team_size"></p></h5>
                    <h5>{{__('frontendCms.stock_limit')}}: <p class="d-inline" id="show_stock_limit"></p></h5>
                    <h5>{{__('frontendCms.transaction_fee')}}: <p class="d-inline" id="show_transaction_fee"></p></h5>
                </div>
            </div>
        </div>
    </div>
</div>
