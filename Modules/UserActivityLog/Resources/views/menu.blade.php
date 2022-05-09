@if(permissionCheck('activity_logs'))
@php
    $activity_log_admin = false;
    if(strpos(request()->getUri(),'useractivitylog') != false)
    {
        $activity_log_admin = true;
    }
@endphp
<li class="{{ $activity_log_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,22)->position }}" data-status="{{ menuManagerCheck(1,22)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $activity_log_admin ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-clock-o"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('common.all_activity_logs') }}</span>
        </div>
    </a>
    <ul id="all_activity_ul">
        @if(permissionCheck('activity_log') && menuManagerCheck(2,22,'activity_log')->status == 1)
        <li data-position="{{ menuManagerCheck(2,22,'activity_log')->position }}">
            <a href="{{route('activity_log')}}" @if (request()->is('useractivitylog')) class="active" @endif>{{ __('common.activity_logs') }}</a>
        </li>
        @endif
        @if(permissionCheck('activity_log.login') && menuManagerCheck(2,22,'activity_log.login')->status == 1)
        <li data-position="{{ menuManagerCheck(2,22,'activity_log.login')->position }}">
            <a href="{{ route('activity_log.login') }}" @if (request()->is('useractivitylog/user-login')) class="active" @endif>{{ __('common.login_activity') }}</a>
        </li>
        @endif
    </ul>
</li>
@endif
