@extends('service::layouts.app_install', ['title' => __('service::install.welcome')])


@section('content')

<div class="single-report-admit">
    <div class="card-header">
        <h2 class="text-center text-uppercase color-whitesmoke" >{{ __('service::install.welcome_title') }}
        </h2>

    </div>
</div>

<div class="card-body">
    <p class="text-center">
        {{ __('service::install.welcome_description') }}
    </p>

    <a href="{{ route('service.preRequisite') }}" class="offset-3 col-sm-6 primary-btn fix-gr-bg mt-40 mb-20">
        {{ __('service::install.get_started') }} </a>
</div>

@stop
