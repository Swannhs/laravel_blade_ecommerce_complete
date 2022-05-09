<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('setup.edit_tag') }}</h3>
    </div>
</div>
<form action="" method="POST" id="tagEditForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <input type="text" style="display: none;" class="edit_id" value="0">
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.name') }} *</label>
                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.name') }}" type="text" required>
                    <span class="text-danger" id="edit_name_error"></span>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
            </div>
        </div>
    </div>
</form>
