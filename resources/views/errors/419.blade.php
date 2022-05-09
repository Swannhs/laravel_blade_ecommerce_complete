@extends('errors.illustrated-layout')

@section('code', '419')
@section('title', __('defaultTheme.page_expired'))

@section('image')
    <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center img_403">
    </div>
@endsection

@section('message', __('defaultTheme.sorry_your_session_has_expired_please_refresh_and_try_again'))
