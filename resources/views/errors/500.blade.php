@extends('errors.illustrated-layout')

@section('code', '500')
@section('title', __('common.error'))

@section('image')
    <div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center img_403">
    </div>
@endsection

@section('message', __('defaultTheme.whoops_something_went_wrong_on_our_servers'))
