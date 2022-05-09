@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/generalsetting/css/style.css'))}}" />
@endsection
@section('mainContent')

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row pt-20">
                        <div class="main-title pl-3 pt-10">
                            <h3 class="mb-30">{{__('general_settings.maintenance')}} {{__('common.setting')}}</h3>
                        </div>
                    </div>

                    <form class="form-horizontal" action="{{ route('maintenance.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="white-box">

                            <div class="col-md-12 p-0">

                                <div class="row mb-30">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('common.title') }}</label>
                                                    <input class="primary_input_field" placeholder="-" type="text"
                                                           name="title"
                                                           value="{{$setting->maintenance_title}}">
                                                    @error('title')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('common.sub_title') }}  </label>
                                                    <input class="primary_input_field" placeholder="-" type="text"
                                                           name="subtitle"
                                                           value="{{$setting->maintenance_subtitle}}">
                                                    @error('subtitle')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">
                                                    <div class="banner_img_div">
                                                        <img class="imagePreview1"
                                                            src="{{showImage($setting->maintenance_banner)}}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"



                                                           for="">{{ __('general_settings.maintenance_page_banner') }} (1300x920)PX
                                                    </label>
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input  filePlaceholder"
                                                            type="text" id="filePlaceholder"
                                                            placeholder="Browse file"
                                                            readonly="" {{ $errors->has('course_page_banner') ? ' autofocus' : '' }}>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="file1">{{ __('common.browse') }}</label>
                                                            <input type="file" class="d-none fileUpload imgInput1"
                                                                   name="banner" id="file1">
                                                        </button>
                                                    </div>
                                                    @error('banner')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 dripCheck">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="primary_input_label"
                                                                   for="    "> {{__('general_settings.maintenance')}} {{__('general_settings.mode')}}</label>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="yes"
                                                                           name="status"
                                                                           {{$setting->maintenance_status==1?'checked':''}}
                                                                           value="1">
                                                                    <label
                                                                        for="yes">{{__('common.yes')}}</label>
                                                                </div>
                                                                <div class="col-md-4">

                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="no"
                                                                           name="status"
                                                                           value="0" {{$setting->maintenance_status==0?'checked':''}}>
                                                                    <label
                                                                        for="no">{{__('common.no')}}</label>
                                                                </div>
                                                            </div>
                                                            @error('status')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="row justify-content-center">

                                            @if(session()->has('message-success'))
                                                <p class=" text-success">
                                                    {{ session()->get('message-success') }}
                                                </p>
                                            @elseif(session()->has('message-danger'))
                                                <p class=" text-danger">
                                                    {{ session()->get('message-danger') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(permissionCheck('maintenance.update'))

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                    >
                                        <span class="ti-check"></span>
                                        {{__('common.update')}}
                                    </button>
                                </div>
                            </div>
                            @else
                            <span class="text-danger">{{__('common.no_action_permitted')}}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('change', '#file1', function(event){
                    getFileName($(this).val(),'#filePlaceholder');
                    imageChangeWithFile($(this)[0],'.imagePreview1');
                });
            });
        })(jQuery);

    </script>
@endpush
