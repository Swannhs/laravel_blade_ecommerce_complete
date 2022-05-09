<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('refund.edit_reason') }}</h3>
    </div>
</div>
<form action="" method="POST" id="reasonEditForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <input type="text" class="edit_id d-none" value="0">
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{__("refund.reason")}} <span class="text-danger">*</span></label>
                    <input name="reason" class="primary_input_field reason" placeholder="{{__("refund.reason")}}" type="text">
                    <span class="text-danger" id="edit_reason_error"></span>
                </div>
            </div>
            @if (permissionCheck('refund.reasons_update'))
                <div class="col-lg-12 text-center">
                    <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
                </div>
            @else
                <div class="col-lg-12 text-center mt-2">
                    <span class="alert alert-warning" role="alert">
                        <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
                    </span>
                </div>
            @endif
        </div>
    </div>
</form>
