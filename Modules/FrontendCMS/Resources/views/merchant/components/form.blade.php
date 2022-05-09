<form id="formData" action="" method="POST" enctype="multipart/form-data">
    <div class="row">

        <input type="hidden" name="id" id="mainId" value="{{ $content->id }}">
        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                            <input id="mainTitle" name="mainTitle" class="primary_input_field" placeholder="-"
                                type="text" value="{{ old('mainTitle') ? old('mainTile') : $content->mainTitle }}">
                            <span class="text-danger" id="error_mainTitle"></span>
                        </div>

                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="subTitle">{{ __('frontendCms.sub_title') }} <span class="text-danger">*</span></label>
                            <input id="subTitle" name="subTitle" class="primary_input_field" placeholder="-"
                            type="text" value="{{ old('subTitle') ? old('subTile') : $content->subTitle }}">
                            <span class="text-danger" id="error_subTitle"></span>
                        </div>

                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="slug">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                            <input id="mainSlug" name="slug" class="primary_input_field" placeholder="-" type="text"
                                value="{{ old('slug') ? old('slug') : $content->slug }}">
                            <span class="text-danger" id="error_slug"></span>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="pricing">{{ __('frontendCms.pricing_slogan') }} <span class="text-danger">*</span></label>
                            <input id="pricing" name="pricing" class="primary_input_field" placeholder="-" type="text"
                                value="{{ old('pricing') ? old('pricing') : $content->pricing }}">
                            <span class="text-danger" id="error_pricing"></span>
                        </div>

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="">{{ __('frontendCms.main_details') }} <span class="text-danger">*</span></label>
                            <textarea id="Maindescription" name="Maindescription"
                                class="lms_summernote">{{ $content->Maindescription }}</textarea>
                            <span class="text-danger" id="error_mainDescription"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="benifitTitle">{{ __('frontendCms.benifit_title') }} <span class="text-danger">*</span></label>
                            <input id="benifitTitle" name="benifitTitle" class="primary_input_field" placeholder="-"
                                type="text"
                                value="{{ old('benifitTitle') ? old('benifitTile') : $content->benifitTitle }}">
                            <span class="text-danger" id="error_benifitTitle"></span>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <label class="primary_input_label" for="benefit">{{ __('frontendCms.benefit_list') }}</label>

                        <div id="benefit_table">
                            @include('frontendcms::merchant.benefit.list')
                        </div>


                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="">{{ __('frontendCms.benefits_details') }}
                                <span class="text-danger">*</span></label>
                            <textarea id="benifitDescription" name="benifitDescription"
                                class="lms_summernote">{{ $content->benifitDescription }}</textarea>
                            <span class="text-danger" id="error_benifitDescription"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="howitworkTitle">{{ __('frontendCms.how_it_work_title') }} <span class="text-danger">*</span></label>
                            <input id="howitworkTitle" name="howitworkTitle" class="primary_input_field" placeholder="-"
                                type="text"
                                value="{{ old('howitworkTitle') ? old('howitworkTitle') : $content->howitworkTitle }}">
                            <span class="text-danger" id="error_howitworkTitle"></span>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.how_it_work_list') }}</label>

                        <div id="work_table">
                            @include('frontendcms::merchant.working_process.list')
                        </div>


                    </div>

                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="howitworkDescription">{{ __('frontendCms.how_it_work_details') }} <span class="text-danger">*</span></label>
                            <textarea id="howitworkDescription" name="howitworkDescription"
                                class="lms_summernote">{{ $content->howitworkDescription }}</textarea>
                            <span class="text-danger" id="error_howitworkDescription"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.pricing_title') }} <span class="text-danger">*</span></label>
                            <input id="pricingTitle" name="pricingTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('pricingTitle') ? old('pricingTitle') : $content->pricingTitle }}">
                            <span class="text-danger" id="error_pricingTitle"></span>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{ __('frontendCms.subscription_crone_job_url') }}</label>
                            <input id="subscription_crone_job" name="subscription_crone_job" class="primary_input_field" readonly type="text" value="{{ route('subscription_crone_job') }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="pricingDescription">{{ __('frontendCms.pricing_details') }} <span class="text-danger">*</span></label>
                            <textarea id="pricingDescription" name="pricingDescription"
                                class="lms_summernote">{{ $content->pricingDescription }}</textarea>
                            <span class="text-danger" id="error_pricingDescription"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.seller_registration_title_for_first_page') }}<span class="text-danger">*</span></label>
                            <input id="sellerRegistrationTitle" name="sellerRegistrationTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('sellerRegistrationTitle') ? old('sellerRegistrationTitle') : $content->sellerRegistrationTitle }}">
                            <span class="text-danger" id="error_sellerRegistrationTitle"></span>
                        </div>

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="pricingDescription">{{ __('frontendCms.description') }}<span class="text-danger">*</span></label>
                            <textarea id="sellerRegistrationDescription" name="sellerRegistrationDescription"
                                class="lms_summernote">{{ $content->sellerRegistrationDescription }}</textarea>
                                <span class="text-danger" id="error_sellerRegistrationDescription"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-20">
            <div class="row">
                <div class="col-xl-7">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="queryTitle">{{ __('frontendCms.faq_title') }} <span class="text-danger">*</span></label>
                            <input id="faqTitle" name="faqTitle" class="primary_input_field" placeholder="-" type="text"
                                value="{{ $content->faqTitle }}">
                            <span class="text-danger" id="error_faqTitle"></span>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.faq_list') }}</label>


                        <div id="faq_table">
                            @include('frontendcms::merchant.faq.list')
                        </div>

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="queryDescription">{{ __('frontendCms.faq_details') }} <span class="text-danger">*</span></label>
                            <textarea id="faqDescription" name="queryDescription"
                                class="lms_summernote">{{ $content->faqDescription }}</textarea>
                            <span class="text-danger" id="error_queryDescription"></span>
                        </div>

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
                                for="queryTitle">{{ __('frontendCms.query_title') }} <span class="text-danger">*</span></label>
                            <input id="queryTitle" name="queryTitle" class="primary_input_field" placeholder="-"
                                type="text" value="{{ old('queryTitle') ? old('queryTitle') : $content->queryTitle }}">
                            <span class="text-danger" id="error_queryTitle"></span>
                        </div>

                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label"
                                for="queryDescription">{{ __('frontendCms.query_details') }} <span class="text-danger">*</span></label>
                            <textarea id="queryDescription" name="queryDescription"
                                class="lms_summernote">{{ $content->queryDescription }}</textarea>
                            <span class="text-danger" id="error_queryDescription"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if (permissionCheck('frontendcms.merchant-content.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="Update"><i
                            class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
