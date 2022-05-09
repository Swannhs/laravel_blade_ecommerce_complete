@extends('frontend.default.layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('Modules/PageBuilder/Resources/assets/css/affiliate.css')}}">
    <style>
        .row{
            margin: 0!important;
        }
    </style>
@endsection

@section('content')

{!! $row->description !!}

@endsection


