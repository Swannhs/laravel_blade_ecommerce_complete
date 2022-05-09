<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.add_new_unit') }}</h3>
    </div>
</div>
<form action="#" method="POST" enctype="multipart/form-data" id="unitForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("common.name")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="name" id="name" placeholder="{{__("common.name")}}" type="text" value="{{old('name')}}">
                    <span class="text-danger" id="name_error"></span>
                </div>
            </div>
            <div class="col-lg-12">
               <div class="primary_input">
                   <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                   <ul id="theme_nav" class="permission_list sms_list ">
                       <li>
                           <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                               <input name="status" value="1" checked class="active"
                                   type="radio">
                               <span class="checkmark"></span>
                           </label>
                           <p>{{ __('common.active') }}</p>
                       </li>
                       <li>
                           <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                               <input name="status" value="0" class="de_active" type="radio">
                               <span class="checkmark"></span>
                           </label>
                           <p>{{ __('common.inactive') }}</p>
                       </li>
                   </ul>
                   <span class="text-danger" id="status_error"></span>
               </div>
           </div>
           @if (permissionCheck('product.units.update'))
               <div class="col-lg-12 text-center">
                   <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}} </button>
               </div>
           @else
               <div class="col-lg-12 mt-5 text-center">
                   <span class="alert alert-warning" role="alert">
                    <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
                   </span>
               </div>
           @endif
        </div>
    </div>
</form>
