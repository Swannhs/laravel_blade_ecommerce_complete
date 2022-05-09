<div id="edit_faq_modal">
    <div class="modal fade" id="faq_edit">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('frontendCms.faq_update') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body faq_edit_form">
                    <input type="hidden" name="id" id="faq_id">
                    @include('frontendcms::merchant.faq.form',['form_id' => 'faq_edit_form','btn_id' =>'edit_faq_btn', 'button_level_name' => __('common.update') ])
                </div>
            </div>
        </div>
    </div>
</div>