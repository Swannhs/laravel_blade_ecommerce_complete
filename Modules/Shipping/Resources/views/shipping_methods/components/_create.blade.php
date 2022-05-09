<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('shipping.add_new_shipping_method') }}</h3>
    </div>
</div>
<form method="POST" enctype="multipart/form-data" id="createForm">
    @csrf
    <div class="white_box p-15 box_shadow_white mb-20">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("shipping.method_name")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="method_name" id="method_name" placeholder="{{__("shipping.method_name")}}" type="text" value="{{old('method_name')}}">
                    <span class="text-danger" id="error_method_name"></span>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("shipping.phone")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="phone" id="phone" placeholder="{{__("shipping.phone")}}" type="text" value="{{old('phone')}}">
                    <span class="text-danger" id="error_phone"></span>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("shipping.shipment_time")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="shipment_time" id="shipment_time" placeholder="{{__("shipping.ex: 3-5 days or 6-12 hrs")}}" type="text" value="{{old('shipment_time')}}">
                    <span class="text-danger" id="error_shipment_time"></span>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("shipping.cost")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="cost" id="cost" placeholder="{{__("shipping.cost")}}" type="number" min="0" step="{{step_decimal()}}" value="{{old('cost')}}">
                    <span class="text-danger" id="error_cost"></span>
                </div>
            </div>
            <div class="col-lg-12" id="method_logo_img_div">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('shipping.logo') }} (150x150)PX</label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="logo_file" placeholder="{{ __('shipping.logo') }}" readonly="">
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg" for="thumbnail_logo">{{ __('product.Browse') }} </label>

                            <input type="file" class="d-none" name="method_logo" id="thumbnail_logo" accept="image/*">
                        </button>
                        <span class="text-danger" id="error_thumbnail_logo"></span>
                    </div>
                </div>
                <div class="logo_div">
                    <img id="ThumbnailImgDiv" src="{{ showImage('backend/img/default.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}} </button>
            </div>
        </div>
    </div>
</form>
