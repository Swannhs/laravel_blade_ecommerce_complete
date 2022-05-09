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
        .term_link_set ,.policy_link_set{
            color: var(--base_color);
        }
    </style>
@endsection
@section('content')
<section class="register_part">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="register_form_iner">
                    <div class="login_logo text-center mb-3">
                        <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                    </div>
                    <h2>{{ __('defaultTheme.welcome') }}! <br>{{ __('defaultTheme.please_create_your_account') }}</h2>
                    <form method="POST" action="{{ route('register') }}" class="register_form" name="register" enctype="multipart/form-data">
                        @csrf

                        @if(!empty($row) && !empty($form_data))
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
                                <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class=" nc_select">
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
                                <textarea class="form-control" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
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
                                        <input type="{{$type}}" accept="image/*" name="{{$row->name}}" id="{{$row->name}}" >
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

@endsection

@push('scripts')

<script>
    (function($){
        "use strict";
        $(document).ready(function(){

            $(document).on('submit', '.register_form', function(event){

                if($("#policyCheck").prop('checked')!=true){
                    event.preventDefault();
                    toastr.error("{{__('common.please_agree_with_our_policy_privacy')}}","{{__('common.error')}}");
                    return false;
                }

            });

        });
    })(jQuery);
</script>
@endpush
