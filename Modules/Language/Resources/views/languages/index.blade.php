@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/language/css/style.css'))}}" />

@endsection
@section('mainContent')

    @php
        $form_type = '';
        if(\Session::has('language_form')){
            $form_type = \Session::get('language_form');
        }


    @endphp
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('language.language_list') }}</h3>
                            @if (permissionCheck('languages.store'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="" id="add_new_btn"><i class="ti-plus"></i>{{ __('language.add_new_language') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.name') }}</th>
                                        <th scope="col">{{ __('language.code') }}</th>
                                        <th scope="col">{{ __('language.RTL') }}/{{__('language.LTL')}}</th>
                                        <th scope="col">{{ __('common.active') }}</th>
                                        <th scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($languages as $key=>$language)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $language->name }}</td>
                                            <td>{{ $language->code }}</td>
                                            <td>

                                                <span class="primary-btn radius_30px mr-10 fix-gr-bg rtl_ltl_btn"> @if($language->rtl == 1) {{__('language.RTL')}} @else {{__('language.LTL')}} @endif</span>
                                            </td>
                                            <td>
                                                <label class="switch_toggle" for="active_checkbox{{ $language->id }}">
                                                    <input type="checkbox" id="active_checkbox{{ $language->id }}" @if ($language->status == 1) checked @endif @if (permissionCheck('languages.update') && $language->id != 19) value="{{ $language->id }}" data-id="{{ $language->id }}" class="status_change" @else disabled @endif>
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        @if (permissionCheck('languages.update') && $language->id != 19)
                                                            <a href="" class="dropdown-item edit_language" data-id="{{ $language->id }}">{{__('common.edit')}}</a>
                                                        @endif
                                                        @if (permissionCheck('language.translate_view'))
                                                            <a href="{{ route('language.translate_view', $language->id) }}" class="dropdown-item edit_brand">{{ __('general_settings.Translation') }}</a>
                                                        @endif
                                                        @if (permissionCheck('languages.destroy') && $language->id > 114)
                                                            <a  data-id="{{$language->id}}" class="dropdown-item delete_language">{{__('common.delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div id="add_laguage_modal">
        <div class="modal fade admin-query" id="language_add">
            <div class="modal-dialog modal_800px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('language.add_new_language') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('languages.store') }}" method="POST" id="language_addForm">
                            @csrf
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                        <input name="name" id="name" class="primary_input_field name" placeholder="{{ __('common.name') }}" value="{{old('name')}}" type="text">
                                        <span class="text-danger" id="error_name">{{$errors->first('name')}}</span>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('language.code') }} <span class="text-danger">*</span></label>
                                        <input name="code" id="code" class="primary_input_field name" placeholder="{{ __('language.code') }}" value="{{old('code')}}" type="text">
                                        <span class="text-danger" id="error_code">{{$errors->first('code')}}</span>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('language.native_name') }} <span class="text-danger">*</span></label>
                                        <input name="native" id="native" class="primary_input_field name" placeholder="{{ __('language.native_name') }}" value="{{old('native')}}" type="text">
                                        <span class="text-danger" id="error_native">{{$errors->first('native')}}</span>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('language.RTL') }}/{{__('language.LTL')}}</label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="rtl_ltl" value="0" checked class="active"
                                                        type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{__('language.LTL')}}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="rtl_ltl" value="1" class="de_active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('language.RTL') }}</p>
                                            </li>
                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                        <ul id="theme_nav" class="permission_list sms_list ">
                                            <li>
                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="status" value="1" checked class="active"
                                                        type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.active') }}</p>
                                            </li>
                                            <li>
                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                    <input name="status" value="0" class="de_active" type="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{ __('common.inactive') }}</p>
                                            </li>
                                        </ul>
                                        <span class="text-danger" id="status_error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')

    <script type="text/javascript">
        (function($){
            "use strict";

            @if (count($errors) > 0 && $form_type == 'store_form')
                $('#language_add').modal('show');

            @endif

            $( document ).ready(function() {

                $(document).on('click', '#add_new_btn', function(event){
                    event.preventDefault();
                    $('#language_add').modal('show');
                });

                $(document).on('click', '.edit_language', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(this).data('id');
                    $.post('{{ route('languages.edit') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                        $('#edit_form').html(data);
                        $('#Item_Edit').modal('show');
                        $('#pre-loader').addClass('d-none');
                    });

                });

                $(document).on('click', '.delete_language', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    let baseUrl = $('#url').val();
                    let url = baseUrl + '/setup/language/destroy/' + id;
                    confirm_modal(url);
                });

                $(document).on('change', '.status_change', function(event){
                    event.preventDefault();
                    let status = 0;
                    if($(this).prop('checked')){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('id');
                    if(id == 19){
                        toastr.error("{{__('common.error_message')}}");
                        return false;
                    }
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('languages.update_active_status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }else{
                                toastr.error("{{__('common.error_message')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                        }
                    });

                });

                $(document).on('change', '.rtl_status_change', function(event){
                    event.preventDefault();
                    let status = 0;
                    if($(this).prop('checked')){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('id');
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('languages.update_rtl_status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });

                });

                $(document).on('submit', '#language_addForm', function(event){

                    $('#error_name').text("");
                    $('#error_code').text("");
                    $('#error_native').text("");

                    let name = $('#name').val();
                    let code = $('#code').val();
                    let native = $('#native').val();
                    let empty_check = 0;

                    if(name == ''){
                        $('#error_name').text("{{__('validation.this_field_is_required')}}");
                        empty_check = 1;
                    }
                    if(code == ''){
                        $('#error_code').text("{{__('validation.this_field_is_required')}}");
                        empty_check = 1;
                    }
                    if(native == ''){
                        $('#error_native').text("{{__('validation.this_field_is_required')}}");
                        empty_check = 1;
                    }
                    if(empty_check == 1){
                        event.preventDefault();
                    }
                });

                $(document).on('submit', '#languageEditForm', function(event){

                    $('#error_edit_name').text("");
                    $('#error_edit_code').text("");
                    $('#error_edit_native').text("");

                    let edit_name = $('#edit_name').val();
                    let edit_code = $('#edit_code').val();
                    let edit_native = $('#edit_native').val();
                    let empty_edit_check = 0;

                    if(edit_name == ''){
                        $('#error_edit_name').text("{{__('validation.this_field_is_required')}}");
                        empty_edit_check = 1;
                    }
                    if(edit_code == ''){
                        $('#error_edit_code').text("{{__('validation.this_field_is_required')}}");
                        empty_edit_check = 1;
                    }
                    if(edit_native == ''){
                        $('#error_edit_native').text("{{__('validation.this_field_is_required')}}");
                        empty_edit_check = 1;
                    }
                    if(empty_edit_check == 1){
                        event.preventDefault();
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
