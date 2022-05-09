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
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.system') }} {{ __('common.notification') }}
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
                                        <th scope="col">{{ __('common.message') }}</th>
                                        <th scope="col">{{ __('common.action')  }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- shortby  -->
                                    </td>
                                    </tr>
                                    @foreach($notificationSettings as $notificationSetting)
                                        @if(!$notificationSetting->module or isModuleActive($notificationSetting->module))
                                        <tr>
                                            <th>{{ $loop->index +1 }}</th>
                                            <td>{{ $notificationSetting->event }}</td>
                                            <td>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'email')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;Email
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'mobile')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;Mobile
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'sms')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;Sms
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'system')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;System
                                                </label>
                                            </td>
                                            <td>{{ $notificationSetting->message }}</td>
                                            <td>
                                                @if(permissionCheck('notificationsetting.edit'))
                                                    <button data-value="{{$notificationSetting}}" class="primary-btn radius_30px mr-10 fix-gr-bg edit_notification" >{{ __('common.edit') }}</button>
                                                @endif
                                            </td>
                                        </tr>

                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('generalsetting::notifications.edit_modal')
</section>
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '.edit_notification', function(event){
                    let notification = $(this).data('value');
                    $('#event').val(notification.event);
                    if(notification.type.includes('email')){
                        $('#notification_email').attr('checked',true);
                    }else{
                        $('#notification_email').removeAttr('checked');
                    }
                    if(notification.type.includes('mobile')){
                        $('#notification_mobile').attr('checked',true);
                    }else{
                        $('#notification_mobile').removeAttr('checked');
                    }
                    if(notification.type.includes('system')){
                        $('#notification_system').attr('checked',true);
                    }else{
                        $('#notification_system').removeAttr('checked');
                    }
                    if(notification.type.includes('sms')){
                        $('#notification_sms').attr('checked',true);
                    }else{
                        $('#notification_sms').removeAttr('checked');
                    }
                    $('#message').text(notification.message);
                    let route = "{{ route('notificationsetting.update',':id')}}";
                    route = route.replace(':id', notification.id);
                    $('#edit_form').attr('action',route);
                    $('#edit_modal').modal('show');
                });
            });
        })(jQuery);
    </script>
@endpush
