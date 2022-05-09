<div id="edit_item_modal">
    <div class="modal fade" id="item_edit">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('frontendCms.update_benefit') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_edit_form">
                    <input type="hidden" name="id" id="item_id">
                    @include('frontendcms::merchant.benefit.form',['form_id' => 'item_edit_form', 'btn_id' => 'edit_benefit_btn', 'button_level_name' => __('common.update') ])
                </div>
            </div>
        </div>
    </div>
</div>