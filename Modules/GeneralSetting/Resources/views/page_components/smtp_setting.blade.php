<div class="white_box_30px">
    <!-- SMTP form  -->
    <div class="main-title mb-25">
        <h3 class="mb-0">{{ __('general_settings.email_settings') }}</h3>
    </div>

    <form action="{{ route('smtp_gateway_credentials_update') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('Active Gateway') }} <span class="text-danger">*</span></label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="mail_gateway" id="status_active" value="smtp" @if(app('general_setting')->mail_protocol == 'smtp') checked @endif class="active mail_gateway"
                                    type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('general_settings.smtp') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                <input name="mail_gateway" value="sendmail" id="status_inactive" @if(app('general_setting')->mail_protocol == 'sendmail') checked @endif class="de_active mail_gateway" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('general_settings.php_mail') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
{{--            <div class="col-xl-12">--}}
{{--                <div class="primary_input">--}}
{{--                    <input type="hidden" name="types[]" value="MAIL_MAILER">--}}
{{--                    <label class="primary_input_label" for="">{{ __('general_settings.email_protocol') }}</label>--}}
{{--                    <select class="primary_select mb-25 smtp_form" name="mail_protocol" id="mail_mailer">--}}
{{--                        <option value="smtp" @if (app('general_setting')->mail_protocol == "smtp") selected @endif>{{ __('general_settings.smtp') }}--}}
{{--                        </option>--}}
{{--                        <option value="sendmail" @if (app('general_setting')->mail_protocol == "sendmail") selected--}}
{{--                            @endif>{{ __('general_settings.php_mail') }}</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row" id="smtp">
            <div class="col-xl-6">
                <div class="primary_input">
                    <input type="hidden" name="types[]" value="MAIL_ENGINE">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_engine') }}</label>
                    <select name="MAIL_ENGINE" class="primary_select mb-25">
                        <option value="mail_engine">{{ __('general_settings.php_mailer') }}</option>
                        <option value="mail_engine2">{{ __('general_settings.php_mailer2') }}</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                    <label class="primary_input_label" for="">{{ __('general_settings.from_name') }}*</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="MAIL_FROM_NAME"
                        value="{{ env('MAIL_FROM_NAME') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                    <label class="primary_input_label" for="">{{ __('general_settings.from_mail') }}*</label>
                    <input class="primary_input_field" placeholder="-" type="email" name="MAIL_FROM_ADDRESS"
                        value="{{ env('MAIL_FROM_ADDRESS') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_HOST">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_host') }}</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="MAIL_HOST"
                        value="{{ env('MAIL_HOST') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_PORT">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_port') }}</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="MAIL_PORT"
                        value="{{ env('MAIL_PORT') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_USERNAME">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_username') }}</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="MAIL_USERNAME"
                        value="{{ env('MAIL_USERNAME') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_password') }}</label>
                    <input class="primary_input_field" placeholder="-" type="password" name="MAIL_PASSWORD"
                        value="{{ env('MAIL_PASSWORD') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input">
                    <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_encryption') }}</label>
                    <select name="MAIL_ENCRYPTION" class="primary_select mb-25">
                        <option value="ssl" @if (env('MAIL_ENCRYPTION')=="ssl" ) selected @endif>SSL</option>
                        <option value="tls" @if (env('MAIL_ENCRYPTION')=="tls" ) selected @endif>TLS</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="MAIL_CHARSET">
                    <label class="primary_input_label" for="">{{ __('general_settings.email_charset') }}</label>
                    <input class="primary_input_field" placeholder="Utf-8" type="text" name="MAIL_CHARSET"
                        value="{{ env('MAIL_CHARSET') }}">
                </div>
            </div>
        </div>
        <div class="row" id="sendmail">

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="SENDER_NAME">
                    <label class="primary_input_label" for="">{{ __('general_settings.sender_name') }}</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="SENDER_NAME"
                        value="{{ env('SENDER_NAME') }}">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <input type="hidden" name="types[]" value="SENDER_MAIL">
                    <label class="primary_input_label" for="">{{ __('general_settings.sender_email') }}</label>
                    <input class="primary_input_field" placeholder="-" type="text" name="SENDER_MAIL"
                        value="{{ env('SENDER_MAIL') }}">
                </div>
            </div>
        </div>
        <div class="row">


            @if (permissionCheck('smtp_gateway_credentials_update'))
            <div class="col-12 mb-45 pt_15">
                <div class="submit_btn text-center">
                    <button class="primary_btn_large" type="submit"> <i class="ti-check"></i>
                        {{ __('common.save') }}</button>
                </div>
            </div>
            @else
            <div class="col-lg-12 text-center mt-2">
                <span class="alert alert-warning" role="alert">
                    <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
                </span>
            </div>
            @endif
        </div>
    </form>
    <hr>
    <form class="" action="{{ route('test_mail.send') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('general_settings.send_a_test_email_to') }} <span
                            class="text-danger">*</span></label>
                    <input class="primary_input_field" type="email" name="email" value="{{old('email')}}"
                        placeholder="">
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('general_settings.mail_text') }} <span
                            class="text-danger">*</span></label>
                    <input class="primary_input_field" placeholder="-" type="text" value="{{old('content')}}"
                        name="content">
                    <span class="text-danger">{{$errors->first('content')}}</span>
                </div>
            </div>
        </div>
        <div class="submit_btn text-center mb-100 pt_15">
            <button class="primary_btn_2" type="submit">{{ __('general_settings.send_test_mail') }}</button>
        </div>
    </form>

    <!--/ SMTP_form  -->
</div>
