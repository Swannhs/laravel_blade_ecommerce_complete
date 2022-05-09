<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.edit_unit') }}</h3>
    </div>
</div>
<form action="" method="POST" id="unitEditForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <input type="text" style="display: none;" class="edit_id" value="0">
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.name') }} *</label>
                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.name') }}" type="text">
                    <span class="text-danger" id="edit_name_error"></span>
                </div>
            </div>
            <div class="col-lg-12">
               <div class="primary_input">
                   <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                   <ul id="theme_nav" class="permission_list sms_list ">
                       <li>
                           <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                               <input name="status" id="status_active" value="1" checked="true" class="active"
                                   type="radio">
                               <span class="checkmark"></span>
                           </label>
                           <p>{{ __('common.active') }}</p>
                       </li>
                       <li>
                           <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                               <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                               <span class="checkmark"></span>
                           </label>
                           <p>{{ __('common.inactive') }}</p>
                       </li>
                   </ul>
                   <span class="text-danger" id="edit_status_error"></span>
               </div>
           </div>

            @if (permissionCheck('product.units.store'))
                <div class="col-lg-12 text-center">
                    <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.update")}} </button>
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
