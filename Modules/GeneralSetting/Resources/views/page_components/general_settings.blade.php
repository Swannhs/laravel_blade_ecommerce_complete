
<form action="{{ route('company_information_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="General_system_wrap_area">
        <div class="single_system_wrap">
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.system_logo') }}</span>
                </div>
                <div class="logo_img_div">
                    <img src="{{showImage(app('general_setting')->logo?app('general_setting')->logo:'backend/img/default.png') }}" alt="" id="generalSettingLogo">
                </div>
                <div class="update_logo_btn">
                    <button class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" name="site_logo" id="site_logo">
                        {{ __('general_settings.upload_logo') }}
                    </button>
                </div>

            </div>
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.fav_icon') }}</span>
                </div>

                <div class="logo_img_div" >
                    <img src="{{showImage(app('general_setting')->favicon?app('general_setting')->favicon:'backend/img/default.png') }}" alt="" id="generalSettingFavicon">
                </div>

                <div class="update_logo_btn">
                    <button class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" name="favicon_logo" id="favicon_logo">
                        {{ __('general_settings.upload_fav_icon') }}
                    </button>
                </div>

            </div>
            @if(isModuleActive('MultiVendor'))
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.shop_link_banner') }}<small>(1920px X 350px)</small></span>
                </div>

                <div class="logo_img_div" >
                    <img height="100px" width="200px" src="{{showImage(app('general_setting')->shop_link_banner?app('general_setting')->shop_link_banner:'backend/img/default.png') }}" alt="" id="shopLinkBanner">
                </div>

                <div class="update_logo_btn">
                    <button class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" name="shop_link_banner" id="shop_link_banner">
                        {{ __('general_settings.upload_shop_link_banner') }}
                    </button>
                </div>

            </div>
            @endif
        </div>

        <div class="single_system_wrap">
            <div class="row">
                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_title') }}</label>
                        <input class="primary_input_field" placeholder="{{ __('general_settings.system_title') }}" type="text" id="site_title" name="site_title" value="{{ $setting->site_title }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.file_supported') }} ({{__('general_settings.include_comma_with_each_word')}})</label>
                        <div class="tagInput_field">
                            <input class="sr-only"  type="text" id="file_supported" name="file_supported" value="{{ $setting->file_supported }}" data-role="tagsinput" class="sr-only">
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_default_language') }}</label>
                        <select class="primary_select mb-25" name="language_code" id="language_code">
                            @foreach (\Modules\Language\Entities\Language::where('status', 1)->get() as $key => $language)
                                <option value="{{ $language->code }}" @if (app('general_setting')->language_code == $language->code) selected @endif>{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.date_format') }}</label>
                        <select class="primary_select mb-25" name="date_format_id" id="date_format_id">
                            @foreach ($dateformats as $key => $dateFormat)
                                <option value="{{ $dateFormat->id }}" @if (app('general_setting')->date_format_id == $dateFormat->id) selected @endif> ({{ $dateFormat->normal_view }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_default_currency') }}</label>
                        <select class="primary_select mb-25" name="currency_id" id="currency">
                            @foreach (\Modules\GeneralSetting\Entities\Currency::where('status',1)->get() as $key => $currency)
                                <option value="{{ $currency->id }}" @if ($setting->currency_code == $currency->code) selected @endif>{{ $currency->name }} ({{$currency->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.time_zone') }}</label>
                        <select class="primary_select mb-25" name="time_zone" id="time_zone_id">
                            @foreach ($timezones as $key => $timeZone)
                                <option value="{{ $timeZone->code }}" @if ($setting->time_zone == $timeZone->code) selected @endif>{{ $timeZone->time_zone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_inpu mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_symbol') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_symbol" name="currency_symbol" value="{{ $setting->currency_symbol }}" readonly>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_code') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_code" name="currency_code" value="{{ $setting->currency_code }}" readonly>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_symbol_position') }}</label>
                        <select class="primary_select mb-25" name="currency_symbol_position" id="currency_symbol_position_id">
                            <option value="left" {{(app('general_setting')->currency_symbol_position == 'left')?'selected':''}}>{{__('menu.left')}} -> [ {{app('general_setting')->currency_symbol}}20.20 ]</option>
                            <option value="left_with_space" {{(app('general_setting')->currency_symbol_position == 'left_with_space')?'selected':''}}>{{__('general_settings.left_with_space')}} -> [ {{app('general_setting')->currency_symbol}} 20.20 ]</option>
                            <option value="right" {{(app('general_setting')->currency_symbol_position == 'right')?'selected':''}}>{{__('menu.right')}} -> [ 20.20{{app('general_setting')->currency_symbol}} ]</option>
                            <option value="right_with_space" {{(app('general_setting')->currency_symbol_position == 'right_with_space')?'selected':''}}>{{__('general_settings.right_with_space')}} -> [ 20.20 {{app('general_setting')->currency_symbol}} ]</option>
                        </select>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="decimal_limit_id">{{ __('general_settings.decimal_number_limit') }}</label>
                        <input class="primary_input_field" placeholder="0" type="number" id="decimal_limit_id" name="decimal_limit" step="0" min="0" value="{{app('general_setting')->decimal_limit}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('Default Country') }}</label>
                        <select class="primary_select mb-25" name="default_country" id="default_country_id">
                            <option value="">{{__('common.select_one')}}</option>
                            @foreach($countries as $country)
                                <option {{$setting->default_country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('Default State') }}</label>
                        <select class="primary_select mb-25" name="default_state" id="default_state_id">
                            <option value="">{{__('common.select_one')}}</option>
                            @if($setting->country_id)
                                @foreach($states as $key => $state)
                                <option {{$setting->default_state == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('Guest Checkout') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="guest_checkout" id="guestcheckout_active" value="1" class="active" type="radio" {{(app('general_setting')->guest_checkout == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="guest_checkout" id="guestcheckout_inactive" value="0" class="de_active" type="radio" {{(app('general_setting')->guest_checkout == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
    @if (permissionCheck('company_information_update'))
        <div class="submit_btn text-center mt-4">
            <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
        </div>
    @endif
</form>
