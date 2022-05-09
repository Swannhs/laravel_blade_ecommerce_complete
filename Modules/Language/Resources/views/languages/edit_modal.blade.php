<div class="modal fade admin-query" id="Item_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('language.edit_language_info') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('languages.update', $language->id) }}" method="POST" id="languageEditForm">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                <input name="name" id="edit_name" class="primary_input_field name" value="{{ $language->name }}" placeholder="{{ __('common.name') }}" type="text">
                                <span class="text-danger" id="error_edit_name">{{$errors->first("name")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('language.code') }} <span class="text-danger">*</span></label>
                                <input name="code" id="edit_code" class="primary_input_field name" value="{{ $language->code }}" placeholder="{{ __('language.code') }}" type="text">
                                <span class="text-danger" id="error_edit_code">{{$errors->first("code")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('language.native_name') }} <span class="text-danger">*</span></label>
                                <input name="native" id="edit_native" class="primary_input_field name" value="{{ $language->native }}" placeholder="{{ __('language.native_name') }}" type="text">
                                <span class="text-danger" id="error_edit_native">{{$errors->first("native")}}</span>
                            </div>
                        </div>
                        @if($language->id > 114)
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('language.RTL') }}/{{__('language.LTL')}}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="rtl_ltl" value="0" {{$language->rtl == 0?'checked':''}} class="active"
                                                type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{__('language.LTL')}}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="rtl_ltl" value="1" {{$language->rtl == 1?'checked':''}} class="de_active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('language.RTL') }}</p>
                                    </li>
                                </ul>
                                <span class="text-danger" id="status_error"></span>
                            </div>
                        </div>
                        @endif

                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="status" value="1" {{$language->status == 1?'checked':''}} class="active"
                                                type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.active') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="status" value="0" {{$language->status == 0?'checked':''}} class="de_active" type="radio">
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
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
