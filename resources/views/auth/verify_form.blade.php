
@extends('frontend.default.auth.layouts.app')

@section('content')
    <section class="register_part">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="register_form_iner">
                        <h2>Welcome! {{$details['first_name']}}<br></h2>
                        <a class="btn btn-success" href="{{url('/verify?code=').$details['verify_code']}}">Click Here To Verify Your Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



