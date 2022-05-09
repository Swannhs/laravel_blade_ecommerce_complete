

<div class="main-title">
    <h3 class="mb-20">
        {{__('frontendCms.edit_feature')}} </h3>
</div>


<form enctype="multipart/form-data" id="item_edit_form">
    <div class="white-box">
        <div class="row">
            <input type="hidden" name="id" value="{{$feature->id}}">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="">{{ __('common.title') }} <span class="text-danger">*</span></label>
                    <input name="title" class="primary_input_field name"
                        id="title" placeholder="{{ __('common.title') }}"
                        type="text" required value="{{$feature->title}}">
                    <span class="text-danger"  id="title_error"></span>
                </div>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                    <input name="slug" class="primary_input_field slug"
                        id="slug" placeholder="{{ __('common.slug') }}"
                        type="text" required value="{{$feature->slug}}">
                    <span class="text-danger"  id="slug_error"></span>
                </div>
            </div>
    
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="">{{ __('common.icon') }} <span class="text-danger">*</span></label>
                    <input name="icon" class="primary_input_field icon"
                        id="icon" placeholder="{{ __('common.icon') }}"
                        type="text" required autocomplete="off" value="{{$feature->icon}}">
                    <span class="text-danger"  id="icon_error"></span>
                </div>
            </div>
    
            <div class="col-xl-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" {{$feature->status == 1?'checked':''}} class="active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive" {{$feature->status == 0?'checked':''}}  class="de_active"
                                       type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.inactive') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
    
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center pt_20">
                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                            class="ti-check"></i>
                            {{ __('common.update') }}
                    </button>
                </div>
            </div>
    
        </div>
    </div>
</form>
