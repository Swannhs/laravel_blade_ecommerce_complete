@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/staff_create.css'))}}" />
@endsection

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ __('common.update') }} {{ __('common.customer') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST" id="staff_addForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('common.basic_info') }}</h3>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.first_name') }} <span
                                            class="text-danger">*</span></label>
                                    <input name="first_name" class="primary_input_field name"
                                        placeholder="{{ __('common.first_name') }}" type="text"
                                        value="{{old('first_name')?old('first_name'):$customer->first_name}}">
                                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.last_name') }}</label>
                                    <input name="last_name" class="primary_input_field name"
                                        placeholder="{{ __('common.last_name') }}" type="text"
                                        value="{{old('last_name')?old('last_name'):$customer->last_name}}">
                                    <span class="text-danger">{{$errors->first('last_name')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.email_or_phone') }} <span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field user_id name"
                                        placeholder="{{ __('common.email_or_phone') }}" type="text" value="@if(old('email')) {{old('email')}} @else {{$customer->email?$customer->email:$customer->username}} @endif">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                                <p class="text-danger user_id_row d-none">{{__('common.your_user_id_is')}} : <span
                                        class="generated_user_id"></span></p>
                            </div>
                            

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.password') }}
                                        ({{__('common.minimum_8_charecter')}})</label>
                                    <input name="password" class="primary_input_field name"
                                        placeholder="{{ __('common.password') }}" value="{{old('password')}}" type="password" minlength="8">
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.confirm_password') }}</label>
                                    <input name="password_confirmation" class="primary_input_field name"
                                        placeholder="{{ __('common.confirm_password') }}" type="password" minlength="8">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                    <ul id="theme_nav" class="permission_list sms_list ">
                                        <li>
                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                                <input name="status" id="status_active" value="1" {{$customer->is_active == 1?'checked':''}} class="active"
                                                    type="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('common.active') }}</p>
                                        </li>
                                        <li>
                                            <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                                <input name="status" value="0" id="status_inactive" class="de_active" type="radio" {{$customer->is_active == 0?'checked':''}}>
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('common.inactive') }}</p>
                                        </li>
                                    </ul>
                                    <span class="text-danger" id="error_status"></span>
                                </div>
                            </div>
                            

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                        id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
            

        });

    })(jQuery);

</script>
@endpush
