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
        }
    </style>
@endsection
@section('content')
<section class="login_area register_part">
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <div class="col-lg-6 col-xl-4">
                @if(env('APP_SYNC'))
                    <div class="d-flex justify-content-center mt-20 grid_gap_5 flex-wrap">
                        <button class="btn_1" id="admin">{{ __('common.admin') }}</button>
                        <button class="btn_1" id="customer">{{ __('common.customer') }}</button>
                        @if (isModuleActive('MultiVendor'))
                        <button class="btn_1 mt_sm_0" id="seller">{{ __('common.seller') }}</button>
                        @endif
                    </div>
                @endif
                <br>
                <div class="register_form_iner">
                    <div class="login_logo text-center mb-3">
                        <a href="{{url('/')}}"><img src="{{asset(asset_path(app('general_setting')->logo))}}" alt=""></a>
                    </div>
                    <h2>{{ __('defaultTheme.welcome_back') }}, <br>{{ __('defaultTheme.please_login_to_your_account') }}</h2>
                    <form method="POST" class="register_form" name="login" action="{{ route('login') }}" id="login_form">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="email">{{ __('defaultTheme.email_or_phone') }}</label>
                                <input type="text" id="text" name="login" placeholder="{{ __('defaultTheme.email_or_phone') }}" value="{{ old('login') }}" class="@error('email') is-invalid @enderror"
                                    >

                                <span class="text-danger" >{{ $errors->first('email') }}</span>
                                <span class="text-danger" >{{ $errors->first('username') }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="password">{{ __('common.password') }}</label>
                                <input type="password" id="password" name="password" placeholder="{{ __('common.password') }}" class="@error('password') is-invalid @enderror" value="{{old('password')}}">

                                <span class="text-danger" >{{ $errors->first('password') }}</span>

                            </div>
                            <div class="col-md-6 col-6">
                                <div class="checkbox">
                                    <label class="cs_checkbox">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('defaultTheme.remember_me') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                            <a href="{{url('/password/reset')}}" class="forgot_pass_btn">{{ __('defaultTheme.forgot_password') }}</a>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn_1" id="submit_btn" disabled>{{ __('defaultTheme.login') }}</button>
                                    <div>
                                        <p><strong>{{ __('defaultTheme.login_with') }}</strong></p>
                                        @if (app('general_setting')->facebook_status)
                                        <a href="{{url('/login/facebook')}}" class="btn btn-sm btn-info"><i class="ti-facebook"></i></a>
                                        @endif
                                        @if (app('general_setting')->google_status)
                                        <a href="{{url('/login/google')}}" class="btn btn-sm btn-info"><i class="ti-google"></i></a>
                                        @endif
                                        @if (app('general_setting')->twitter_status)
                                        <a href="{{url('/login/twitter')}}" class="btn btn-sm btn-info"><i class="ti-twitter"></i></a>
                                        @endif
                                        @if (app('general_setting')->linkedin_status)
                                        <a href="{{url('/login/linkedin')}}" class="btn btn-sm btn-info"><i class="ti-linkedin"></i></a>
                                        @endif
                                    </div>

                                    <span>{{ __('defaultTheme.new_member') }}</span>
                                    <p> <a href="{{url('/register')}}">{{ __('defaultTheme.create_account') }}</a> {{ __('common.here') }}</p>
                                </div>
                            </div>
                        </div>
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
                $('#submit_btn').removeAttr('disabled');
                $(document).on('submit', '#login_form', function(event){

                    $('#login_form > div > div:nth-child(1) > span:nth-child(3)').text('');
                    $('#login_form > div > div:nth-child(2) > span').text('');
                    $('#login_form > div > div:nth-child(1) > span:nth-child(4)').text('');

                    let email = $('#text').val();
                    let password = $('#password').val();

                    let val_check = 0;

                    if(email == ''){
                        $('#login_form > div > div:nth-child(1) > span:nth-child(3)').text('The email or phone field is required.');
                        val_check = 1;
                    }

                    if(password == ''){
                        $('#login_form > div > div:nth-child(2) > span').text('The password field is required.');
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }
                });

                $(document).on('click', '#admin', function(event){
                    $("#text").val('superadmin@gmail.com');
                    $("#password").val('12345678');
                });
                $(document).on('click', '#customer', function(event){
                    $("#text").val('customer@gmail.com');
                    $("#password").val('12345678');
                });
                $(document).on('click', '#seller', function(event){
                    $("#text").val('seller@gmail.com');
                    $("#password").val('12345678');
                });

            });
        })(jQuery);
    </script>
@endpush
