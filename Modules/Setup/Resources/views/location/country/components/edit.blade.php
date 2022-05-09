
<div class="main-title">
    <h3 class="mb-20">
        {{__('common.edit')}} {{__('common.country')}}</h3>
</div>



<form enctype="multipart/form-data" id="edit_form">
    <div class="white-box">
        <div class="row">
            <input type="hidden" name="id" value="{{$country->id}}">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="name">{{ __('common.name') }} <span class="text-danger">*</span></label>
                    <input name="name" class="primary_input_field name"
                        id="name" placeholder="{{ __('common.name') }}" value="{{$country->name}}"
                        type="text">
                    <span class="text-danger"  id="error_name"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="code">{{ __('setup.code') }} <span class="text-danger">*</span></label>
                    <input name="code" class="primary_input_field code"
                        id="code" placeholder="{{ __('setup.code') }}"
                        type="text" value="{{$country->code}}">
                    <span class="text-danger"  id="error_code"></span>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="phonecode">{{ __('setup.phonecode') }} <span class="text-danger">*</span></label>
                    <input name="phonecode" class="primary_input_field phonecode"
                        id="phonecode" placeholder="{{ __('setup.phonecode') }}"
                        type="text" value="{{$country->phonecode}}">
                    <span class="text-danger"  id="error_phonecode"></span>
                </div>
            </div>

            <div id="countryFlagFileDiv" class="col-lg-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('setup.flag') }} (61 X 36)</label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="flag_file"
                            placeholder="{{__('common.browse_image')}}" readonly="">
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg"
                                for="flag">{{ __('common.browse') }} </label>
                            <input type="file" class="d-none" name="flag" id="flag">
                        </button>
                    </div>
                </div>

                <span class="text-danger" id="error_slider_image"></span>

            </div>
            <div class="col-lg-4" id="createCountryFlagDiv">
                <div class="flag_img_div">
                    <img id="FlagPreview"
                        src="{{ showImage($country->flag?$country->flag:'flags/no_image.png') }}" alt="">
                </div>

            </div>

            <div class="col-xl-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" {{$country->status == 1?'checked':''}} class="active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive" {{$country->status == 0?'checked':''}} class="de_active"
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
