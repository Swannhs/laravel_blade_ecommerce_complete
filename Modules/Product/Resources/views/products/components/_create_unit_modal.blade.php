<div class="modal fade admin-query" id="create_unit_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('product.create_unit') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="create_unit_form">
                    <div class="row">
                        <input type="hidden" name="form_type" value="modal_form">

                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("common.name")}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field" name="name" id="name" placeholder="{{__("common.name")}}" type="text" value="{{old('name')}}">
                                <span class="text-danger" id="error_unit_name"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="primary_input">
                               <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                               <ul id="theme_nav" class="permission_list sms_list ">
                                   <li>
                                       <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                           <input name="status" value="1" id="unit_active_status" checked class="active"
                                               type="radio">
                                           <span class="checkmark"></span>
                                       </label>
                                       <p>{{ __('common.active') }}</p>
                                   </li>
                                   <li>
                                       <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                           <input name="status" value="0" class="de_active" id="unit_inactive_status" type="radio">
                                           <span class="checkmark"></span>
                                       </label>
                                       <p>{{ __('common.inactive') }}</p>
                                   </li>
                               </ul>
                               <span class="text-danger" id="error_unit_status"></span>
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
