<form id="{{ $form_id }}" method="POST" action="" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.title') }} <span class="text-danger">*</span></label>
                <input name="title" class="primary_input_field title"
                    id="title" placeholder="{{ __('common.title') }}"
                    type="text">
            </div>
            <span class="text-danger"  id="create_error_title"></span>
        </div>


        <div class="col-xl-12" id="img_div_for_work">
            <div class="primary_input mb-35">
                <label class="primary_input_label" for="">{{__('common.image')}} <small class="ml-1">(60x60)px</small> <span class="text-danger">*</span></label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="working_process_{{$form_id}}"
                        placeholder="{{__('common.browse_image_file')}}" readonly="">
                    <button class="" type="button">
                    <label class="primary-btn small fix-gr-bg" for="{{$form_id}}_image"><span
                                class="ripple rippleEffect browse_file_label"></span>{{__('common.browse')}}</label>
                        <input name="image" type="file" class="d-none working_process_img" id="{{$form_id}}_image" data-show_name_id="#working_process_{{$form_id}}" data-img_id="#workImgShow_{{$form_id}}">
                    </button>
                    <span class="text-danger" id="create_error_image"></span><br>
                    <img id="workImgShow_{{$form_id}}" class="workProcessImg"
                    src="{{showImage('backend/img/default.png')}}" alt="">
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="primary_input">
                <label class="primary_input_label" for="">{{ __('frontendCms.position') }} <span
                    class="text-danger">*</span></label>
                <ul id="theme_nav" class="permission_list sms_list ">
                    <li>
                        <label data-id="bg_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="position" id="position_left" value="1" checked="true" class="active" type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('frontendCms.left') }}</p>
                    </li>
                    <li>
                        <label data-id="color_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="position" value="0" id="position_right"  class="de_active"
                                   type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('frontendCms.right') }}</p>
                    </li>
                </ul>
            </div>
            <span class="text-danger" id="create_error_position"></span>
        </div>

        <div class="col-xl-6">
            <div class="primary_input">
                <label class="primary_input_label" for="">{{ __('common.status') }} <span
                    class="text-danger">*</span></label></label>
                <ul id="theme_nav" class="permission_list sms_list ">
                    <li>
                        <label data-id="bg_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="status" id="status_active" value="1" checked="true" class="active" type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.active') }}</p>
                    </li>
                    <li>
                        <label data-id="color_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="status" value="0" id="status_inactive"  class="de_active"
                                   type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.inactive') }}</p>
                    </li>
                </ul>
            </div>
            <span class="text-danger" id="create_error_status"></span>
        </div>

        <div class="col-xl-12">
            <div class="primary_input mb-35">
                <label class="primary_input_label" for="">{{ __('common.details') }} <span
                        class="text-danger">*</span></label>
                <textarea required name="description" placeholder="{{ __('common.description') }}" class="workProcessText"
                    id="description"></textarea>
            </div>
            <span class="text-danger" id="create_error_description"></span>
        </div>

        <div class="col-lg-12 text-center">
            <div class="d-flex justify-content-center pt_20">
            <button id="{{ $btn_id }}" type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                        class="ti-check"></i>
                        {{ $button_level_name }}
                </button>
            </div>
        </div>

    </div>
</form>
