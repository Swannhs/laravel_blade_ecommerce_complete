@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/generalsetting/css/style.css'))}}" />
@endsection
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.personal') }} {{ __('common.notification') }}
                            {{ __('common.setting') }}</h3>
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
                                        <th scope="col">{{ __('hr.event') }}</th>
                                        <th scope="col">{{ __('common.type') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- shortby  -->
                                    </td>
                                    </tr>
                                    @foreach($userNotificationSettings as $userNotificationSetting)
                                    <tr>
                                        <form action="{{route('user.notificationsetting.update',$userNotificationSetting->id)}}" method="POST">
                                            @csrf
                                        <th>{{ $loop->index +1 }}</th>
                                        <td>{{ $userNotificationSetting->notification_setting->event }}</td>
                                        <td>
                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'email'))
                                            <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                <input data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" class="type check{{ $userNotificationSetting->id }}" value="email"
                                                @if (Str::contains($userNotificationSetting->type,'email')) checked @endif
                                                type="checkbox">
                                                <span class="checkmark"></span> &nbsp;Email
                                            </label>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'mobile'))
                                            <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">

                                                <input data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" class="type check{{ $userNotificationSetting->id }}" value="mobile"
                                                @if (Str::contains($userNotificationSetting->type,'mobile')) checked @endif
                                                type="checkbox">
                                                <span class="checkmark"></span> &nbsp;Mobile
                                            </label>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'sms'))
                                            <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                <input data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" class="type check{{ $userNotificationSetting->id }}" value="sms"
                                                @if (Str::contains($userNotificationSetting->type,'sms')) checked @endif
                                                type="checkbox">
                                                <span class="checkmark"></span> &nbsp;Sms
                                            </label>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'system'))
                                            <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                <input data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" class="type check{{ $userNotificationSetting->id }}" value="system"
                                                @if (Str::contains($userNotificationSetting->type,'system')) checked @endif
                                                type="checkbox">
                                                <span class="checkmark"></span> &nbsp;System
                                            </label>
                                            @endif
                                        </td>


                                    </form>
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
@endsection
@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function() {
            $(document).on('change', '.type', function(event){
                let user_notification_setting_id = $(this).data('value');
                let check = "check"+user_notification_setting_id;
                var val = [];
                $('.'+check+':checked').each(function(i){
                val[i] = $(this).val();
                });

                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', user_notification_setting_id);
                    formData.append('type', val);
                $.ajax({
                        url: "{{ route('user.notificationsetting.update','') }}"+"/"+user_notification_setting_id,
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            console.log(response);
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
            });
        });

    })(jQuery);



    </script>

@endpush
