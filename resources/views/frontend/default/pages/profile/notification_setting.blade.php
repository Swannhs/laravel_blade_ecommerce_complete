@extends('frontend.default.layouts.app')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/notification.css'))}}" />

@section('breadcrumb')
{{ __('common.notifications') }} {{ __('common.setting') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="coupons_item">
                    <div class="single_coupons_item cart_part">
                        <table class="table table-hover red-header tablesaw-stack" data-tablesaw-mode="stack">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('common.sl') }}</th>
                                    <th scope="col">{{ __('hr.event') }}</th>
                                    <th scope="col">{{ __('common.type') }}</th>

                                </tr>
                            </thead>
                            <tbody class="cart_table_body">
                                @foreach ($userNotificationSettings as $userNotificationSetting)
                                <tr>
                                    <form action="{{route('frontend.notification_setting.update',$userNotificationSetting->id)}}"
                                        method="POST">
                                        @csrf
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $userNotificationSetting->notification_setting->event }}</td>
                                        <td>

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'email'))
                                            <input class="type check{{ $userNotificationSetting->id }}" data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" value="email" @if (Str::contains($userNotificationSetting->type,'email')) checked @endif
                                            type="checkbox">
                                            <span class="checkmark"></span> Email <br>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'mobile'))
                                            <input class="type check{{ $userNotificationSetting->id }}" data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" value="mobile" @if (Str::contains($userNotificationSetting->type,'mobile')) checked @endif
                                            type="checkbox">
                                            <span class="checkmark"></span> Mobile <br>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'sms'))
                                            <input class="type check{{ $userNotificationSetting->id }}" data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" value="sms" @if (Str::contains($userNotificationSetting->type,'sms')) checked @endif
                                            type="checkbox">
                                            <span class="checkmark"></span> Sms <br>
                                            @endif

                                            @if (Str::contains($userNotificationSetting->notification_setting->type,'system'))
                                            <input class="type check{{ $userNotificationSetting->id }}" data-value="{{ $userNotificationSetting->id }}" name="type[]" id="status" value="system" @if (Str::contains($userNotificationSetting->type,'system')) checked @endif
                                            type="checkbox">
                                            <span class="checkmark"></span> System <br>
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

                $('#pre-loader').show();
                var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', user_notification_setting_id);
                    formData.append('type', val);
                $.ajax({
                        url: "{{ route('frontend.notification_setting.update','') }}"+"/"+user_notification_setting_id,
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            console.log(response);
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').hide();
                        },
                        error: function(response) {

                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#pre-loader').hide();
                        }
                    });
            });
        });

    })(jQuery);



    </script>

@endpush
