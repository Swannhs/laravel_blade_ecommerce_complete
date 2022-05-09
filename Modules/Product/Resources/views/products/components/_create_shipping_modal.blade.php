<div class="modal fade admin-query" id="create_shipping_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('shipping.create_shipping_method') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="create_shipping_form">
                    <div class="row">
                        <input type="hidden" name="form_type" value="modal_form">

                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("shipping.method_name")}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field" name="method_name" id="method_name" placeholder="{{__("shipping.method_name")}}" type="text" value="{{old('method_name')}}">
                                <span class="text-danger" id="error_shipping_method_name"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("shipping.phone")}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field" name="phone" id="phone" placeholder="{{__("shipping.phone")}}" type="text" value="{{old('phone')}}">
                                <span class="text-danger" id="error_shipping_phone"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("shipping.shipment_time")}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field" name="shipment_time" id="shipment_time" placeholder="{{__("shipping.ex: 3-5 days or 6-12 hrs")}}" type="text" value="{{old('shipment_time')}}">
                                <span class="text-danger" id="error_shipping_shipment_time"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("shipping.cost")}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field" name="cost" id="cost" placeholder="{{__("shipping.cost")}}" type="number" min="0" step="{{step_decimal()}}" value="{{old('cost')}}">
                                <span class="text-danger" id="error_shipping_cost"></span>
                            </div>
                        </div>
                        <div class="col-lg-12" id="method_logo_img_div">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('shipping.logo') }} </label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="shipping_logo_file" placeholder="{{ __('shipping.logo') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="thumbnail_logo">{{ __('product.Browse') }} </label>

                                                <input type="file" class="d-none" name="method_logo" id="thumbnail_logo">
                                            </button>
                                            <span class="text-danger" id="error_shipping_method_logo"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="shiping_logo_div">
                                        <img id="shipping_logo" class="" src="{{ showImage('backend/img/default.png') }}" alt="">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-12 text-center">
                            <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}} </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
