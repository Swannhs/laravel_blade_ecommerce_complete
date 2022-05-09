<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('order.add_new_reason') }}</h3>
    </div>
</div>
<form action="#" method="POST" enctype="multipart/form-data" id="processForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("order.reason")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="name" id="name" placeholder="{{__("order.reason")}}" type="text" value="{{old('name')}}">
                    <span class="text-danger" id="name_create_error"></span>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("refund.description")}} <span class="text-danger">*</span></label>
                    <textarea class="primary_textarea height_112" name="description" maxlength="255"></textarea>
                    <span class="text-danger" id="description_create_error"></span>
                </div>
            </div>
            @if (permissionCheck('order_manage.cancel_reason_store'))
                <div class="col-lg-12 text-center">
                    <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}} </button>
                </div>
            @else
                <div class="col-lg-12 text-center mt-2">
                    <span class="alert alert-warning" role="alert">
                        <strong>{{__("common.not_permit")}}</strong>
                    </span>
                </div>
            @endif
        </div>
    </div>
</form>
