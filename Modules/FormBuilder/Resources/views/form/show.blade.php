@extends('frontend.default.auth.layouts.app')
@section('styles')
    <style>
        .login_logo img {
            max-width: 140px;
            margin: 0 auto;
        }
        .register_part {
            background: var(--background_color) !important;
            min-height: 100vh !important;
            height: auto !important;
        }
        .mr-10{
            margin-right: 10px!important;
        }
        .register_form .form-group input {
            padding: 24px 20px!important;
            border: 1px solid var(--border_color);
            border-radius: 0;
            font-size: 13px;
            color: #8f8f8f;
            text-transform: capitalize;
        }
        .register_form .form-group textarea {
            height: 160px;
            width: 100%;
            padding: 20px;
            font-size: 13px;
            border: 1px solid var(--border_color);
        }
        .mb-15{
            margin-bottom: 15px!important;
        }
        .nc_select {
            border-radius: 0;
            font-size: 13px;
            color: #8f8f8f;
            display: block;
            width: 100%;
            text-transform: capitalize;
            padding: 0 20px;
            margin-bottom: 15px;
        }
        .customer_img input{
            width: 100%;
            background: #fff;
        }
        .term_link_set ,.policy_link_set{
            color: var(--base_color);
        }
    </style>
@endsection
@section('content')

    @if($item->id == 1)
        <section class="register_part">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="register_form_iner">
                            <div class="login_logo text-center mb-3">
                                <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                            </div>
                            <h2>{{ __('affiliate.Welcome') }}! <br>{{ __('affiliate.Join Our Affiliate Program') }}</h2>
                            <form  class="register_form" name="register" enctype="multipart/form-data">
                                @csrf
                            @if(!empty($item) && !empty($form_data))
                                    @php
                                        $default_field = [];
                                        $custom_field = [];
                                    @endphp
                                <div class="form-row">
                                    @foreach($form_data as $row)
                                        @php
                                            if($row->type != 'header' && $row->type !='paragraph'){
                                                if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                                    $default_field[] = $row->name;
                                                }else{
                                                    $custom_field[] = $row->name;
                                                }
                                                $required = property_exists($row,'required');
                                                $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                                $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                            }
                                        @endphp

                                        @if($row->type =='header' || $row->type =='paragraph')
                                            <div class="col-lg-12">
                                                    <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                                            </div>
                                        @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                            <div class="col-md-6">
                                                <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                                <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                                @error($row->name)
                                                <span class="text-danger" >{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @elseif($row->type=='select')
                                            <div class="col-md-6">
                                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="nc_select">
                                                    @foreach($row->values as $value)
                                                        <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first($row->name)}}</span>
                                            </div>

                                        @elseif($row->type == 'date')
                                            <div class="col-md-6">
                                                <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                                <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                                @error($row->name)
                                                <span class="text-danger" >{{ $message }}</span>
                                                @enderror
                                            </div>

                                        @elseif($row->type=='textarea')
                                            <div class="col-md-12">
                                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                <textarea class="" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                                <span class="text-danger">{{$errors->first($row->name)}}</span>
                                            </div>

                                        @elseif($row->type=="radio-group")
                                            <div class="col-lg-12   mt-10 mb-10">
                                                <label for="">{{ $row->label }}</label>
                                                <div class="d-flex radio-btn-flex">
                                                    @foreach($row->values as $value)
                                                        <label class="primary_bulet_checkbox mr-10">
                                                            <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <span class="mr-10">{{ $value->label }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($row->type=="checkbox-group")
                                            <div class="col-lg-12 mt-10 mb-10">
                                                <label>{{@$row->label}}</label>
                                                <div class="checkbox">
                                                    @foreach($row->values as $value)
                                                        <label class="cs_checkbox mr-10">
                                                            <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p class="mr-10">{{$value->label}}</p>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @elseif($row->type =='file')

                                            <div class="col-lg-12">
                                                <div class="customer_img">
                                                    <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                    <div class="form-group">
                                                        <input type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($row->type =='checkbox')
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label class="cs_checkbox">
                                                        <input id="policyCheck" type="checkbox" checked>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p>{!! $row->label !!}</p>
                                                </div>
                                            </div>
                                        @endif

                                    @endforeach
                                    <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">
                                    <div class="col-md-12 text-center">
                                        <div class="register_area">
                                            <button type="submit" id="submitBtn" class="btn_1 cs-pointer">{{ __('defaultTheme.register') }}</button>
                                            <p>
                                                {{ __('defaultTheme.already_a_member_yet') }}
                                                <a href="{{url('/login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="name">{{__('common.first_name')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="first_name" class="@error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="{{__('common.first_name')}}" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = '{{__('common.first_name')}}'">
                                        @error('first_name')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">{{__('common.last_name')}}</label>
                                        <input type="text" id="last_name" class="@error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="{{__('common.last_name')}}" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = '{{__('common.last_name')}}'">
                                        @error('last_name')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        @if(isModuleActive('Otp') && otp_configuration('otp_activation_for_customer') || app('business_settings')->where('type', 'email_verification')->first()->status == 0)
                                            <label for="email">{{__('common.email_or_phone')}} <span class="text-danger">*</span></label>
                                            <input type="text" id="email" name="email" value="{{old('email')}}" placeholder="{{__('common.email_or_phone')}}" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = '{{__('common.email_or_phone')}}'">
                                            @error('email')
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        @else
                                            <label for="email">{{__('common.email')}} <span class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="{{__('common.email')}}" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = '{{__('common.email')}}'">
                                            @error('email')
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password">{{__('common.password')}}({{ __('defaultTheme.minimum_8') }})<span class="text-danger">*</span></label>
                                        <input type="password" id="password" class="@error('password') is-invalid @enderror" name="password" placeholder="{{__('common.password')}}" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = '{{__('common.password')}}'" autocomplete="new-password">
                                        @error('password')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm">{{__('common.confirm_password')}} <span class="text-danger">*</span></label>
                                        <input type="password" id="password-confirm" name="password_confirmation" placeholder="{{__('common.confirm_password')}}" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = '{{__('common.confirm_password')}}'" autocomplete="new-password">

                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label class="cs_checkbox">
                                                <input id="policyCheck" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('defaultTheme.by_signing_up_you_agree_to_terms_of_service_and_privacy_policy') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div class="register_area">
                                            <button type="submit" id="submitBtn" class="btn_1 cs-pointer">{{ __('defaultTheme.register') }}</button>
                                            <p>
                                                {{ __('defaultTheme.already_a_member_yet') }}
                                                <a href="{{url('/login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @elseif($item->id == 2)
        <section class="register_part">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="register_form_iner">
                            <div class="login_logo text-center mb-3">
                                <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                            </div>
                            <h2>{{ __('defaultTheme.welcome') }}! <br>{{ __('defaultTheme.please_create_your_account') }}</h2>
                            <form class="register_form" name="register" enctype="multipart/form-data">
                                @csrf

                                @if(!empty($item) && !empty($form_data))
                                    <div class="form-row">

                                        @php
                                            $default_field = [];
                                            $custom_field = [];
                                        @endphp
                                        @foreach($form_data as $row)
                                            @php
                                                if($row->type != 'header' && $row->type !='paragraph'){
                                                    if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                                        $default_field[] = $row->name;
                                                    }else{
                                                        $custom_field[] = $row->name;
                                                    }
                                                    $required = property_exists($row,'required');
                                                    $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                                    $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                                }
                                            @endphp

                                            @if($row->type =='header' || $row->type =='paragraph')
                                                <div class="col-lg-12">
                                                    <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                                    </div>
                                @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                    <div class=" col-md-6">
                                        <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror " name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                @elseif($row->type=='select')
                                    <div class="col-md-6">
                                        <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                        <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="nc_select">
                                            @foreach($row->values as $value)
                                                <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first($row->name)}}</span>
                                    </div>

                                @elseif($row->type == 'date')
                                    <div class="col-md-6">
                                        <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>

                                @elseif($row->type=='textarea')
                                    <div class="col-md-12">
                                        <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                        <textarea class="" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                        <span class="text-danger">{{$errors->first($row->name)}}</span>
                                    </div>

                                @elseif($row->type=="radio-group")
                                    <div class="col-lg-12  mt-10 mb-10">
                                        <label for="">{{ $row->label }}</label>
                                        <div class="d-flex radio-btn-flex">
                                            @foreach($row->values as $value)
                                                <label class="primary_bulet_checkbox mr-10">
                                                    <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="mr-10">{{ $value->label }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($row->type=="checkbox-group")
                                    <div class="col-lg-12 mt-10 mb-10">
                                        <label>{{@$row->label}}</label>
                                        <div class="checkbox">
                                            @foreach($row->values as $value)
                                                <label class="cs_checkbox mr-10">
                                                    <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p class="mr-10">{{$value->label}}</p>
                                            @endforeach
                                        </div>
                                    </div>

                                @elseif($row->type =='file')

                                    <div class="col-lg-12">
                                        <div class="customer_img">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <div class="form-group">
                                                <input type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                            </div>
                                        </div>
                                    </div>
                                @elseif($row->type =='checkbox')
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label class="cs_checkbox">
                                                <input id="policyCheck" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{!! $row->label !!}</p>
                                        </div>
                                    </div>
                                @endif

                                @endforeach
                                <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">
                                <div class="col-md-12 text-center">
                                    <div class="register_area">
                                        <button type="submit" id="submitBtn" class="btn_1 cs-pointer">{{ __('defaultTheme.register') }}</button>
                                        <p>
                                            {{ __('defaultTheme.already_a_member_yet') }}
                                            <a href="{{url('/login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                    </div>
                                </div>
                        </div>
                        @else
                            <div class="form-row">

                                <div class="col-md-6">
                                    <label for="name">{{__('common.first_name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="first_name" class="@error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="{{__('common.first_name')}}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{__('common.first_name')}}'">
                                    @error('first_name')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{__('common.last_name')}}</label>
                                    <input type="text" id="last_name" class="@error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="{{__('common.last_name')}}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{__('common.last_name')}}'">
                                    @error('last_name')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    @if(isModuleActive('Otp') && otp_configuration('otp_activation_for_customer') || app('business_settings')->where('type', 'email_verification')->first()->status == 0)
                                        <label for="email">{{__('common.email_or_phone')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" value="{{old('email')}}" placeholder="{{__('common.email_or_phone')}}" onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('common.email_or_phone')}}'">
                                        @error('email')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    @else
                                        <label for="email">{{__('common.email')}} <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="{{__('common.email')}}" onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('common.email')}}'">
                                        @error('email')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="referral_code">{{__('common.referral_code_(optional)')}}</label>
                                    <input type="text" id="referral_code" name="referral_code" value="{{old('referral_code')}}" placeholder="{{__('common.referral_code')}}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{__('common.referral_code')}}'">
                                    @error('referral_code')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password">{{__('common.password')}}({{ __('defaultTheme.minimum_8') }})<span class="text-danger">*</span></label>
                                    <input type="password" id="password" class="@error('password') is-invalid @enderror" name="password" placeholder="{{__('common.password')}}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{__('common.password')}}'" autocomplete="new-password">
                                    @error('password')
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password-confirm">{{__('common.confirm_password')}} <span class="text-danger">*</span></label>
                                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="{{__('common.confirm_password')}}" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{__('common.confirm_password')}}'" autocomplete="new-password">

                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label class="cs_checkbox">
                                            <input id="policyCheck" type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('defaultTheme.by_signing_up_you_agree_to_terms_of_service_and_privacy_policy') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="register_area">
                                        <button type="submit" id="submitBtn" class="btn_1 cs-pointer">{{ __('defaultTheme.register') }}</button>
                                        <p>
                                            {{ __('defaultTheme.already_a_member_yet') }}
                                            <a href="{{url('/login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            </form>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @elseif($item->id == 3)
        <section class="register_part">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="register_form_iner">
                            <h2>{{ __('common.welcome') }}! {{ __('common.please') }} <br>{{ __('defaultTheme.create_your_merchant_account') }}</h2>
                            <form id="registerForm"   class="register_form">
                                <div class="form-row">

                                    
                                    @if(!empty($item) && !empty($form_data))

                                        @foreach($form_data as $row)

                                            @php
                                                if($row->type != 'header' && $row->type !='paragraph'){
                                                     if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                                        $default_field[] = $row->name;
                                                    }else{
                                                        $custom_field[] = $row->name;
                                                    }
                                                    $required = property_exists($row,'required');
                                                    $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                                    $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                                }
                                            @endphp


                                            @if($row->type =='header' || $row->type =='paragraph')

                                                <div class="col-lg-12">
                                                    <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>

                                </div>


                                @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                    <div class="col-md-6">
                                        <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                @elseif($row->type=='select')
                                    @if($row->name == 'subscription_type')
                                        @if (session()->has('pricing_id'))
                                            <div class=" col-md-6">
                                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                                <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class=" nc_select">
                                                    @foreach($row->values as $value)
                                                        <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first($row->name)}}</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class=" col-md-6">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class=" nc_select">
                                                @foreach($row->values as $value)
                                                    <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first($row->name)}}</span>
                                        </div>
                                    @endif


                                @elseif($row->type == 'date')
                                    <div class="col-md-6 ">
                                        <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name)  is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>

                                @elseif($row->type=='textarea')
                                    <div class="col-md-12 ">
                                        <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                        <textarea class="" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                        <span class="text-danger">{{$errors->first($row->name)}}</span>
                                    </div>

                                @elseif($row->type=="radio-group")
                                    <div class="col-lg-12  mt-10 mb-10">
                                        <label for="">{{ $row->label }}</label>
                                        <div class="d-flex radio-btn-flex">
                                            @foreach($row->values as $value)
                                                <label class="primary_bulet_checkbox mr-10">
                                                    <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="mr-10">{{ $value->label }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($row->type=="checkbox-group")
                                    <div class="col-lg-12 mt-10 mb-10">
                                        <label>{{@$row->label}}</label>
                                        <div class="checkbox">
                                            @foreach($row->values as $value)
                                                <label class="cs_checkbox mr-10">
                                                    <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p class="mr-10">{{$value->label}}</p>
                                            @endforeach
                                        </div>
                                    </div>

                                @elseif($row->type =='file')

                                    <div class="col-lg-6">
                                        <div class="customer_img">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <div class="form-group">
                                                <input type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                            </div>
                                        </div>
                                    </div>
                                @elseif($row->type =='checkbox')
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label class="cs_checkbox">
                                                <input id="policyCheck" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{!! $row->label !!}</p>
                                        </div>
                                    </div>
                                @endif

                                @endforeach
                                <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">

                                @else
                                    @if (session()->has('pricing_id'))
                                        <div class="form-group col-md-6">
                                            <label for="Shop">{{ __('defaultTheme.subscription_type') }} <span class="text-danger">*</span></label>
                                            <select name="subscription_type" class="nc_select" disabled>
                                                @foreach ($pricing_plans as $pricing_plan)
                                                    <option value="{{ $pricing_plan->id }}" @if (session()->get('pricing_id') == $pricing_plan->id) selected @endif>{{ $pricing_plan->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label for="Shop">{{ __('common.shop_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="Shop" value="{{old('name')}}" placeholder="{{ __('common.shop_name') }}" onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = ''">
                                        @error('name')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">{{ __('common.email_address') }} <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="{{ __('common.email_address') }} " onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = 'Enter email address'">
                                        @error('email')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">{{ __('common.phone_number') }} <span class="text-danger">*</span></label>
                                        <input type="text" id="phone" name="phone" value="{{old('phone')}}" placeholder="{{ __('common.phone_number') }} " onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = ''">
                                        @error('phone')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password">{{ __('common.password') }} <span class="text-danger">*</span></label>
                                        <input type="password" id="password" name="password" value="{{old('password')}}" placeholder="{{ __('common.password') }} " onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = ''">
                                        @error('password')
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="re_password">{{ __('common.confirm_password') }}<span class="text-danger">*</span></label>
                                        <input type="password" id="re_password" name="password_confirmation" placeholder="{{ __('common.confirm_password') }}" onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = ''">

                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label class="cs_checkbox">
                                                <input type="checkbox" id="termCheck" checked value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('defaultTheme.by_signing_up_you_agree_to_terms_of_service_and_privacy_policy') }}</p>
                                        </div>
                                    </div>

                                @endif
                                <div class="col-md-12 text-center">
                                    <div class="register_area">
                                        <button type="submit" id="submitBtn" class="btn_1">{{ __('defaultTheme.register') }}</button>
                                        <p>{{ __('defaultTheme.already_a_merchant') }}<a href="{{route('login')}}">{{ __('defaultTheme.login_account') }}</a> {{ __('common.here') }}.</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif($item->id == 4)
        <!-- send query part here -->
        <section class="send_query padding_top bg-white contact_form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">

                    <form  action="#" name="#" class="send_query_form" enctype="multipart/form-data">

                    @if(!empty($item) && !empty($form_data))
                        @php
                            $default_field = [];
                            $custom_field = [];
                            $custom_file = false;
                        @endphp
                        @foreach($form_data as $row)
                            @php
                                if($row->type != 'header' && $row->type !='paragraph'){
                                    if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                        $default_field[] = $row->name;
                                    }else{
                                        $custom_field[] = $row->name;
                                        $custom_file  = true;
                                    }
                                    $required = property_exists($row,'required');
                                    $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                    $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                }
                            @endphp

                            @if($row->type =='header' || $row->type =='paragraph')
                            <div class="form-group">
                                <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                            </div>
                            @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                <div class="form-group">
                                    <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                    <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror form-control" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                    @error($row->name)
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif($row->type=='select')
                                <div class="form-group">
                                    <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                    <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="form-control nc_select">
                                        @foreach($row->values as $value)
                                            <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first($row->name)}}</span>
                                </div>

                            @elseif($row->type == 'date')
                                <div class="form-group">
                                    <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                    <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) form-control is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                    @error($row->name)
                                    <span class="text-danger" >{{ $message }}</span>
                                    @enderror
                                </div>

                            @elseif($row->type=='textarea')
                                <div class="form-group">
                                    <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                    <textarea class="form-control" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                    <span class="text-danger">{{$errors->first($row->name)}}</span>
                                </div>

                            @elseif($row->type=="radio-group")
                                <div class="form-group">
                                    <label for="">{{ $row->label }}</label>
                                    <div class="d-flex radio-btn-flex">
                                        @foreach($row->values as $value)
                                            <label class="primary_bulet_checkbox mr-10">
                                                <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="mr-10">{{ $value->label }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($row->type=="checkbox-group")
                                <div class="form-group">
                                    <label>{{@$row->label}}</label>
                                    <div class="checkbox">
                                        @foreach($row->values as $value)
                                            <label class="cs_checkbox mr-10">
                                                <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p class="mr-10">{{$value->label}}</p>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif($row->type =='file')

                                
                                <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                <div class="form-group customer_img">
                                    <input class="{{$custom_file ? 'custom_file' :''}}" type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                </div>
                                
                            @elseif($row->type =='checkbox')
                                <div class="col-md-12 mb-15">
                                    <div class="checkbox">
                                        <label class="cs_checkbox">
                                            <input id="policyCheck" type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{$row->label}}</p>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                        <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">

                    @else
                        <div class="form-group">
                            <label for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" placeholder="{{__('defaultTheme.enter_name')}}" class="form-control">
                            <span class="text-danger"  id="error_name"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">{{__('defaultTheme.email_address')}} <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" placeholder="{{__('defaultTheme.enter_email_address')}}" class="form-control">
                            <span class="text-danger"  id="error_email"></span>
                        </div>
                        <div class="form-group">
                            <label for="query_type">{{__('defaultTheme.inquery_type')}} <span class="text-danger">*</span></label>
                            <select name="query_type" id="query_type" class="form-control nc_select">
                                @foreach($QueryList as $key => $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <span class="text-danger"  id="error_query_type"></span>
                        <div class="form-group">
                            <label for="textarea">{{__('defaultTheme.message')}} <span class="text-danger">*</span></label>
                            <textarea name="message" id="message" placeholder="{{__('defaultTheme.write_messages')}}"></textarea>
                            <span class="text-danger"  id="error_message"></span>
                        </div>
                    @endif
                    <div class="send_query_btn">
                        <button id="contactBtn" type="submit" class="btn_1">{{__('defaultTheme.send_message')}}</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </section>
        <!-- send query part end -->
    @elseif($item->id == 5)
        <section class="register_part">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="register_form_iner">
                            <div class="login_logo text-center mb-3">
                                <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                            </div>
                            <form  class="register_form" name="register" enctype="multipart/form-data">
                                @csrf
                                @if(!empty($item) && !empty($form_data))
                                    @php
                                        $default_field = [];
                                        $custom_field = [];
                                    @endphp
                                    <div class="form-row">
                                        @foreach($form_data as $row)
                                            @php
                                                if($row->type != 'header' && $row->type !='paragraph'){
                                                    if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                                        $default_field[] = $row->name;
                                                    }else{
                                                        $custom_field[] = $row->name;
                                                    }
                                                    $required = property_exists($row,'required');
                                                    $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                                    $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                                }
                                            @endphp

                                            @if($row->type =='header' || $row->type =='paragraph')
                                                <div class="col-lg-12 form-group">
                                                    <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                                    </div>
                                @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                    <div class="col-md-6">
                                        <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror form-control" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                @elseif($row->type=='select')
                                    <div class="form-group col-md-6">
                                        <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                        <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="form-control nc_select">
                                            @foreach($row->values as $value)
                                                <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first($row->name)}}</span>
                                    </div>

                                @elseif($row->type == 'date')
                                    <div class="col-md-6 form-group">
                                        <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                        <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) form-control is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                        @error($row->name)
                                        <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>

                                @elseif($row->type=='textarea')
                                    <div class="col-md-12 form-group">
                                        <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                        <textarea class="form-control" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                        <span class="text-danger">{{$errors->first($row->name)}}</span>
                                    </div>

                                @elseif($row->type=="radio-group")
                                    <div class="col-lg-12 form-group  mt-10 mb-10">
                                        <label for="">{{ $row->label }}</label>
                                        <div class="d-flex radio-btn-flex">
                                            @foreach($row->values as $value)
                                                <label class="primary_bulet_checkbox mr-10">
                                                    <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="mr-10">{{ $value->label }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($row->type=="checkbox-group")
                                    <div class="col-lg-12 form-group mt-10 mb-10">
                                        <label>{{@$row->label}}</label>
                                        <div class="checkbox">
                                            @foreach($row->values as $value)
                                                <label class="cs_checkbox mr-10">
                                                    <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p class="mr-10">{{$value->label}}</p>
                                            @endforeach
                                        </div>
                                    </div>

                                @elseif($row->type =='file')

                                    <div class="col-lg-6">
                                        <div class="customer_img">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <div class="form-group">
                                                <input type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                            </div>
                                        </div>
                                    </div>
                                @elseif($row->type =='checkbox')
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label class="cs_checkbox">
                                                <input id="policyCheck" type="checkbox" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{!! $row->label !!}</p>
                                        </div>
                                    </div>
                                @endif

                                @endforeach
                                <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">
                                <div class="col-md-12 text-center">
                                    <div class="register_area">
                                        <button type="button" id="submitBtn" class="btn_1 cs-pointer">{{ __('common.submit') }}</button>
                                    </div>
                                </div>
                        </div>
                        @else
                            <div class="alert alert-info text-info">
                                <strong>Info!</strong> Design Lead Form.
                            </div>
                            @endif

                            </form>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')

@endpush
