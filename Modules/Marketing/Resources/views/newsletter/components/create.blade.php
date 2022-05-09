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
                        {{__('marketing.create_news_letter')}} </h3>
                </div>
            </div>
        </div>
        <div id="formHtml" class="col-lg-10 offset-lg-1">
            <div class="white-box">
                <form action="" id="add_form">
                    <div class="add-visitor">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="title">{{ __('common.title') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="title" name="title"
                                        autocomplete="off" value="" placeholder="{{ __('common.title') }}">
                                    <span class="text-danger" id="error_title"></span>
                                </div>

                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.short_code')}} <small>({{__('general_settings.use_these_to_get_your_neccessary_info')}})</small> </label>
                                    <label class="primary_input_label red_text" for="">{GIFT_CARD_NAME}, {SECRET_CODE}, {USER_FIRST_NAME}, {USER_EMAIL}, {EMAIL_SIGNATURE}, {EMAIL_FOOTER}, {ORDER_TRACKING_NUMBER}, {WEBSITE_NAME}</label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="message">{{ __('common.message') }}
                                        <span class="text-danger">*</span></label>

                                        <textarea name="message" id="message" class="summernote" placeholder="" >{{ $email_template->value }}</textarea>
                                </div>

                                <span class="text-danger" id="error_message"></span>
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
                                                        value="{{date('m/d/Y')}}" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="error_publish_date"></span>
                                </div>

                            </div>



                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('marketing.send_to') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="send_to" id="send_to" class="primary_select mb-15">
                                        <option disabled selected>{{ __('common.select') }}</option>
                                        <option value="1">{{__('marketing.all_user')}}</option>
                                        <option value="2">{{__('marketing.role_wise')}}</option>
                                        <option value="3">{{__('marketing.multiple_role_select_user')}}</option>
                                        <option value="4">{{__('marketing.all_subscription')}}</option>


                                    </select>

                                    <span class="text-danger" id="error_send_to"></span>

                                </div>

                            </div>
                            <div id="all_user_div" class="col-lg-12 d-none">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="all_user">{{ __('marketing.all_user') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="all_user[]" id="all_user" class="primary_select mb-15"
                                        multiple>
                                        <option disabled>{{ __('common.select') }}</option>
                                        @if(isModuleActive('MultiVendor'))
                                            @foreach ($users as $key => $user)
                                                <option selected value="{{ $user->id }}">
                                                    {{ $user->email}}</option>
                                            @endforeach
                                        @else
                                            @foreach ($users->where('role_id','!=',5)->where('role_id','!=', 6) as $key => $user)
                                                <option selected value="{{ $user->id }}">
                                                    {{ $user->email}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="error_all_user"></span>
                                </div>



                            </div>
                            <div id="select_role_div" class="col-lg-12 d-none">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="role">{{ __('common.select_role') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="role" id="role" class="primary_select mb-15">
                                        <option disabled selected>{{ __('common.select') }}</option>
                                        @if(isModuleActive('MultiVendor'))
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($roles->where('type','!=','seller') as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="error_role"></span>
                                </div>


                            </div>
                            <div id="select_role_user_div" class="col-lg-12 d-none">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="">{{ __('marketing.selected_role_user') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="role_user[]" id="role_user" class="primary_select mb-15"
                                        multiple>
                                        <option disabled>{{ __('common.select') }}</option>

                                    </select>
                                    <span class="text-danger" id="error_role_user"></span>
                                </div>


                            </div>
                            <div id="multiple_role_div" class="col-lg-12 d-none">
                                <label>{{__('marketing.mail_to')}} <span
                                    class="text-danger">*</span></label>
                                <br>
                                <div class="">
                                    <input type="checkbox" checked id="role_all"
                                         class="common-checkbox" value=""
                                        name="">
                                    <label for="role_all">{{__('common.all')}}</label>
                                </div>
                                @if(isModuleActive('MultiVendor'))
                                    @foreach ($roles as $key => $role)
                                        <div class="">
                                            <input type="checkbox" checked id="role_{{ $role->id }}"
                                                class="common-checkbox multi_check" value="{{ $role->id }}"
                                                name="role_list[]">
                                            <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($roles->where('type','!=','seller') as $key => $role)
                                        <div class="">
                                            <input type="checkbox" checked id="role_{{ $role->id }}"
                                                class="common-checkbox multi_check" value="{{ $role->id }}"
                                                name="role_list[]">
                                            <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif

                                <span class="text-danger" id="error_role_list"></span>

                            </div>
                            <div id="subscriber_div" class="col-lg-12 d-none">
                                <label>{{__('marketing.mail_to')}} <span
                                    class="text-danger">*</span></label>
                                <br>
                                <div class="">
                                    <input type="checkbox" checked id="subscriber_all" class="common-checkbox" value=""
                                        name="">
                                    <label for="subscriber_all">{{__('common.all')}}</label>
                                </div>
                                @foreach ($subscribers as $key => $subscriber)
                                    @if($key == 10)
                                        @break;
                                    @endif
                                    <div class="">
                                        <input type="checkbox" checked id="subscriber_{{ $key }}"
                                            class="common-checkbox subscriber_check" value="{{ $subscriber->id }}"
                                            name="subscriber_list[]">
                                        <label for="subscriber_{{ $key }}">{{ $subscriber->email }}</label>
                                    </div>
                                @endforeach

                                <span class="text-danger" id="error_subscriber_list"></span>

                            </div>


                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-6 offset-lg-3">
                                <div class="col-lg-12 text-center">
                                    <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                        data-toggle="tooltip" title="" data-original-title="">
                                        <span class="ti-check"></span>
                                        {{ __('marketing.save_test_mail') }} </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="testMailDiv">
    </div>
</section>
@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('submit', '#add_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);
                    $('#submit_btn').text("{{ __('common.submitting') }}");

                    $('#pre-loader').removeClass('d-none');
                    removeValidateError();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('marketing.news-letter.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {

                            reloadWithData(response);
                            resetForm();
                            toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('Save & Test Mail');
                            $('#pre-loader').addClass('d-none');

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('Save & Test Mail');
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}')
                            showValidationErrors('#add_form', response.responseJSON.errors);
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
                                $('#testModal').modal('hide');
                                $("#mail_send_btn").prop('disabled', false);
                                $('#mail_send_btn').text("{{ __('common.send') }}");

                                window.location.href = "{{ route('marketing.news-letter')}}";
                            },
                            error: function(response) {
                                $("#mail_send_btn").prop('disabled', false);
                                $('#mail_send_btn').text("{{ __('common.send') }}");
                                $('#pre-loader').addClass('d-none');
                                toastr.error('{{ __("common.error_message") }}');
                            }
                        });
                    }else{
                        $('#error_email').text('Email is Required.');
                    }
                });

                $('#message').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 500,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('change', '#role_all', function(){
                    role_all_check($(this)[0]);
                });

                $(document).on('change', '#subscriber_all', function(){
                    subscriber_all_check($(this)[0]);
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
                    $('#testMailDiv').empty();
                    $('#testMailDiv').html(response.testMailModal);
                    $('#testModal').modal('show');
                }
                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_title').text(errors.title);
                    $(formType + ' #error_message').text(errors.message);
                    $(formType + ' #error_send_to').text(errors.send_to);
                    $(formType + ' #error_publish_date').text(errors.publish_date);
                    $(formType + ' #error_all_user').text(errors.all_user);
                    $(formType + ' #error_role').text(errors.role);
                    $(formType + ' #error_role_user').text(errors.role_user);
                    $(formType + ' #error_role_list').text(errors.role_list);
                    $(formType + ' #error_subscriber_list').text(errors.subscriber_list);
                }
                function resetForm() {
                    $('#add_form')[0].reset();
                    $('#send_to').niceSelect('update');
                    $('#all_user_div').addClass('d-none');
                    $('#select_role_div').addClass('d-none');
                    $('#select_role_user_div').addClass('d-none');
                    $('#multiple_role_div').addClass('d-none');
                    $('#subscriber_div').addClass('d-none');
                }

                function removeValidateError(){
                    $('#error_title').text('');
                    $('#error_message').text('');
                    $('#error_send_to').text('');
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
