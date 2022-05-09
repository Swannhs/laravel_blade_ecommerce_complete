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

                    <h2>{{ __('defaultTheme.welcome_back') }}, <br>{{ __('defaultTheme.please_input_new_password') }}</h2>
                    <form method="POST" class="register_form" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="password">{{ __('common.password') }}</label>
                                <input type="password" id="password" name="password" placeholder="{{ __('common.password') }}" @error('password') is-invalid @enderror" required
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = ''">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="password-confirm">{{ __('common.confirm_password') }}</label>
                                <input type="password" id="password-confirm" name="password_confirmation" required placeholder="{{ __('common.confirm_password') }}" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = ''" autocomplete="new-password">

                            </div>



                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn_1">{{ __('defaultTheme.send_link') }}</button>
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
