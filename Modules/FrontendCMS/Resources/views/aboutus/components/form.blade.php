<form action="{{ route('frontendcms.about-us.update', $aboutus->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="row">
        <div class="col-xl-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>

        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">
                    <input type="hidden" name="id" value="{{$aboutus->id}}">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('common.main_title')}} <span class="text-danger">*</span></label>
                                <input name="mainTitle" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('mainTitle')? old('mainTitle'):$aboutus->mainTitle }}">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('common.sub_title')}} <span class="text-danger">*</span></label>
                                <input name="subTitle" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('subTitle')? old('subTitle'):$aboutus->subTitle }}">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('common.slug')}} <span class="text-danger">*</span></label>
                                <input name="slug" id="slug" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('slug')? old('slug'):$aboutus->slug }}">
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{__('common.image_first_section')}} <small
                                        class="ml-1">(545x600)px</small> <span class="text-danger">*</span></label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input" type="text" id="image_sec_1"
                                        placeholder="{{__('common.browse_image_file')}}" readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg" for="document_file_1"><span
                                                class="ripple rippleEffect browse_file_label"></span>{{__('common.browse')}}</label>
                                        <input name="sec1_image" type="file" class="d-none" id="document_file_1">
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <img id="AboutUsImgShow_1" class="aboutUsImg"
                                            src="{{ showImage($aboutus->sec1_image?$aboutus->sec1_image:'backend/img/default.png') }}" alt="">
                        </div>

                        <div class="col-xl-8">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{__('common.image_second_section')}} <small
                                        class="ml-1">(545x600)px</small> <span class="text-danger">*</span></label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input" type="text" id="image_sec_2"
                                        placeholder="{{__('common.browse_image_file')}}" readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg" for="document_file_2"><span
                                                class="ripple rippleEffect browse_file_label"></span>{{__('common.browse')}}</label>
                                        <input name="sec2_image" type="file" class="d-none" id="document_file_2" onchange="getFileName(this.value,'#image_sec_2'),imageChangeWithFile(this,'#AboutUsImgShow_2')">
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <img id="AboutUsImgShow_2" class="aboutUsImg"
                                            src="{{ showImage($aboutus->sec2_image?$aboutus->sec2_image:'backend/img/default.png') }}" alt="">
                        </div>
                    </div>

                </div>
                <div class="col-xl-6">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="">{{__('frontendCms.main_details')}} <span class="text-danger">*</span></label>
                            <textarea name="mainDescription"
                                class="lms_summernote">{{ $aboutus->mainDescription }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('frontendCms.benifit_title')}} <span class="text-danger">*</span></label>
                            <input name="benifitTitle" class="primary_input_field" placeholder="-" type="text"
                                value="{{ old('benifitTitle')? old('benifitTitle'):$aboutus->benifitTitle }}">
                        </div>
                    </div>

                </div>
                <div class="col-xl-6">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="">{{__('frontendCms.benifits_details')}} <span class="text-danger">*</span></label>
                            <textarea name="benifitDescription"
                                class="lms_summernote">{{ $aboutus->benifitDescription }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('frontendCms.selling_title')}} <span class="text-danger">*</span></label>
                            <input name="sellingTitle" class="primary_input_field" placeholder="-" type="text"
                                value="{{ old('sellingTitle')? old('sellingTitle'):$aboutus->sellingTitle }}">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('frontendCms.selling_price')}} <span class="text-danger">*</span></label>
                            <input name="price" class="primary_input_field" placeholder="-" type="text"
                                value="{{ old('price')? old('price'):$aboutus->price }}">
                        </div>
                    </div>

                </div>
                <div class="col-xl-6">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="">{{__('frontendCms.selling_details')}} <span class="text-danger">*</span></label>
                            <textarea name="sellingDescription"
                                class="lms_summernote">{{ $aboutus->sellingDescription }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (permissionCheck('frontendcms.about-us.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent"
                        type="submit"><i class="ti-check"></i>{{__('common.update')}}</button>
                </div>
            </div>
        @endif
    </div>
</form>
