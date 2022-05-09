@if(permissionCheck('visitors_setup'))
@php
    $visitor_admin = false;
    if(request()->is('visitor/ignore-ip'))
    {
        $visitor_admin = true;
    }
@endphp
<li class="{{ $visitor_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,24)->position }}" data-status="{{ menuManagerCheck(1,24)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $visitor_admin ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-wrench"></span>
        </div>
        <div class="nav_title">
            <span>{{__('common.visitors_setup')}} </span>
        </div>
    </a>
    <ul class="mm-collapse">
        @if(permissionCheck('ignore_ip_list') && menuManagerCheck(2,24,'ignore_ip_list')->status == 1)
        <li data-position="{{ menuManagerCheck(2,24,'ignore_ip_list')->position }}">
            <a href="{{ route('ignore_ip_list') }}" @if (request()->is('visitor/ignore-ip')) class="active" @endif>{{__('common.ignore_ip')}} </a>
        </li>
        @endif
    </ul>
</li>

@endif
