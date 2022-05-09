<div id="add_work_modal">
    <div class="modal fade" id="work_add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('common.add_new') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body work_create_form">
                    {{-- form --}}
                    @include('frontendcms::merchant.working_process.form',['form_id' => 'work_create_form' ,'btn_id' => 'create_work_btn' , 'button_level_name' => __('common.save') ])
                </div>
            </div>
        </div>
    </div>
</div>
