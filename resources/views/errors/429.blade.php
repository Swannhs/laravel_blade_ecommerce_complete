@extends('errors.illustrated-layout')

@section('code', '429')
@section('title', __('defaultTheme.too_many_requests'))

@section('image')
    <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center img_403">
    </div>
@endsection

@section('message', __('defaultTheme.sorry_you_are_making_too_many_requests_to_our_servers'))
