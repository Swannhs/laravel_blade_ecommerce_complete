@extends('errors.illustrated-layout')

@section('code', '503')
@section('title', __('defaultTheme.service_unavailable'))

@section('image')
    <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center img_403">
    </div>
@endsection

@section('message', __('defaultTheme.sorry_we_are_doing_some_maintenance_please_check_back_soon'))
