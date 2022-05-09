<form id="formData" action="" method="POST" enctype="multipart/form-data">
    <div class="row">

    <input type="hidden" name="id" id="id" value="{{$return->id}}">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                            <input id="mainTitle" name="mainTitle" class="primary_input_field" placeholder="-"
                        type="text" value="{{$return->mainTitle}}">
                        </div>
                        <span class="text-danger" id="error_mainTitle"></span>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="slug">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                            <input id="slug" name="slug" class="primary_input_field" placeholder="-" type="text"
                                value="{{$return->slug}}">
                        </div>
                        <span class="text-danger" id="error_slug"></span>
                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="returnTitle">{{__('frontendCms.return_title') }} <span class="text-danger">*</span></label>
                            <input id="returnTitle" name="returnTitle" class="primary_input_field" placeholder="-" type="text"
                                value="{{$return->returnTitle}}">
                        </div>
                        <span class="text-danger" id="error_returnTitle"></span>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="returnDescription">{{ __('frontendCms.return_details') }} <span class="text-danger">*</span></label>
                            <textarea id="returnDescription" name="returnDescription"
                                class="lms_summernote">{{$return->returnDescription}}</textarea>
                        </div>
                        <span class="text-danger" id="error_returnDescription"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-7">


                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="exchangeTitle">{{ __('frontendCms.exchange_title') }} <span class="text-danger">*</span></label>
                            <input id="exchangeTitle" name="exchangeTitle" class="primary_input_field" placeholder="-" type="text"
                        value="{{$return->exchangeTitle}}">
                        </div>
                        <span class="text-danger" id="error_exchangeTitle"></span>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="">{{ __('frontendCms.exchange_details') }} <span class="text-danger">*</span></label>
                            <textarea id="exchangeDescription" name="exchangeDescription"
                                class="lms_summernote">{{$return->exchangeDescription}}</textarea>
                        </div>
                        <span class="text-danger" id="error_exchangeDescription"></span>
                    </div>
                </div>
            </div>
        </div>
        @if (permissionCheck('frontendcms.return-exchange.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="update"><i
                            class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
