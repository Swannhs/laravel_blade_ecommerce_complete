<form id="formData" action="{{ route('frontendcms.contact-content.update') }}" method="POST">
    <div class="row">
        <input type="hidden" name="id" value="{{ $contactContent->id }}">
        
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.main_title') }} <span class="text-danger">*</span></label>
                <input name="mainTitle" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('mainTitle') ? old('mainTitle') : $contactContent->mainTitle }}">
            </div>
            <span class="text-danger"  id="error_mainTitle"></span>
        </div>
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="subTitle">{{ __('common.sub_title') }} <span class="text-danger">*</span></label>
                <input name="subTitle" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('subTitle') ? old('subTitle') : $contactContent->subTitle }}">
            </div>
            <span class="text-danger"  id="error_subTitle"></span>
        </div>
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                <input id="slug" name="slug" class="primary_input_field" placeholder="-" type="text"
                    value="{{ old('slug') ? old('slug') : $contactContent->slug }}">
            </div>
            <span class="text-danger"  id="error_slug"></span>
        </div>
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label"
                    for="">{{ __('common.email') }} <span class="text-danger">*</span></label>
                <input name="email" class="primary_input_field" placeholder="-" type="email"
                    value="{{ old('email') ? old('email') : $contactContent->email }}">
            </div>
            <span class="text-danger"  id="email_error"></span>
        </div>

        <div class="col-xl-12">
            <div class="primary_input mb-35">
                <label class="primary_input_label"
                    for="">{{ __('common.details') }} <span class="text-danger">*</span></label>
                <textarea name="description"
                    class="lms_summernote">{{ $contactContent->description }}</textarea>
            </div>
            <span class="text-danger"  id="error_description"></span>
        </div>
        <div class="col-lg-12 text-center mb-90">
            <div class="d-flex justify-content-center">
                <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent"
                    type="submit" dusk="update"><i
                        class="ti-check"></i>{{ __('common.update') }}</button>
            </div>
        </div>
    </div>
</form>