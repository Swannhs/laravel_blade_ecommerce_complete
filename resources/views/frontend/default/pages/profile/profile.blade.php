@extends('frontend.default.layouts.app')


@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/profile.css'))}}" />

@endsection

@section('breadcrumb')

{{ __('common.account') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')


            <div class="col-lg-8 col-xl-9 col-md-7">
                <div class="account_details">
                     <ul class="nav nav-tabs amazcart_tabs" id="myTab" role="tablist">
                         <li class="nav-item">
                             <a class="nav-link active" id="Basic-tab" data-toggle="tab" href="#Basic" role="tab" aria-controls="Basic" aria-selected="true">{{__('common.basic_info')}}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" id="Password-tab" data-toggle="tab" href="#Password" role="tab" aria-controls="Password" aria-selected="false">{{__('common.change')}} {{__('common.password')}}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link nav_address" id="Addresses-tab" data-toggle="tab" href="#Addresses" role="tab" aria-controls="Addresses" aria-selected="false">{{__('common.addresses')}}</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link nav_language" id="Language-tab" data-toggle="tab" href="#Languages" role="tab" aria-controls="Languages" aria-selected="false">{{__('common.language')}}</a>
                        </li>
                     </ul>
                     <div class="tab-content" id="myTabContent">
                         <div class="tab-pane fade show active" id="Basic" role="tabpanel" aria-labelledby="Basic-tab">
                             <form action="#" name="basic_info" method="POST" id="basic_info" enctype="multipart/form-data">
                                @csrf
                                 <div class="row footer_reverce ">
                                     <div class="col-lg-8 ">
                                         <div class="form-group col-md-12">
                                             <label for="first_name">{{__('common.first_name')}}</label> <span class="text-red">*</span>
                                             <input type="text" class="form-control" id="first_name" placeholder="{{__('common.first_name')}}" value="{{$user_info->first_name}}" name="first_name">
                                             <span class="validation-name-info-error text-danger info_error" id="error_first_name"></span>

                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="last_name">{{__('common.last_name')}}</label>
                                             <input type="text" class="form-control" id="last_name" placeholder="{{__('common.last_name')}}" value="{{$user_info->last_name}}" name="last_name">
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="email">{{__('common.email_address')}}</label> <span class="text-red">*</span>
                                             <input type="email" class="form-control" id="email" placeholder="{{__('common.email_address')}}" value="{{$user_info->email}}"
                                             name="email">
                                             <span class="validation-email-info-error text-danger info_error" id="error_email"></span>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="phone">{{__('common.phone_number')}}</label>
                                             <input type="text" class="form-control" id="phone" placeholder="{{__('common.phone_number')}}" value="{{$user_info->phone}}"
                                             name="phone">
                                             <span class="text-danger" id="error_phone"></span>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="datepicker">{{__('common.date_of_birth')}}</label>
                                             <input type="text" id="datepicker" class="form-control" placeholder="" value="{{date('m/d/Y',strtotime($user_info->date_of_birth))}}" name="date_of_birth">
                                             <span class="text-danger" id="error_date_of_birth"></span>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="textarea">{{__('common.description')}}</label>
                                             <textarea  id="textarea" placeholder="{{__('common.description')}}" name="description">{{$user_info->description}}</textarea>
                                         </div>
                                         <div class="form_btn col-md-12">
                                             <a href="#" class="btn_1" id="update_info">{{__('common.update')}}</a>
                                         </div>
                                     </div>
                                     <div class="col-lg-4 mb-4">
                                        <span class="text-danger mt-20" id="error_avatar"></span>
                                         <div class="customer_img">
                                             <h5>{{__('common.avatar')}} (165x165)PX</h5>
                                             <img src="{{$user_info->avatar?showImage($user_info->avatar):showImage('frontend/default/img/avatar.jpg')}}" alt="#" id="avaterShow">
                                             <div class="form-group">
                                                 <input type="file" name="file" id="file" class="profile_image">

                                             </div>
                                         </div>

                                     </div>
                                     <span class="text-danger mt-20" id="error_avatar"></span>

                                 </div>
                             </form>
                         </div>
                         <div class="tab-pane fade" id="Password" role="tabpanel" aria-labelledby="Password-tab">
                             <form action="#" name="basic_info" method="POST" id="update_pass">
                                @csrf
                                 <div class="row">
                                     <div class="col-lg-8">
                                         <div class="form-group col-md-12">
                                             <label for="currentPassword">{{__('common.current')}} {{__('common.password')}}</label>
                                             <input type="password" class="form-control" id="currentPassword" placeholder="{{__('common.current')}} {{__('common.password')}}" name="current_password">
                                            <span class="validation-old-pass-error text-danger error" ></span>

                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="Newpass">{{__('common.new')}} {{__('common.password')}}</label>
                                             <input type="password" class="form-control" id="newPass" placeholder="{{__('common.new')}} {{__('common.password')}}" name="newpassword">
                                             <span class="validation-new-pass-error text-danger error"></span>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="repass">{{__('common.re_enter')}} {{__('common.new')}} {{__('common.password')}}</label>
                                             <input type="password" class="form-control" id="rePass" placeholder="{{__('common.re_enter')}} {{__('common.new')}} {{__('common.password')}}" name="new_password_confirmation">
                                            <span class="validation-new-pass-confirm-error text-danger error"></span>
                                         </div>
                                         <div class="form_btn col-md-12 ">
                                             <button class="btn_1 float-left change_password" type="submit">{{__('common.update')}}</button>
                                         </div>
                                     </div>
                                 </div>
                             </form>
                         </div>
                         <div class="tab-pane fade" id="Addresses" role="tabpanel" aria-labelledby="Addresses-tab">
                            <div id="address_list" class="mt-10">
                               <a href="javascript:void(0)" id="make_dft_shipping">{{__('common.make')}} {{__('common.default')}} {{__('defaultTheme.shipping')}} {{__('common.address')}}</a> <span class="dibeider">|</span>
                               <a href="javascript:void(0)" id="make_dft_billing">{{__('common.make')}} {{__('common.default')}} {{__('defaultTheme.billing')}} {{__('common.address')}}</a>
                               <div class="table-responsive">
                                <table class="table table-hover red-header mt-2" id="address_table">
                                        @include('frontend.default.pages.profile.partials._table')
                                </table>
                               </div>
                                <div class="float-left">
                                    <button class="btn_1 add_new_address">{{__('common.add_new')}} {{__('common.address')}}</button>
                                </div>
                            </div>
                            <!-- make default shipping address -->
                            <div class="adrs_other_div d-none mt-10" id="default_shipping_adrs">
                               @include('frontend.default.pages.profile.partials._shipping')
                            </div>
                             <!-- make default billing address -->
                            <div class="adrs_other_div d-none mt-10" id="default_billing_adrs">
                              @include('frontend.default.pages.profile.partials._billing')
                            </div>
                            <div id="address_form_div" class="adrs_other_div d-none">
                             @include('frontend.default.pages.profile.partials._form')
                            </div>
                            <!-- edit -->
                            <div id="address_form_div_edit" class="adrs_other_div d-none">

                            </div>
                         </div>

                         @php
                              $langs = app('langs');
                                $currencies = app('currencies');
                                $locale = app('general_setting')->language_code;
                                $currency_code = app('general_setting')->currency_code;
                                $ship = app('general_setting')->country_name;
                                if(\Session::has('locale')){
                                    $locale = \Session::get('locale');
                                }
                                if(\Session::has('currency')){
                                    $currency = \Modules\GeneralSetting\Entities\Currency::where('id', session()->get('currency'))->first();
                                    $currency_code = $currency->code;
                                }

                                if(auth()->check()){
                                    $currency_code = auth()->user()->currency_code;
                                    $locale = auth()->user()->lang_code;
                                }
                         @endphp
                         <div class="tab-pane fade" id="Languages" role="tabpanel" aria-labelledby="Language-tab">
                            <form action="{{route('frontend.locale')}}" name="basic_info" method="POST">
                               @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>{{ __('defaultTheme.language') }} <span class="text-red">*</span></label>
                                            <select class="form-control nc_select" name="lang" autocomplete="off">
                                            <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                @foreach($langs as $key => $lang)
                                                    <option {{ $locale == $lang->code?'selected':'' }} value="{{$lang->code}}">
                                                    {{$lang->native}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-red" id="error_country"></span>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>{{ __('defaultTheme.currency') }} <span class="text-red">*</span></label>
                                            <select class="form-control nc_select" name="currency" autocomplete="off">
                                            <option value="">{{__('defaultTheme.select_from_options')}}</option>


                                            @foreach($currencies as $key => $item)
                                            <option {{$currency_code==$item->code?'selected':'' }}
                                                value="{{$item->id}}">
                                                {{$item->name}} ({{$item->symbol}})</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <span class="text-red" id="error_country"></span>
                                    </div>
                                    <div class="col-lg-8">
                                        <button type="submit" class="float-left btn_1">{{ __('defaultTheme.save_change') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                     </div>
                </div>
             </div>

        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";

            $(document).ready(function(){
                $('#Addresses-tab').on('click',function(){
                    $('.adrs_other_div').addClass('d-none');
                    $('#address_list').removeClass('d-none');
                });

                $('#datepicker').datepicker({
                    format: 'mm-dd-yyyy'
                });

                $(document).on('click','#update_info',function(e){
                    e.preventDefault();
                    $('#pre-loader').show();
                    var formElement = $('#basic_info').serializeArray();
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");

                    let avatar = $('#file')[0].files[0];
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
                            if(avatar){
                                var image_path="{{asset(asset_path(''))}}" + "/"+response.avatar;
                                $('.customer_img img').attr('src',image_path);
                            }
                            $('#file').val('');
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').hide();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            basic_info_update_validate_error(response);
                            toastr.error("{{__('common.error_message')}}","{{__('common.success')}}");
                            $('#pre-loader').hide();
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
                    $('#pre-loader').show();
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
                            toastr.success(response, "{{__('common.success')}}");
                            $('#pre-loader').hide();

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
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
                            $('#pre-loader').hide();
                        }
                    });

                });

                //address
                $(document).on('click','.add_new_address',function(e){
                    $('#address_list').addClass('d-none');
                    $('#address_form_div').removeClass('d-none');
                });
                $(document).on('click','#make_dft_shipping',function(e){
                    e.preventDefault();
                    $('#address_list').addClass('d-none');
                    $('#default_shipping_adrs').removeClass('d-none');

                });
                $(document).on('click','#make_dft_billing',function(e){
                    e.preventDefault();
                    $('#address_list').addClass('d-none');
                    $('#default_billing_adrs').removeClass('d-none');

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
                    $('#pre-loader').show();
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
                            console.log(response);
                            $('#address_table').html(response.addressList);
                            $('#default_shipping_adrs').html(response.addressListForShipping);
                            $('#default_billing_adrs').html(response.addressListForBilling);
                            $('#address_form_div').addClass('d-none');
                            $('#address_list').removeClass('d-none');
                            $('#pre-loader').hide();
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
                            $('#pre-loader').hide();
                        }
                    });
                });

                //update address
                $(document).on('submit', '#address_form_edit', function(event) {
                    event.preventDefault();
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error('{{__("common.error_message")}}');
                            showValidateError('#address_form_edit', response.responseJSON.errors);
                            $('#pre-loader').hide();
                        }
                    });
                });


                $(document).on('submit', '#adrs_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').show();
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
                                toastr.error("{{__('customer_panel.address_already_used_for_shipping_or_billing_address')}}", "{{__('common.error')}}");
                                $('#pre-loader').hide();
                            }
                            else if(response == 'is_default'){
                                toastr.error("{{__('customer_panel.address_already_set_for_default_shipping_or_billing_change_first')}}", "{{__('common.error')}}");
                                $('#pre-loader').hide();
                            }
                            else{
                                toastr.success("{{__('common.deleted_successfully')}}");
                                $('#address_table').html(response.addressList);
                                $('#default_shipping_adrs').html(response.addressListForShipping);
                                $('#default_billing_adrs').html(response.addressListForBilling);

                                $('#address_form_div_edit').addClass('d-none');
                                $('#address_list').removeClass('d-none');
                                $('#pre-loader').hide();
                            }
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.address_already_used')}}", "{{__('common.error')}}");
                            $('#pre-loader').hide();
                        }
                    });
                });

                $(document).on('change', '#country', function(event){
                    let country = $('#country').val();
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();
                        });
                    }
                });


                $(document).on('change', '#country_edit', function(event){
                    let country = $('#country_edit').val();
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();
                        });
                    }
                });


                $(document).on('change', '#state', function(event){
                    let state = $('#state').val();
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();
                        });
                    }
                });

                $(document).on('change', '#state_edit', function(event){
                    let state = $('#state_edit').val();
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();
                        });
                    }
                });

                $(document).on('change', '.profile_image', function(event){
                    imageChangeWithFile($(this)[0],'#avaterShow');
                });

                $(document).on('click', '.edit_address', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    editAddress(id);
                });

                function editAddress(c_id){
                    $('#pre-loader').show();
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
                            $('#pre-loader').hide();

                        },
                        error: function(response) {
                            toastr.error('{{__("common.error_message")}}','{{__("common.error")}}')
                            $('#pre-loader').hide();
                        }

                    });

                }

                $(document).on('click', '.delete_address_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#adrs_delete_modal').modal('show');
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
        })(jQuery);


    </script>
@endpush
