@extends('errors.illustrated-layout')

@section('code', '403')
@section('title', __('defaultTheme.forbidden'))

@section('image')
    <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center img_403">
    </div>
@endsection

@section('message', __('defaultTheme.sorry_your_session_has_expired_please_refresh_and_try_again'))

