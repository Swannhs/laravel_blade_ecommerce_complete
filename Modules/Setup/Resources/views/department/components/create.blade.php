<div id="add_item_modal">
    <div class="modal fade" id="item_add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('common.add_new') }}
                        {{ __('hr.department') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_create_form">
                    {{-- form --}}
                    @include('setup::department.components.form',['form_id' => 'item_create_form', 'button_level_name' => __('common.save') ])
                </div>
            </div>
        </div>
    </div>
</div>
