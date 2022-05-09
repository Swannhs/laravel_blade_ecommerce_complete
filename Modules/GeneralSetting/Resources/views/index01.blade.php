@extends('generalsetting::layouts.master')

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ __('general_settings.general_settings') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- myTab  -->
                            <div class="white_box_30px mb_30">
                                <ul class="nav custom_nav" id="myTab" role="tablist">
                                    @if (permissionCheck('activations'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ !isset($company) && !session()->has('g_set') && !session()->has('smtp_set') && !session()->has('sms_set') ? 'active ' : '' }}"
                                            id="activation-tab" data-toggle="tab" href="#Activation" role="tab"
                                            aria-controls="home"
                                            aria-selected="true">{{ __('general_settings.activation') }}</a>
                                    </li>
                                    @endif

                                    @if (permissionCheck('general_info'))
                                    <li class="nav-item">
                                        <a class="nav-link @if(session()->has('g_set')) active show @endif"
                                            id="General-tab" data-toggle="tab" href="#General" role="tab"
                                            aria-controls="home"
                                            aria-selected="true">{{ __('general_settings.general') }}</a>
                                    </li>
                                    @endif

                                    @if (permissionCheck('company_info'))
                                    <li class="nav-item">
                                        <a class="nav-link {{isset($company) ? 'active show' : ''}}"
                                            id="Company_Information-tab" data-toggle="tab" href="#Company_Information"
                                            role="tab" aria-controls="Company_Information"
                                            aria-selected="false">{{__('general_settings.company_information')}}</a>
                                    </li>
                                    @endif

                                    @if (permissionCheck('smtp_info'))
                                    <li class="nav-item">
                                        <a class="nav-link @if(session()->has('smtp_set')) active show @endif"
                                            id="SMTP-tab" data-toggle="tab" href="#SMTP" role="tab"
                                            aria-controls="contact"
                                            aria-selected="false">{{ __('general_settings.SMTP') }}</a>
                                    </li>
                                    @endif

                                    @if (permissionCheck('sms_info'))
                                    <li class="nav-item">
                                        <a class="nav-link @if(session()->has('sms_set')) active show @endif"
                                            id="SMS-tab" data-toggle="tab" href="#SMS" role="tab"
                                            aria-controls="contact"
                                            aria-selected="false">{{ __('general_settings.SMS') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <!-- tab-content  -->
                            <div class="tab-content " id="myTabContent">
                                @if (permissionCheck('activations'))
                                <!-- General -->
                                <div class="tab-pane fade white_box_30px {{isset($company) || session()->has('g_set') || session()->has('smtp_set') || session()->has('sms_set') ? '' : 'active show'}}"
                                    id="Activation" role="tabpanel" aria-labelledby="Activation-tab">
                                    @include('generalsetting::page_components.activation')
                                </div>
                                @endif
                                @if (permissionCheck('general_info'))
                                <!-- General -->
                                <div class="tab-pane fade white_box_30px @if(session()->has('g_set')) active show @endif"
                                    id="General" role="tabpanel" aria-labelledby="General-tab">
                                    @include('generalsetting::page_components.general_settings')
                                </div>
                                @endif
                                @if (permissionCheck('company_info'))
                                <!-- Company_Information  -->
                                <div class="tab-pane fade white_box_30px {{isset($company) ? 'active show' : ''}}"
                                    id="Company_Information" role="tabpanel" aria-labelledby="Company_Information-tab">
                                    @include('generalsetting::page_components.company_info_settings')
                                </div>
                                @endif
                                @if (permissionCheck('smtp_info'))
                                <!-- SMTP  -->
                                @include('generalsetting::page_components.smtp_setting')
                                @endif
                                @if (permissionCheck('sms_info'))
                                <!-- SMS  -->
                                <div class="tab-pane fade white_box_30px @if(session()->has('sms_set')) active show @endif"
                                    id="SMS" role="tabpanel" aria-labelledby="SMS-tab">
                                    @include('generalsetting::page_components.sms_settings')
                                </div>
                                @endif
                            </div>
                        </div>
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
    $(document).ready(function() {
            smtp_form();
            $('.summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 500,
                codeviewFilter: true,
			    codeviewIframeFilter: true
		    });
        });

        $(document).on('change','.activations', function(){
            if(this.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('update_activation_status') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                if(data == 1){
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                }
                else{
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                }
            }).fail(function(response) {
               if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }

            });
        });

        $(document).on('change','.smtp_form', function(){
            smtp_form();
        });

        function smtp_form()
        {
            var mail_mailer = $('#mail_mailer').val();
            if (mail_mailer == 'smtp') {
                $('#sendmail').hide();
                $('#smtp').show();
            }
            else if (mail_mailer == 'sendmail') {
                $('#smtp').hide();
                $('#sendmail').show();
            }
        }

        $(document).on('click','.company_info_form_submit', function(){
            var company_name = $('#site_title').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var vat_number = $('#vat_number').val();
            var address = $('#address').val();
            var country_name = $('#country_name').val();
            var zip_code = $('#zip_code').val();
            var company_info = $('#company_info').val();
            var status = 1;
            $.post('{{ route('company_information_update') }}', {_token:'{{ csrf_token() }}',status:status, phone:phone, company_name:company_name, email:email, vat_number:vat_number, address:address, country_name:country_name, zip_code:zip_code, company_info:company_info}, function(data){
                if(data == 1){
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                }
                else{
                   toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                }
            }).fail(function(response) {
               if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }

            });
        });
</script>
@endpush
