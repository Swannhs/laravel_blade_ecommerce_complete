<form id="formData" method="POST" enctype="multipart/form-data">
    <div class="row">
        <input type="hidden" name="id" value="{{ $subscribeContent->id }}">
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.title') }}</label>
                <input name="title" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('title') ? old('title') : $subscribeContent->title }}">
                <span class="text-danger"  id="title_error"></span>
            </div>

        </div>
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.sub_title') }} </label>
                <input name="subtitle" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('subtitle') ? old('subtitle') : $subscribeContent->subtitle }}">
                <span class="text-danger"  id="subtitle_error"></span>
            </div>

        </div>
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('frontendCms.popup_show_after_second') }} <span class="text-danger">*</span></label>
                <input name="second" class="primary_input_field" required min="1" placeholder="-" type="number"
                    value="{{ old('second') ? old('second') : $subscribeContent->second }}">
                <span class="text-danger"  id="second_error"></span>
            </div>

        </div>

        <div class="col-xl-6">

            <div class="primary_input">
                <label class="primary_input_label" for="">{{ __('common.status') }} <span class="text-danger">*</span></label>
                <ul id="theme_nav" class="permission_list sms_list ">
                    <li>
                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                            <input name="status" id="status_active" value="1" @if ($subscribeContent->status == 1) checked @endif class="active"
                                type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.active') }}</p>
                    </li>
                    <li>
                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                            <input name="status" value="0" id="status_inactive" @if ($subscribeContent->status == 0) checked @endif class="de_active" type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.inactive') }}</p>
                    </li>
                </ul>
                <span class="text-danger" id="status_error"></span>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="mb-2 mr-30">{{ __('common.image') }}<small>(327x446)px</small></label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{ __('common.browse') }}" readonly="">
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.image")}} </label>
                        <input type="file" class="d-none" name="file" id="document_file_1">
                    </button>
                </div>
                <span class="text-danger"  id="file_error"></span>
                @if ($subscribeContent->image)
                <div class="img_div mt-20">
                    <img id="blogImgShow"
                    src="{{showImage($subscribeContent->image)}}" alt="">
                </div>
                @else
                <div class="img_div mt-20">
                   <img id="blogImgShow"
                   src="{{showImage('backend/img/default.png')}}" alt="">
                </div>
                @endif
            </div>
        </div>

        @if (permissionCheck('frontendcms.subscribe-content.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent"
                        type="submit" dusk="update"><i
                            class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
