@extends('backEnd.master')
@section('mainContent')
<div class="row">
    <div class="col-lg-7 col-sm-6 col-xs-12">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row">

                    <div class="col-md-12 mb-20">
                        <div class="box_header_right">
                            <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item mb-2">
                                        <a class="nav-link active show" href="#facebookTab" role="tab" data-toggle="tab"
                                            id="1" aria-selected="true">{{__('auth.facebook')}}</a>
                                    </li>
                                    <li class="nav-item mb-2">
                                        <a class="nav-link" href="#googleTab" role="tab" data-toggle="tab" id="1"
                                            aria-selected="true">{{__('auth.google')}}</a>
                                    </li>
                                    <li class="nav-item mb-2">
                                        <a class="nav-link" href="#twitterTab" role="tab" data-toggle="tab" id="1"
                                            aria-selected="true">{{__('auth.twitter')}}</a>
                                    </li>
                                    <li class="nav-item mb-2">
                                        <a class="nav-link" href="#linkedinTab" role="tab" data-toggle="tab" id="1"
                                            aria-selected="true">{{__('auth.linkedin')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="white_box_30px mb_30">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active show" id="facebookTab">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('auth.facebook') }}
                                                {{ __('common.configuration') }}</h3>
                                        </div>
                                    </div>
                                    <form action="{{ route('generalsetting.social_login_configuration.update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.facebook') }}
                                                        {{ __('auth.client_id') }}</label>
                                                    <input required name="facebook_client_id"
                                                        class="primary_input_field"
                                                        value="{{ env('FACEBOOK_CLIENT_ID') }}"
                                                        placeholder="{{ __('auth.facebook') }} {{ __('auth.client_id') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.facebook') }}
                                                        {{ __('auth.client_secret') }}</label>
                                                    <input required name="facebook_client_secret"
                                                        class="primary_input_field"
                                                        value="{{ env('FACEBOOK_CLIENT_SECRET') }}"
                                                        placeholder="{{ __('auth.facebook') }} {{ __('auth.client_secret') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <input name="facebook_status" type="hidden" id="" value="0">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('common.status') }}</label>
                                                    <label class="switch_toggle" for="checkbox1">
                                                        <input name="facebook_status" type="checkbox" id="checkbox1"
                                                            value="1" @if(app('general_setting')->facebook_status == 1)
                                                        checked @endif>
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="primary_btn_2 mt-2"><i
                                                        class="ti-check"></i>{{__("common.save")}} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane fade " id="googleTab">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('auth.google') }}
                                                {{ __('common.configuration') }}</h3>
                                        </div>
                                    </div>
                                    <form action="{{ route('generalsetting.social_login_configuration.update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.google') }}
                                                        {{ __('auth.client_id') }}</label>
                                                    <input required name="google_client_id" class="primary_input_field"
                                                        value="{{ env('GOOGLE_CLIENT_ID') }}"
                                                        placeholder="{{ __('auth.google') }} {{ __('auth.client_id') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.google') }}
                                                        {{ __('auth.client_secret') }}</label>
                                                    <input required name="google_client_secret"
                                                        class="primary_input_field"
                                                        value="{{ env('GOOGLE_CLIENT_SECRET') }}"
                                                        placeholder="{{ __('auth.google') }} {{ __('auth.client_secret') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <input name="google_status" type="hidden" id="" value="0">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('common.status') }}</label>
                                                    <label class="switch_toggle" for="checkbox2">
                                                        <input name="google_status" type="checkbox" class="checkbox" id="checkbox2"
                                                            value="1" @if(app('general_setting')->google_status == 1)
                                                        checked @endif>
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="primary_btn_2 mt-2"><i
                                                        class="ti-check"></i>{{__("common.save")}} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="twitterTab">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('auth.twitter') }}
                                                {{ __('common.configuration') }}</h3>
                                        </div>
                                    </div>
                                    <form action="{{ route('generalsetting.social_login_configuration.update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.twitter') }}
                                                        {{ __('auth.client_id') }}</label>
                                                    <input required name="twitter_client_id" class="primary_input_field"
                                                        value="{{ env('TWITTER_CLIENT_ID') }}"
                                                        placeholder="{{ __('auth.twitter') }} {{ __('auth.client_id') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.twitter') }}
                                                        {{ __('auth.client_secret') }}</label>
                                                    <input required name="twitter_client_secret"
                                                        class="primary_input_field"
                                                        value="{{ env('TWITTER_CLIENT_SECRET') }}"
                                                        placeholder="{{ __('auth.twitter') }} {{ __('auth.client_secret') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <input name="twitter_status" type="hidden" id="" value="0">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('common.status') }}</label>
                                                    <label class="switch_toggle" for="checkbox3">
                                                        <input name="twitter_status" type="checkbox" id="checkbox3"
                                                            value="1" @if(app('general_setting')->twitter_status == 1)
                                                        checked @endif>
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="primary_btn_2 mt-2"><i
                                                        class="ti-check"></i>{{__("common.save")}} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade " id="linkedinTab">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('auth.linkedin') }}
                                                {{ __('common.configuration') }}</h3>
                                        </div>
                                    </div>
                                    <form action="{{ route('generalsetting.social_login_configuration.update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.linkedin') }}
                                                        {{ __('auth.client_id') }}</label>
                                                    <input required name="linkedin_client_id"
                                                        class="primary_input_field"
                                                        value="{{ env('LINKEDIN_CLIENT_ID') }}"
                                                        placeholder="{{ __('auth.linkedin') }} {{ __('auth.client_id') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('auth.linkedin') }}
                                                        {{ __('auth.client_secret') }}</label>
                                                    <input required name="linkedin_client_secret"
                                                        class="primary_input_field"
                                                        value="{{ env('LINKEDIN_CLIENT_SECRET') }}"
                                                        placeholder="{{ __('auth.linkedin') }} {{ __('auth.client_secret') }}"
                                                        type="text">
                                                    <span class="text-danger" id="edit_name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <input name="linkedin_status" type="hidden" id="" value="0">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('common.status') }}</label>
                                                    <label class="switch_toggle" for="checkbox4">
                                                        <input name="linkedin_status" type="checkbox" id="checkbox4"
                                                            value="1" @if(app('general_setting')->linkedin_status == 1)
                                                        checked @endif>
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="primary_btn_2 mt-2"><i
                                                        class="ti-check"></i>{{__("common.save")}} </button>
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
    </div>
    <div class="col-lg-5">
        <div class="white_box_30px mt-60">
            <div class="box_header common_table_header ">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('general_settings.facebook_messanger') }} {{ __('common.configuration') }}</h3>
                </div>
            </div>
            <form action="{{ route('generalsetting.messangerChat.update') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                for="">{{ __('common.status') }}</label>
                            <label class="switch_toggle" for="messanger_chat_status">
                                <input name="messanger_chat_status" type="checkbox" id="messanger_chat_status"
                                    value="1" @if($messanger_chat->status == 1)checked @endif>
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="code">{{ __('auth.facebook') }} {{ __('general_settings.messager_code') }}</label>
                            
                            <textarea name="code" id="code" cols="30" class="form-control primary_input_field overflow-auto" placeholder="{{ __('general_settings.paste_code_here') }}"
                                rows="10">{{$messanger_chat->code}}</textarea>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-12 text-center">
                        <button class="primary_btn_2 mt-2"><i
                                class="ti-check"></i>{{__("common.save")}} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
    (function($){

        "use strict";
        $(document).ready(function(){
            $(document).on('change','.payment_gateways_activate', function(){
                if(this.checked){
                    var status = 1;
                }
                else{
                    var status = 0;
                }
                $.post('{{ route('update_payment_activation_status') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }
                }).fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                });
            });

            $(document).on('change', '#paypal_logo', function(){
                getFileName($(this).val(),'#thumbnail_image_file');
                imageChangeWithFile($(this)[0],'#ThumbnailImgDiv');
            });

            $(document).on('change', '#logoStripe', function(){
                getFileName($(this).val(),'#logoStripe_file');
                imageChangeWithFile($(this)[0],'#logoStripeDiv');
            });

            $(document).on('change', '#logoPaystack', function(){
                getFileName($(this).val(),'#logoPaystack_file');
                imageChangeWithFile($(this)[0],'#logoPaystackDiv');
            });

            $(document).on('change', '#logoRazor', function(){
                getFileName($(this).val(),'#Razor_file');
                imageChangeWithFile($(this)[0],'#logoRazorDiv');
            });

            $(document).on('change', '#logoPaytm', function(){
                getFileName($(this).val(),'#Paytm_file');
                imageChangeWithFile($(this)[0],'#logoPaytmDiv');
            });

            $(document).on('change', '#logoInstamojo', function(){
                getFileName($(this).val(),'#Instamojo_file');
                imageChangeWithFile($(this)[0],'#logoInstamojoDiv');
            });

            $(document).on('change', '#logoMidtrans', function(){
                getFileName($(this).val(),'#logoMidtrans_file')
                imageChangeWithFile($(this)[0],'#logoMidtransDiv');
            });

            $(document).on('change', '#logoPayUmoney', function(){
                getFileName($(this).val(),'#logoPayUmoney_file');
                imageChangeWithFile($(this)[0],'#logoPayUmoneyDiv');
            });

            $(document).on('change', '#logoJazzCash', function(){
                getFileName($(this).val(),'#JazzCash_file');
                imageChangeWithFile($(this)[0],'#logoJazzCashDiv');
            });

            $(document).on('change', '#logogooglePay', function(){
                getFileName($(this).val(),'#googlePay_file');
                imageChangeWithFile($(this)[0],'#logogooglePayDiv');
            });

            $(document).on('change', '#logoFlutterWave', function(){
                getFileName($(this).val(),'#logoFlutterWave_file');
                imageChangeWithFile($(this)[0],'#logoFlutterWaveDiv');
            });

            $(document).on('change', '#logoPaddle', function(){
                getFileName($(this).val(),'#logoPaddle_file');
                imageChangeWithFile($(this)[0],'#logoPaddleDiv');
            });

            $(document).on('change', '#logobank', function(){
                getFileName($(this).val(),'#bank_image_file');
                imageChangeWithFile($(this)[0],'#BankImgDiv');
            });

        });

    })(jQuery);
</script>
@endpush
