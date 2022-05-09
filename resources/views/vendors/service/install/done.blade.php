@extends('service::layouts.app', ['title' => __('service::install.welcome')])

@section('content')

<div class="single-report-admit">
    <div class="card-header">
        <h2 class="text-center text-uppercase color-whitesmoke" >{{ __('service::install.welcome_title') }}
        </h2>

    </div>
</div>

<div class="card-body">
    <p class="text-center">
        {{ __('service::install.confirm_description') }}
    </p>
    <p class="text-center">
        Your Super Admin email : <b> {{ $user }} </b> <br>
        Your Super Admin password : <b> {{ $pass }} </b>
    </p>

    <a href="{{ url('/') }}" class="offset-3 col-sm-6 primary-btn fix-gr-bg mt-40 mb-20">
        {{ __('service::install.goto_home') }} </a>
</div>

@stop
