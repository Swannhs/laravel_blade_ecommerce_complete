@extends('backEnd.master')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/setup/css/style.css'))}}" />


@endsection

@section('mainContent')

    @php
        $google_analytics_data = $analytics->where('type', 'google_analytics')->first();
        $facebook_pixel_data = $analytics->where('type', 'facebook_pixel')->first();

        $google_business_data = $businessData->where('type', 'google_analytics')->first();
        $facebook_business_data = $businessData->where('type', 'facebook_pixel')->first();

    @endphp

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    @if (permissionCheck('setup.google-analytics-update'))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h3 class="mb-30">
                                        {{ __('setup.google_analytics') }} </h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form action="{{ route('setup.google-analytics-update') }}" method="POST" id="google_analytics_form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="white_box_50px box_shadow_white mb-40 minh-430">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input">
                                                    <ul id="theme_nav" class="permission_list sms_list">
                                                        <li>
                                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                <input name="status" id="google_status" value="1" {{$google_business_data->status == 1?'checked':''}} type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('setup.enable_google_analytics') }}</p>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <input type="hidden" name="business_id" value="{{$google_business_data->id}}">
                                                <input type="hidden" name="analytics_id" value="{{$google_analytics_data->id}}">
                                            </div>

                                            <div class="col-lg-12">
                                                <ul id="theme_nav" class="permission_list sms_list">
                                                    <li>
                                                        <a class="facebook_link_btn" href="https://console.cloud.google.com/apis" target="_blank"><strong>{{__('setup.click_here_to_create_your_project')}}</strong></a>
                                                    </li>
                                                    <li>
                                                        <a class="facebook_link_btn" href="https://analytics.google.com/analytics" target="_blank"><strong>{{__('setup.click_here_to_create_google_analytics')}}</strong></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <input type="hidden" name="types[]" value="ANALYTICS_TRACKING_ID">
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="tracking_id">UA-Tracking ID <span class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="text" id="tracking_id" name="ANALYTICS_TRACKING_ID" autocomplete="off" value="{{env('ANALYTICS_TRACKING_ID')}}" placeholder="" >
                                                    @error('ANALYTICS_TRACKING_ID')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <input type="hidden" name="types[]" value="ANATYTIC_RESULT_DASHBOARD">
                                            <div class="col-xl-12">
                                                <div class="primary_input">
                                                    <ul id="theme_nav" class="permission_list sms_list ">
                                                        <li>
                                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                <input id="analytics_view_status" value="1" @if(old('ANATYTIC_RESULT_DASHBOARD')) {{(old('ANATYTIC_RESULT_DASHBOARD') == 1)?'checked':'' }} @elseif(env('ANATYTIC_RESULT_DASHBOARD') == 1) checked @endif type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('setup.enable_gs_analytics_for_your_dashboard') }}</p>
                                                        </li>
                                                        <input type="hidden" id="dashboard_is_enable" name="ANATYTIC_RESULT_DASHBOARD" value="{{env('ANATYTIC_RESULT_DASHBOARD')}}">
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" name="types[]" value="ANALYTICS_VIEW_ID">
                                            <div class="col-lg-12 analytics_view_div @if(old('ANATYTIC_RESULT_DASHBOARD')) {{(old('ANATYTIC_RESULT_DASHBOARD') == 0)?'d-none':'' }} @elseif (env('ANALYTICS_VIEW_ID') == 0 || env('ANATYTIC_RESULT_DASHBOARD') == 0) d-none @endif">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="tracking_id">View ID<span class="text-danger"> *</span></label>
                                                    <input class="primary_input_field" type="text" id="tracking_id" name="ANALYTICS_VIEW_ID" autocomplete="off" value="{{env('ANALYTICS_VIEW_ID')}}" placeholder="{{ __('setup.tracking_id') }}" >
                                                    @error('ANALYTICS_VIEW_ID')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-12 upload_photo_div @if(old('ANATYTIC_RESULT_DASHBOARD')) {{(old('ANATYTIC_RESULT_DASHBOARD') == 0)?'d-none':'' }} @elseif (env('ANALYTICS_VIEW_ID') == 0 || env('ANATYTIC_RESULT_DASHBOARD') == 0) d-none @endif">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="tracking_id">
                                                        {{ __('setup.service_account_json_file') }} <span class="text-danger"> *</span></label>
                                                    <div class="primary_file_uploader">
                                                      <input class="primary-input" type="text" id="json_file" placeholder="{{__('common.choose_file')}}" readonly="">
                                                      <button class="" type="button">
                                                          <label class="primary-btn small fix-gr-bg" for="json">{{__('common.browse')}} </label>
                                                          <input type="file" class="d-none" name="json" id="json">
                                                      </button>

                                                   </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <strong>{{__('setup.fill_in_the_two_fields_below_for_the_Google_Analytics_version_4')}}</strong>
                                                <strong>{{__('setup.for_reporting_version_4_see_google_analytics_panel')}}</strong>
                                            </div>

                                            <input type="hidden" name="types[]" value="MEASUREMENT_ID">
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="measurement_id">{{__('setup.measurement_id')}} </label>
                                                    <input class="primary_input_field" type="text" id="measurement_id" name="MEASUREMENT_ID" autocomplete="off" value="{{env('MEASUREMENT_ID')}}" placeholder="" >
                                                    @error('ANALYTICS_MEASUREMENT_ID')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <input type="hidden" name="types[]" value="MEASUREMENT_PROTOCOL_API_SECRET">
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="measurement_protocol_api_secret">{{__('setup.measurement_protocol_api_secret')}}</label>
                                                    <input class="primary_input_field" type="text" id="measurement_protocol_api_secret" name="MEASUREMENT_PROTOCOL_API_SECRET" autocomplete="off" value="{{env('MEASUREMENT_PROTOCOL_API_SECRET')}}" placeholder="" >
                                                    @error('ANALYTICS_MEASUREMENT_PROTOCOL_API_SECRET')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-40 text-center">
                                                <button id="google_submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                                    data-toggle="tooltip" title="" data-original-title="">
                                                    <span class="ti-check"></span>
                                                    {{ __('common.save') }} </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    @if (permissionCheck('setup.facebook-pixel-update'))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h3 class="mb-30">
                                        {{ __('setup.facebook_pixel') }} </h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form action="" method="POST" id="facebook_pixel_form">
                                    <div class="white_box_50px box_shadow_white mb-40 minh-430">
                                        <div class="row">

                                            <div class="col-xl-6">
                                                <div class="primary_input">
                                                    <ul id="theme_nav" class="permission_list sms_list ">
                                                        <li>
                                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                <input name="status" id="facebook_status" value="1" {{$facebook_business_data->status == 1?'checked':''}} type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('setup.enable_facebook_pixel') }}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="business_id" value="{{$facebook_business_data->id}}">
                                                <input type="hidden" name="analytics_id" value="{{$facebook_pixel_data->id}}">
                                            </div>
                                            <div class="col-lg-6">
                                                <a class="facebook_link_btn" target="_blank" href="https://developers.facebook.com/docs/facebook-pixel/"><strong>{{__('setup.click_here_to_create_facebook_pixel')}}</strong></a>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="facebook_pixel_id">{{ __('setup.facebook_pixel_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="text"
                                                        id="facebook_pixel_id" name="facebook_pixel_id"
                                                        autocomplete="off" value="{{$facebook_pixel_data->facebook_pixel_id}}"
                                                        placeholder="{{ __('setup.facebook_pixel_id') }}" >
                                                    <span class="text-danger" id="error_facebook_pixxel_id"></span>
                                                </div>



                                            </div>

                                            <div class="col-lg-12 mt-40 text-center">
                                                <button id="facebook_submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                                    data-toggle="tooltip" title="" data-original-title="">
                                                    <span class="ti-check"></span>
                                                    {{ __('common.save') }} </button>


                                            </div>


                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    @endif
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
                $(document).on('click', '#analytics_view_status', function(){
                    if (this.checked == true) {
                        $('.analytics_view_div').removeClass('d-none');
                        $('.upload_photo_div').removeClass('d-none');
                    }else {
                        $('.analytics_view_div').addClass('d-none');
                        $('.upload_photo_div').addClass('d-none');
                    }
                });
                $(document).on('submit', '#facebook_pixel_form', function(event){
                    event.preventDefault();
                    let facebook_pixel_id = $('#facebook_pixel_id').val();
                    $('#error_facebook_pixxel_id').text("");
                    if(facebook_pixel_id == ''){
                        $('#error_facebook_pixxel_id').text("{{__('setup.facebook_pixel_id_required')}}");
                        return false;
                    }

                    $('#pre-loader').removeClass('d-none');
                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");

                        $.ajax({
                            url: "{{ route('setup.facebook-pixel-update') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                $('#pre-loader').addClass('d-none');
                                toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");

                            },
                            error: function(response) {
                                if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }
                                toastr.error('{{ __("common.error_message") }}');
                                $('#pre-loader').addClass('d-none');
                            }
                        });

                });
                $(document).on('change', '#analytics_view_status', function(event){
                    let status = 0;
                    if($('#analytics_view_status').prop('checked')){
                        status = 1;
                    }
                    $('#dashboard_is_enable').val(status);
                });

                $(document).on('change', '#json', function(){
                    getFileName($(this).val(),'#json_file');
                });
            });
        })(jQuery);
    </script>
@endpush
