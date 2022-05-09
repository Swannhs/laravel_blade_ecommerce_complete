@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/profile.css'))}}" />
@endsection
@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">

            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#basicInfo" role="tab" data-toggle="tab"
                                    aria-selected="true">{{ __('common.basic_info') }} </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#changePassword" role="tab" data-toggle="tab"
                                    aria-selected="true">{{ __('common.change_password') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#addressInfo" role="tab" data-toggle="tab"
                                    id="address_list_tab" aria-selected="true">{{ __('common.address') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="white_box_30px mb_30">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active show" id="basicInfo">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.basic_info') }}</h3>
                                </div>
                            </div>

                            <form action="#" name="basic_info" method="POST" id="basic_info"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{__('common.first_name')}} <span
                                                    class="text-danger">*</span></label>
                                            <input name="first_name" class="primary_input_field first_name"
                                                id="first_name" placeholder="{{__('common.first_name')}}"
                                                value="{{$user_info->first_name}}" type="text" required>
                                            <span class="text-danger" id="error_first_name"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{__('common.last_name')}}</label>
                                            <input name="last_name" class="primary_input_field last_name" id="last_name"
                                                placeholder="{{__('common.last_name')}}"
                                                value="{{$user_info->last_name}}" type="text" required>
                                            <span class="text-danger" id="error_last_name"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.email_address') }}
                                                <span class="text-danger">*</span></label>
                                            <input name="email" class="primary_input_field email_address" id="email"
                                                placeholder="{{ __('common.email_address') }}"
                                                value="{{$user_info->email}}" type="email">
                                            <span class="text-danger" id="error_email"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.phone_number') }}
                                                <span class="text-danger">*</span></label>
                                            <input name="phone" class="primary_input_field phone" id="phone"
                                                placeholder="{{ __('common.phone_number') }}"
                                                value="{{$user_info->phone}}" type="tel">
                                            <span class="text-danger" id="error_phone"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 date_of_birth_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('common.date_of_birth') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="{{ __('common.date') }}"
                                                                class="primary_input_field primary-input date form-control"
                                                                id="date_of_birth" type="text" name="date_of_birth"
                                                                value="{{ date('m/d/Y', strtotime($user_info->date_of_birth)) }}"
                                                                autocomplete="off">

                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                    <span class="text-danger" id="error_date_of_birth"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('common.avatar') }}
                                                (165x165)PX</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="avatar_placeholder"
                                                    placeholder="{{ __('common.avatar') }}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="avatar_file">{{
                                                        __('common.avatar') }}</label>
                                                    <input type="file" class="d-none" name="file" id="avatar_file"
                                                        accept="image/*">
                                                </button>
                                                <span class="text-danger" id="error_avatar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="avatar_preview_div">
                                            <img id="avatar_preview"
                                                src="{{showImage($user_info->avatar != null?$user_info->avatar:'backend/img/avatar.png')}}"
                                                alt="">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.description')
                                                }}</label>
                                            <textarea class="primary_textarea height_112 description"
                                                placeholder="{{ __('common.description') }}" name="description"
                                                spellcheck="false">{{$user_info->description}}</textarea>
                                            <span class="text-danger">{{$errors->first('description')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="button" id="update_info"
                                                class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i>{{
                                                __('common.update') }} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="changePassword">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.change_password') }}</h3>
                                </div>
                            </div>
                            <form action="#" name="basic_info" method="POST" id="update_pass">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="currentPassword">{{__('common.current')}}
                                                {{__('common.password')}} <span class="text-danger">*</span></label>
                                            <input type="password" class="primary_input_field" id="currentPassword"
                                                placeholder="{{__('common.current')}} {{__('common.password')}}"
                                                name="current_password" required="">
                                            <span class="validation-old-pass-error text-danger error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="Newpass">{{__('common.new')}}
                                                {{__('common.password')}} <span class="text-danger">*</span></label>
                                            <input type="password" class="primary_input_field" id="newPass"
                                                placeholder="{{__('common.new')}} {{__('common.password')}}" required=""
                                                name="new_password">
                                            <span class="validation-new-pass-error text-danger error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="repass">{{__('common.re_enter')}}
                                                {{__('common.new')}} {{__('common.password')}} <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="primary_input_field" id="rePass"
                                                placeholder="{{__('common.re_enter')}} {{__('common.new')}} {{__('common.password')}}"
                                                required="" name="new_password_confirmation">
                                            <span class="validation-new-pass-confirm-error text-danger error"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="button"
                                                class="primary-btn semi_large2 fix-gr-bg change_password"><i
                                                    class="ti-check"></i>{{ __('common.update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="addressInfo">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-flex flex-wrap">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.address') }}</h3>
                                    <ul class="d-flex">
                                        <li class="white"><a
                                                class="primary-btn radius_30px mr-10 fix-gr-bg add_new_address"><i
                                                    class="ti-plus"></i>{{__('common.add_new')}}
                                                {{__('common.address')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="javascript:void(0)" id="make_dft_shipping">{{__('common.make')}}
                                {{__('common.default')}} {{__('defaultTheme.shipping')}} {{__('common.address')}}</a>
                            <span class="dibeider">|</span>
                            <a href="javascript:void(0)" id="make_dft_billing">{{__('common.make')}}
                                {{__('common.default')}} {{__('defaultTheme.billing')}} {{__('common.address')}}</a>

                            <div class="QA_section QA_section_heading_custom check_box_table" id="address_list">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="table-responsive">
                                        <table class="table Crm_table_active2" id="address_table">
                                            @include('backEnd.pages.customer_data._table')
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="adrs_other_div d-none mt-10" id="default_shipping_adrs">
                                @include('backEnd.pages.customer_data._shipping_address')
                            </div>
                            <!-- make default billing address -->
                            <div class="adrs_other_div d-none mt-10" id="default_billing_adrs">
                                @include('backEnd.pages.customer_data._billing_address')
                            </div>
                            <div id="address_form_div" class="adrs_other_div d-none">
                                @include('backEnd.pages.customer_data._address_form')
                            </div>
                            <!-- edit -->
                            <div id="address_form_div_edit" class="adrs_other_div d-none">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="" id="get_asset_path" value="{{asset_path('')}}">
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
            "use strict";

            $(document).ready(function () {

                $('#datepicker').datepicker({
                    format: 'mm-dd-yyyy'
                });
                $(document).on('click','#update_info',function(e){
                    e.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $('#basic_info').serializeArray();
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");

                    let avatar = $('#avatar_file')[0].files[0];
                    if (avatar) {
                        formData.append('avatar', avatar)
                    }

                    basic_info_remove_validate_error();
                    $.ajax({
                        url: "{{route('customer.update.info')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('.info_error').text('');
                            $('#first_name').val(response.first_name);
                            $('#last_name').val(response.last_name);
                            $('#email').val(response.email);
                            $('#phone').val(response.phone);
                            $('#description').text(response.description);
                            var image_path='{{asset(asset_path(''))}}'+response.avatar;
                            $('.customer_img img').attr('src',image_path);
                            $('#avatar_file').val('');
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                            let asset_path = $('#get_asset_path').val();
                            $('#profile_pic').attr('src',asset_path+response.avatar);
                            $('#avatar_preview').attr('src',asset_path+response.avatar);
                            $('#avatar_placeholder').attr('placeholder', "{{__('common.avatar')}}");
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }else{
                                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                            basic_info_update_validate_error(response);
                        }
                    });
                });

                function basic_info_update_validate_error(response){
                    $('.info_error').text('');

                    $('#error_first_name').text(response.responseJSON.errors.first_name);
                    $('#error_email').text(response.responseJSON.errors.email);
                    $('#error_phone').text(response.responseJSON.errors.phone);
                    $('#error_date_of_birth').text(response.responseJSON.errors.date_of_birth);
                    $('#error_avatar').text(response.responseJSON.errors.avatar);
                }

                function basic_info_remove_validate_error(){
                    $('#error_first_name').text('');
                    $('#error_email').text('');
                    $('#error_phone').text('');
                    $('#error_date_of_birth').text('');
                    $('#error_avatar').text('');
                }

                $(document).on('click','.change_password', function(e){
                    e.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('current_password',$('#currentPassword').val());
                    formData.append('new_password',$('#newPass').val());
                    formData.append('new_password_confirmation',$('#rePass').val());
                    $.ajax({
                        url: "{{route('cusotmer.update.password')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('.error').text('');
                            $("#update_pass").trigger("reset");
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }else{
                                $('.error').text('');
                                if (response.responseJSON.errors.current_password) {
                                    $('.validation-old-pass-error').text(response.responseJSON.errors.current_password);
                                }
                                if (response.responseJSON.errors.new_password) {
                                    $('.validation-new-pass-error').text(response.responseJSON.errors.new_password);
                                }
                                if (response.responseJSON.errors.new_password_confirmation) {
                                    $('.validation-new-pass-confirm-error').text(response.responseJSON.errors.new_password_confirmation);
                                }

                                toastr.error("{{__('common.error_message')}}" ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }

                        }
                    });

                });

                $(document).on('click', '.edit_address', function(event){
                    let id = $(this).data('id');
                    editAddress(id);
                });

                function editAddress(c_id){
                    $('#pre-loader').removeClass('d-none');
                    let base_url = $('#url').val();
                    let url = base_url + '/customer/address/edit/'+c_id;
                    $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#address_form_div_edit').html(response);
                            $('#country_edit').niceSelect();
                            $('#state_edit').niceSelect();
                            $('#city_edit').niceSelect();

                            $('#address_list').addClass('d-none');
                            $('#address_form_div_edit').removeClass('d-none');

                            if (response.is_shipping_default==1 || response.is_billing_default==1) {
                                $('#dlt_adrs').addClass('d-none');
                            }
                            else{
                                $('#dlt_adrs').removeClass('d-none');
                            }
                            $('#pre-loader').addClass('d-none');

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error('{{__("common.error_message")}}','{{__("common.error")}}')
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                }

                //address
                $(document).on('click','.add_new_address',function(e){
                    $('#address_list').addClass('d-none');
                    $('.adrs_other_div').addClass('d-none');
                    $('#address_form_div').removeClass('d-none');
                });
                $(document).on('click','#make_dft_shipping',function(e){
                    e.preventDefault();
                    $('#address_list').addClass('d-none');
                    $('.adrs_other_div').addClass('d-none');
                    $('#default_shipping_adrs').removeClass('d-none');

                });
                $(document).on('click','#make_dft_billing',function(e){
                    e.preventDefault();
                    $('#address_list').addClass('d-none');
                    $('.adrs_other_div').addClass('d-none');
                    $('#default_billing_adrs').removeClass('d-none');

                });

                $(document).on('click', '#address_list_tab', function(event){
                    $('.adrs_other_div').addClass('d-none');
                    $('#address_list').removeClass('d-none');
                });

                $(document).on('click','.default_setup_shipping',function(){
                    var c_id= $("input[name='dft_adrs_shipping']:checked").attr('c_id');
                    var c_list_id= $("input[name='dft_adrs_shipping']:checked").attr('c_list_id');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('c_id', c_id);
                    formData.append('c_list_id', c_list_id);
                    $.ajax({
                        url: "{{ route('customer.address.default.shipping') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            console.log(response);

                            $('#address_table').html(response.addressList);
                            $('#default_shipping_adrs').html(response.addressListForShipping);
                            $('#default_billing_adrs').html(response.addressListForBilling);

                            $('#default_shipping_adrs').addClass('d-none');
                            $('#address_list').removeClass('d-none');
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    });
                });

                $(document).on('click','.default_setup_billing',function(){

                    var c_id= $("input[name='dft_adrs_billing']:checked").attr('c_id');
                    var c_list_id= $("input[name='dft_adrs_billing']:checked").attr('c_list_id');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('c_id', c_id);
                    formData.append('c_list_id', c_list_id);
                    $.ajax({
                        url: "{{ route('customer.address.default.billing') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#address_table').html(response.addressList);
                            $('#default_billing_adrs').html(response.addressListForBilling);

                            $('#default_billing_adrs').addClass('d-none');
                            $('#address_list').removeClass('d-none');

                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    });
                });

                //store address
                $(document).on('submit', '#address_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    removeValidateError('#address_form');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    var formElement = $(this).serializeArray()
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    $.ajax({
                        url: "{{ route('customer.address.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#address_table').html(response.addressList);
                            $('#default_shipping_adrs').html(response.addressListForShipping);
                            $('#default_billing_adrs').html(response.addressListForBilling);
                            $('#address_form_div').addClass('d-none');
                            $('#address_list').removeClass('d-none');
                            $('#pre-loader').addClass('d-none');
                            $('#address_form')[0].reset();

                            toastr.success("{{__('common.added_successfully')}}", "{{__('common.success')}}");
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}")
                            showValidateError('#address_form', response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                //update address
                $(document).on('submit', '#address_form_edit', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    removeValidateError('#address_form_edit');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    var formElement = $(this).serializeArray()
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    $.ajax({
                        url: "{{ route('customer.address.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {

                            $('#address_table').html(response.addressList);
                            $('#default_shipping_adrs').html(response.addressListForShipping);
                            $('#default_billing_adrs').html(response.addressListForBilling);
                            $('#address_form_div_edit').addClass('d-none');
                            $('#address_list').removeClass('d-none');

                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }
                            toastr.error('{{__("common.error_message")}}');
                            showValidateError('#address_form_edit', response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit', '#adrs_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#adrs_delete_modal').modal('hide');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    $.ajax({
                        url: "{{ route('customer.address.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if(response == 'is_used'){
                                toastr.error("{{__('common.address_already_used')}}", "{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                            else if(response == 'is_default'){
                                toastr.error("{{__('customer_panel.address_already_set_for_default_shipping_or_billing_change_first')}}", "{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                            else{
                                toastr.success("{{__('common.deleted_successfully')}}");
                                $('#address_table').html(response.addressList);
                                $('#default_shipping_adrs').html(response.addressListForShipping);
                                $('#default_billing_adrs').html(response.addressListForBilling);

                                $('#address_form_div_edit').addClass('d-none');
                                $('#address_list').removeClass('d-none');
                                $('#pre-loader').addClass('d-none');
                            }
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            toastr.error('{{__("common.error_message")}}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('change', '#country', function(event){
                    let country = $('#country').val();
                    $('#pre-loader').removeClass('d-none');
                    if(country){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-state?country_id=' +country;

                        $('#state').empty();

                        $('#state').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#state').niceSelect('update');
                        $('#city').empty();
                        $('#city').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#city').niceSelect('update');
                        $.get(url, function(data){

                            $.each(data, function(index, stateObj) {
                                $('#state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                            });

                            $('#state').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#country_edit', function(event){
                    let country = $('#country_edit').val();
                    $('#pre-loader').removeClass('d-none');
                    if(country){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-state?country_id=' +country;

                        $('#state_edit').empty();

                        $('#state_edit').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#state_edit').niceSelect('update');
                        $('#city_edit').empty();
                        $('#city_edit').append(
                            `<option value="">Select from options</option>`
                        );
                        $('#city_edit').niceSelect('update');
                        $.get(url, function(data){

                            $.each(data, function(index, stateObj) {
                                $('#state_edit').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                            });

                            $('#state_edit').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });


                $(document).on('change', '#state', function(event){
                    let state = $('#state').val();
                    $('#pre-loader').removeClass('d-none');
                    if(state){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-city?state_id=' +state;


                        $('#city').empty();
                        $('#city').append(
                            `<option value="">Select from options</option>`
                        );
                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#city').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#state_edit', function(event){
                    let state = $('#state_edit').val();
                    $('#pre-loader').removeClass('d-none');
                    if(state){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-city?state_id=' +state;


                        $('#city_edit').empty();
                        $('#city_edit').append(
                            `<option value="">Select from options</option>`
                        );
                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#city_edit').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#city_edit').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#avatar_file', function(event){
                    getFileName($(this).val(),'#avatar_placeholder');
                    imageChangeWithFile($(this)[0],'#avatar_preview');
                });

                function showValidateError(formId, errors){
                    $(formId + ' #error_name').text(errors.name);
                    $(formId + ' #error_email').text(errors.email);
                    $(formId + ' #error_phone').text(errors.phone);
                    $(formId + ' #error_address').text(errors.address);
                    $(formId + ' #error_country').text(errors.country);
                    $(formId + ' #error_state').text(errors.state);
                    $(formId + ' #error_city').text(errors.city);
                    $(formId + ' #error_postcode').text(errors.postal_code);
                }

                function removeValidateError(formId){
                    $(formId + ' #error_name').text('');
                    $(formId + ' #error_email').text('');
                    $(formId + ' #error_phone').text('');
                    $(formId + ' #error_address').text('');
                    $(formId + ' #error_country').text('');
                    $(formId + ' #error_state').text('');
                    $(formId + ' #error_city').text('');
                    $(formId + ' #error_postcode').text('');
                }

            });

            $(document).on('click', '.delete_address_btn', function(event){
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#adrs_delete_modal').modal('show');
            });

        })(jQuery);


</script>
@endpush
