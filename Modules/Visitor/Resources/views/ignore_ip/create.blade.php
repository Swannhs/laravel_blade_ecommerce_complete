<div class="box_header common_table_header">
    <div class="main-title d-md-flex">
        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.add_new_ignore_ip') }}</h3>
    </div>
</div>
<form action="#" method="POST" enctype="multipart/form-data" id="unitForm">
    <div class="white_box_50px box_shadow_white mb-20">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for=""> {{__("common.ignore_ip_from_visitor_count")}} <span class="text-danger">*</span></label>
                    <input class="primary_input_field" name="ip" id="ip" placeholder="{{__("common.ignore_ip_from_visitor_count")}}" type="text" value="{{old('ip')}}">
                    <span class="text-danger" id="ip_error"></span>
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
