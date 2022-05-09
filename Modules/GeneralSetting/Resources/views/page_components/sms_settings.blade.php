<form class="" action="{{ route('sms_gateway_credentials_update') }}" method="post">
    @csrf
    <div class="main-title mb-20">
        <h3 class="mb-0">{{__('general_settings.sms_settings')}}</h3>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <label class="primary_input_label" for="">{{ __('general_settings.activate_sms_gateway') }}</label>
            <ul id="" class="permission_list sms_list">
                @foreach ($sms_gateways as $key => $smsGateway)
                    <li>
                        <label class="primary_checkbox d-flex mr-12 ">
                            <input class="sms_gateway" data-type="{{$smsGateway->type}}" name="sms_gateway_id" type="radio" id="sms_gateway_id{{ $key }}" value="{{ $smsGateway->id }}" @if ($smsGateway->status != 0) checked @endif>
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ $smsGateway->type }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <label class="primary_input_label" for="">{{ __('general_settings.gateway_settings') }}</label>
            <div id="Twilio_Settings" class="sms_ption" >
                <!-- content  -->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <input type="hidden" name="types[]" value="TWILIO_SID">
                            <label class="primary_input_label" for="">{{ __('general_settings.twilio_account_sid') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="-" type="text" name="TWILIO_SID" value="{{ env('TWILIO_SID') }}">
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <input type="hidden" name="types[]" value="TWILIO_TOKEN">
                            <label class="primary_input_label" for="">{{ __('general_settings.authentication_token') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="-" type="text" name="TWILIO_TOKEN" value="{{ env('TWILIO_TOKEN') }}">
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <input type="hidden" name="types[]" value="VALID_TWILLO_NUMBER">
                            <label class="primary_input_label" for="">{{ __('general_settings.registered_phone_number') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="-" type="text" name="VALID_TWILLO_NUMBER" value="{{ env('VALID_TWILLO_NUMBER') }}">
                        </div>
                    </div>
                </div>
                <div class="submit_btn text-center mb-100 pt_15">
                    <button  name="action" value="twilo" class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
                </div>
                <!-- content  -->
            </div>
            <div id="TexttoLocal_Settings" class="sms_ption" >
                <div class="row">
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <input type="hidden" name="types[]" value="TEXT_TO_LOCAL_API_KEY">
                            <label class="primary_input_label" for="">{{ __('general_settings.api_key') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="-" type="text" name="TEXT_TO_LOCAL_API_KEY" value="{{ env('TEXT_TO_LOCAL_API_KEY') }}">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <input type="hidden" name="types[]" value="TEXT_TO_LOCAL_SENDER">
                            <label class="primary_input_label" for="">{{ __('general_settings.sender_name') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="-" type="text" name="TEXT_TO_LOCAL_SENDER" value="{{ env('TEXT_TO_LOCAL_SENDER') }}">
                        </div>
                    </div>
                </div>
                @if (permissionCheck('sms_gateway_credentials_update'))
                    <div class="submit_btn text-center pt_15">
                        <button  name="action" value="text_local" class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
                    </div>
                @else
                    <div class="col-lg-12 text-center mt-2">
                        <span class="alert alert-warning" role="alert">
                            <strong>You don't have this permission</strong>
                        </span>
                    </div>
                @endif
            </div>
            <div id="other_Settings" class="sms_ption" >
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="url">{{ __('general_settings.url') }} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" placeholder="{{ __('general_settings.url') }}" value="{{smsGatewaySetting()['url']}}" type="text" name="url" id="url">
                            <span class="text-danger">{{$errors->first('url')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="send_to_parameter_name">{{ __('general_settings.send_to_parameter_name') }} </label>
                            <input class="primary_input_field" placeholder="{{ __('general_settings.send_to_parameter_name') }}" value="{{smsGatewaySetting()['send_to_parameter_name']}}" type="text" name="send_to_parameter_name" id="send_to_parameter_name">
                            <span class="text-danger">{{$errors->first('send_to_parameter_name')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="message_parameter_name">{{ __('general_settings.message_parameter_name') }} </label>
                            <input class="primary_input_field" placeholder="{{ __('general_settings.message_parameter_name') }}" value="{{smsGatewaySetting()['message_parameter_name']}}" type="text" name="message_parameter_name" id="message_parameter_name">
                            <span class="text-danger">{{$errors->first('message_parameter_name')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="request_method">{{ __('general_settings.request_method') }} <span class="text-danger">*</span></label>
                            <select class="primary_select mb-15" id="request_method" name="request_method">
                                <option value="">{{__('common.select_one')}}</option>
                                <option {{smsGatewaySetting()['request_method'] == 'GET' ? 'selected' :''}} value="GET">GET</option>
                                <option {{smsGatewaySetting()['request_method'] == 'POST' ? 'selected' :''}} value="POST">POST</option>
                            </select>
                            <span class="text-danger">{{$errors->first('request_method')}}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_1_key">{{ __('general_settings.parameter_1_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_1_key']}}" type="text" name="parameter_1_key" id="parameter_1_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_1_value">{{ __('general_settings.parameter_1_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_1_value']}}" type="text" name="parameter_1_value" id="parameter_1_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_2_key">{{ __('general_settings.parameter_2_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_2_key']}}" type="text" name="parameter_2_key" id="parameter_2_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_2_value">{{ __('general_settings.parameter_2_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_2_value']}}" type="text" name="parameter_2_value" id="parameter_2_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_3_key">{{ __('general_settings.parameter_3_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_3_key']}}" type="text" name="parameter_3_key" id="parameter_3_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_3_value">{{ __('general_settings.parameter_3_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_3_value']}}" type="text" name="parameter_3_value" id="parameter_3_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_4_key">{{ __('general_settings.parameter_4_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_4_key']}}" type="text" name="parameter_4_key" id="parameter_4_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_4_value">{{ __('general_settings.parameter_4_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_4_value']}}" type="text" name="parameter_4_value" id="parameter_4_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_5_key">{{ __('general_settings.parameter_5_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_5_key']}}" type="text" name="parameter_5_key" id="parameter_5_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_5_value">{{ __('general_settings.parameter_5_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_5_value']}}" type="text" name="parameter_5_value" id="parameter_5_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_6_key">{{ __('general_settings.parameter_6_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_6_key']}}" type="text" name="parameter_6_key" id="parameter_6_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_6_value">{{ __('general_settings.parameter_6_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_6_value']}}" type="text" name="parameter_6_value" id="parameter_6_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_7_key">{{ __('general_settings.parameter_7_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_7_key']}}" type="text" name="parameter_7_key" id="parameter_7_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_7_value">{{ __('general_settings.parameter_7_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_7_value']}}" type="text" name="parameter_7_value" id="parameter_7_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_8_key">{{ __('general_settings.parameter_8_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_8_key']}}" type="text" name="parameter_8_key" id="parameter_8_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_8_value">{{ __('general_settings.parameter_8_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_8_value']}}" type="text" name="parameter_8_value" id="parameter_8_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_9_key">{{ __('general_settings.parameter_9_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_9_key']}}" type="text" name="parameter_9_key" id="parameter_9_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_9_value">{{ __('general_settings.parameter_9_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_9_value']}}" type="text" name="parameter_9_value" id="parameter_9_value">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_10_key">{{ __('general_settings.parameter_10_key') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_10_key']}}" type="text" name="parameter_10_key" id="parameter_10_key">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="parameter_10_value">{{ __('general_settings.parameter_10_value') }}</label>
                            <input class="primary_input_field" placeholder="-" value="{{smsGatewaySetting()['parameter_10_value']}}" type="text" name="parameter_10_value" id="parameter_10_value">
                        </div>
                    </div>
                </div>

                @if (permissionCheck('sms_gateway_credentials_update'))
                        <div class="submit_btn text-center pt_15">
                            <button  name="action" value="other" class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
                        </div>
                    @else
                        <div class="col-lg-12 text-center mt-2">
                            <span class="alert alert-warning" role="alert">
                                <strong>You don't have this permission</strong>
                            </span>
                        </div>
                    @endif
                </div>
        </div>
    </div>
</form>
<hr>
<form class="" action="{{ route('sms_send_demo') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.phone_number') }}</label>
                <input class="primary_input_field" placeholder="-" value="{{old('number')}}" type="text" name="number">
                <span class="text-danger">{{$errors->first('number')}}</span>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('general_settings.send_a_test_sms') }}</label>
                <input class="primary_input_field" placeholder="-" value="{{old('message')}}" type="text" name="message">
                <span class="text-danger">{{$errors->first('message')}}</span>
            </div>
        </div>
    </div>
    <div class="submit_btn text-center mb-100 pt_15">
        <button class="primary_btn_2" type="submit">{{ __('general_settings.send_test_sms') }}</button>
    </div>
</form>


