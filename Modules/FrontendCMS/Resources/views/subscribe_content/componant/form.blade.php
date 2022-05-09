<form id="formData" method="POST" enctype="multipart/form-data">
    <div class="row">
        <input type="hidden" name="id" value="{{ $subscribeContent->id }}">
        <input type="hidden" name="status" value="1">
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
                <label class="primary_input_label" for="">{{ __('common.sub_title') }}</label>
                <input name="subtitle" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('subtitle') ? old('subtitle') : $subscribeContent->subtitle }}">
                <span class="text-danger"  id="subtitle_error"></span>
            </div>

        </div>

        <div class="col-xl-12">
            <div class="primary_input mb-35">
                <label class="primary_input_label"
                    for="">{{ __('common.details') }}</label>
                <textarea name="description" id="description"
                    class="lms_summernote">{{ $subscribeContent->description }}</textarea>
                <span class="text-danger"  id="description_error"></span>
            </div>

        </div>
        <div class="col-xl-6 d-none">
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
