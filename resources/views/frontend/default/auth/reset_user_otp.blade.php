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
                <div class="register_form_iner">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="login_logo text-center mb-3">
                        <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                    </div>
                    <h2>{{ __('defaultTheme.welcome_back') }}, <br>{{ __('Please Send Otp') }} </h2>
                    <form method="POST" class="register_form" action="{{ route('send_password_reset_otp') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{$errors->first()}}
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="email">{{ __('common.email') }}</label>
                                <input type="text" id="email" name="email" placeholder="{{ __('common.email_or_phone') }}" required value="{{ old('email') }}" class="@error('email') is-invalid @enderror"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = '{{ __('common.email_or_phone') }}'">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn_1">{{ __('Send OTP') }}</button>
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
