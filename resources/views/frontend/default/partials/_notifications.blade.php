@php
$notifications =
Modules\OrderManage\Entities\CustomerNotification::where('customer_id',Auth::id())->where('read_status',0)->latest()->take(4)->get();

@endphp

<a href="javascript:void(0);" class="cart_menu_item">
    <i class="ti-bell"></i> {{ __('common.notification') }}</a>
<div class="cart_iner notifica_menu">
    @foreach ($notifications as $notification)
    <a href="{{$notification->url ?? '#'}}">
        <p class="notification-margin">{{$notification->title}}</p>
    </a><br>
    @endforeach
    <div class="select_option_list">
        @if (count($notifications) > 0)
        <a href="{{route('frontend.notifications')}}" class="btn_1">{{ __('common.view_all') }}</a>
        <div class="margintop"><a href="{{route('frontend.mark_as_read')}}" class="btn_1">{{ __('defaultTheme.mark_all_as_read') }}</a></div>
        @endif
        <div class="margintop marginbottom"><a href="{{route('frontend.notification_setting')}}" class="btn_1">{{ __('common.notification') }} {{ __('common.setting') }}</a></div>
    </div>

</div>
