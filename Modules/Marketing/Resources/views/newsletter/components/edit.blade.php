@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/style.css'))}}" />
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="">
            <div class="col-lg-10 offset-lg-1">
                <div class="main-title">
                    <h3 class="mb-30">
                        {{__('marketing.update_news_letter')}} </h3>
                </div>
            </div>
        </div>
        <div id="formHtml" class="col-lg-10 offset-lg-1">
            <div class="white-box">
                <form action="" id="edit_form">
                    <div class="add-visitor">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$message->id}}">
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="title">{{ __('common.title') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="title" name="title"
                                        autocomplete="off" value="{{$message->title}}" placeholder="{{ __('common.title') }}">
                                    <span class="text-danger" id="error_title"></span>
                                </div>


                            </div>

                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="message">{{ __('common.message') }}
                                        <span class="text-danger">*</span></label>

                                        <textarea name="message" id="message" class="summernote" placeholder="" >{{ $message->message?$message->message:$email_template->value }}</textarea>
                                        <span class="text-danger" id="error_message"></span>
                                </div>


                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="publish_date">{{ __('marketing.publish_on') }} <span
                                        class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{__('common.date')}}"
                                                        class="primary_input_field primary-input date form-control"
                                                        id="publish_date" type="text" name="publish_date"
                                                        value="{{date('m/d/Y',strtotime($message->publish_date))}}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                        <span class="text-danger" id="error_publish_date"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('marketing.send_to') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="send_to" id="send_to" class="primary_select mb-15">
                                        <option disabled selected>{{ __('common.select') }}</option>
                                        <option {{$message->send_type == 1?'selected':''}} value="1">{{__('marketing.all_user')}}</option>
                                        <option {{$message->send_type == 2?'selected':''}} value="2">{{__('marketing.role_wise')}}</option>
                                        <option {{$message->send_type == 3?'selected':''}} value="3">{{__('marketing.multiple_role_select_user')}}</option>
                                        <option {{$message->send_type == 4?'selected':''}} value="4">{{__('marketing.all_subscription')}}</option>


                                    </select>
                                    <span class="text-danger" id="error_send_to"></span>
                                </div>

                            </div>
                            <div id="all_user_div" class="col-lg-12 {{$message->send_type == 1?'':'d-none'}}">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="all_user">{{ __('marketing.all_user') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="all_user[]" id="all_user" class="primary_select mb-15"
                                        multiple>
                                        <option disabled>{{ __('common.select') }}</option>
                                        @php
                                            $selectedUsers = json_decode($message->send_user_ids);
                                        @endphp
                                        @if(isModuleActive('MultiVendor'))
                                            @foreach ($users as $key => $user)
                                                <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                                    {{ $user->email}}</option>
                                            @endforeach
                                        @else
                                            @foreach ($users->where('role_id','!=',5)->where('role_id','!=', 6) as $key => $user)
                                                <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                                    {{ $user->email}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="error_all_user"></span>
                                </div>

                            </div>
                            <div id="select_role_div" class="col-lg-12 {{$message->send_type == 2?'':'d-none'}}">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="role">{{ __('common.select_role') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="role" id="role" class="primary_select mb-15">
                                        <option disabled selected>{{ __('common.select') }}</option>
                                        @if(isModuleActive('MultiVendor'))
                                            @foreach ($roles as $key => $role)
                                                <option {{$message->single_role_id == $role->id?'selected':''}}  value="{{ $role->id }}">{{ $role->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($roles->where('type','!=','seller') as $key => $role)
                                                <option {{$message->single_role_id == $role->id?'selected':''}}  value="{{ $role->id }}">{{ $role->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="error_role"></span>
                                </div>

                            </div>
                            <div id="select_role_user_div" class="col-lg-12 {{$message->send_type == 2?'':'d-none'}}">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="">{{ __('marketing.selected_role_user') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="role_user[]" id="role_user" class="primary_select mb-15"
                                        multiple>
                                        <option disabled>{{ __('common.select') }}</option>

                                        @foreach ($users->where('role_id',$message->single_role_id) as $key => $user)
                                            <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                                {{ $user->email}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error_role_user"></span>
                                </div>

                            </div>
                            <div id="multiple_role_div" class="col-lg-12 {{$message->send_type == 3?'':'d-none'}}">
                                <label>{{__('marketing.mail_to')}} <span
                                    class="text-danger">*</span></label>
                                <br>
                                @php

                                    if($message->send_type == 3){
                                        $selectedRoles = json_decode($message->multiple_role_id);
                                    }else {
                                        $selectedRoles = [];
                                    }
                                @endphp
                                <div class="">
                                    <input type="checkbox" @if(count($selectedRoles) == count($roles)) checked @endif id="role_all"
                                         class="common-checkbox" value=""
                                        name="">
                                    <label for="role_all">{{__('common.all')}}</label>
                                </div>
                                @if(isModuleActive('MultiVendor'))
                                    @foreach ($roles as $key => $role)
                                        <div class="">
                                            <input type="checkbox" @if(in_array($role->id,$selectedRoles)) checked @endif id="role_{{ $role->id }}"
                                                class="common-checkbox multi_check" value="{{ $role->id }}"
                                                name="role_list[]">
                                            <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($roles->where('type','!=','seller') as $key => $role)
                                        <div class="">
                                            <input type="checkbox" @if(in_array($role->id,$selectedRoles)) checked @endif id="role_{{ $role->id }}"
                                                class="common-checkbox multi_check" value="{{ $role->id }}"
                                                name="role_list[]">
                                            <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                                <span class="text-danger" id="error_role_list"></span>


                            </div>
                            <div id="subscriber_div" class="col-lg-12 {{$message->send_type == 4?'':'d-none'}}">
                                <label>{{__('marketing.mail_to')}} <span
                                    class="text-danger">*</span></label>
                                <br>
                                @php
                                    if($message->send_type == 4){
                                        $emails = json_decode($message->send_user_ids);
                                    }else {
                                        $emails = [];
                                    }

                                @endphp
                                <div class="">
                                    <input type="checkbox" @if(count($emails) == count($subscribers)) checked @endif id="subscriber_all"class="common-checkbox" value="" name="">
                                    <label for="subscriber_all">{{__('common.all')}}</label>
                                </div>

                                @foreach ($subscribers as $key => $subscriber)

                                    <div class="">
                                        <input type="checkbox" @if(in_array($subscriber->id,$emails)) checked @endif id="subscriber_{{ $key }}"
                                            class="common-checkbox subscriber_check" value="{{ $subscriber->id }}"
                                            name="subscriber_list[]">
                                        <label for="subscriber_{{ $key }}">{{ $subscriber->email }}</label>
                                    </div>
                                @endforeach

                                <span class="text-danger" id="error_subscriber_list"></span>
                            </div>


                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                    data-toggle="tooltip" title="" data-original-title="">
                                    <span class="ti-check"></span>
                                    {{ __('common.update') }} </button>
                                <button type="button" class="primary-btn fix-gr-bg" id="show_test_mail_btn"
                                    data-toggle="tooltip" title="" data-original-title="">
                                    <span class="ti-check"></span>
                                    {{ __('marketing.test_mail') }} </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="testMailDiv">
        @include('marketing::newsletter.components.test_mail_modal')
    </div>
</section>
@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('submit', '#edit_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);
                    $('#submit_btn').text('{{ __('common.updating') }}');

                    $('#pre-loader').removeClass('d-none');
                    resetForm();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('marketing.news-letter.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {

                            reloadWithData(response);
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $('#submit_btn').text('{{ __('common.update') }}');
                            window.location.href = "{{ route('marketing.news-letter')}}";
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('{{ __('common.update') }}');
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __('common.error_message') }}')
                            showValidationErrors('#edit_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('change', '#send_to', function(event) {
                    let value = $('#send_to').val();
                    if (value == 1) {
                        $('#all_user_div').removeClass('d-none');
                    } else {
                        $('#all_user_div').addClass('d-none');
                    }
                    if (value == 2) {
                        $('#select_role_div').removeClass('d-none');
                        $('#select_role_user_div').removeClass('d-none');
                    } else {
                        $('#select_role_div').addClass('d-none');
                        $('#select_role_user_div').addClass('d-none');
                    }
                    if (value == 3) {
                        $('#multiple_role_div').removeClass('d-none');
                    } else {
                        $('#multiple_role_div').addClass('d-none');
                    }
                    if (value == 4) {
                        $('#subscriber_div').removeClass('d-none');
                    } else {
                        $('#subscriber_div').addClass('d-none');
                    }
                });
                $(document).on('change', '#role', function(event) {
                    $('#role_user').empty();
                    $('#pre-loader').removeClass('d-none');
                    let role = $('#role').val();
                    let base_url = $('#url').val();
                    let url = base_url + '/marketing/news-letter/role-user?id=' + role;
                    $.get(url, function(data) {
                        console.log(data)
                        $('#role_user').empty();
                        $('#role_user').html(data);
                        $('#role_user').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                });

                $(document).on('submit', '#testMailForm', function(event) {
                    event.preventDefault();
                    let email = $('#email').val();
                    if(email != ''){

                        $("#mail_send_btn").prop('disabled', true);
                        $('#mail_send_btn').text("{{ __('marketing.sending') }}");
                        $('#error_email').text('');

                        $('#pre-loader').removeClass('d-none');

                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('marketing.news-letter.test-mail') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                toastr.success("{{__('marketing.test_mail_has_been_send_successfully')}}","{{__('common.success')}}");
                                $("#mail_send_btn").prop('disabled', false);
                                $('#mail_send_btn').text("{{ __('common.send') }}");
                                $('#testModal').modal('hide');
                                window.location.href = "{{ route('marketing.news-letter')}}";
                            },
                            error: function(response) {
                                $("#mail_send_btn").prop('disabled', false);
                                $('#mail_send_btn').text("{{ __('common.send') }}");
                                $('#pre-loader').addClass('d-none');
                                toastr.error('{{ __("common.error_message") }}')
                            }
                        });
                    }else{
                        $('#error_email').text('Email is Required.');
                    }
                });

                $('#message').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 600,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('change', '#role_all', function(){
                        role_all_check($(this)[0]);
                    });

                $(document).on('change', '#subscriber_all', function(){
                    subscriber_all_check($(this)[0]);
                });

                $(document).on('click', '#show_test_mail_btn', function(event){
                    $('#testModal').modal('show');
                });

                function role_all_check(el) {
                    if (el.checked) {
                        $('.multi_check').prop('checked', true);
                    } else {
                        $('.multi_check').prop('checked', false);
                    }
                }
                function subscriber_all_check(el){
                    if (el.checked) {
                        $('.subscriber_check').prop('checked', true);
                    } else {
                        $('.subscriber_check').prop('checked', false);
                    }
                }

                function reloadWithData(response){
                    $('#item_table').empty();
                    $('#item_table').html(response);
                    CRMTableThreeReactive();
                }
                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_title').text(errors.title);
                    $(formType + ' #error_message').text(errors.message);
                    $(formType + ' #error_send_to').text(errors.send_to);
                    $(formType + ' #error_notice_date').text(errors.notice_date);
                    $(formType + ' #error_publish_date').text(errors.publish_date);
                    $(formType + ' #error_all_user').text(errors.all_user);
                    $(formType + ' #error_role').text(errors.role);
                    $(formType + ' #error_role_user').text(errors.role_user);
                    $(formType + ' #error_role_list').text(errors.role_list);
                    $(formType + ' #error_subscriber_list').text(errors.subscriber_list);
                }
                function resetForm() {
                    $('#error_title').text('');
                    $('#error_message').text('');
                    $('#error_send_to').text('');
                    $('#error_notice_date').text('');
                    $('#error_publish_date').text('');
                    $('#error_all_user').text('');
                    $('#error_role').text('');
                    $('#error_role_user').text('');
                    $('#error_role_list').text('');
                    $('#error_subscriber_list').text('');
                }
            });
        })(jQuery);

    </script>
@endpush
