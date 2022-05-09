<div id="edit_work_modal">
    <div class="modal fade" id="work_edit">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('frontendCms.update_working_process') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body work_edit_form">
                    <input type="hidden" name="id" id="work_id">
                    @include('frontendcms::merchant.working_process.form',['form_id' => 'work_edit_form', 'btn_id' => 'edit_work_btn', 'button_level_name' => __('common.update') ])
                </div>
            </div>
        </div>
    </div>
</div>