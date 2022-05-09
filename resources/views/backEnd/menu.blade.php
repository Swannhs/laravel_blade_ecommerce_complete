@if (permissionCheck('human_resource'))
    @php

        $hr = false;
        $attendance = false;
        $events = false;

        if(request()->is('hr/*'))
        {
            $hr = true;
        }
        if(request()->is('attendance/*'))
        {
            $attendance = true;
        }
        if(request()->is('events') || request()->is('events/*'))
        {
            $events = true;
        }

    @endphp

    <li class="{{ $hr || $attendance|| $events ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,23)->position }}" data-status="{{ menuManagerCheck(1,23)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="true">
            <div class="nav_icon_small">
                <span class="fas fa-users"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('hr.human_resource') }}</span>
            </div>
        </a>
        <ul>
            @if (permissionCheck('staffs.index') && menuManagerCheck(2,23,'staffs.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'staffs.index')->position }}">
                    <a href="{{ route('staffs.index') }}" class="{{request()->is('hr/staffs/') || request()->is('hr/staffs/*') ? 'active' : ''}}">{{ __('hr.staff') }}</a>
                </li>
            @endif
            @if (permissionCheck('permission.roles.index') && menuManagerCheck(2,23,'permission.roles.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'permission.roles.index')->position }}">
                    <a href="{{ route('permission.roles.index') }}" class="{{request()->is('hr/role-permission/*') ? 'active' : '/*'}}">{{ __('hr.role') }}</a>
                </li>
            @endif
            @if (permissionCheck('departments.index') && menuManagerCheck(2,23,'departments.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'departments.index')->position }}">
                    <a href="{{ route('departments.index') }}" class="{{request()->is('hr/departments') ? 'active' : ''}}">{{ __('hr.department') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendances.index') && menuManagerCheck(2,23,'attendances.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'attendances.index')->position }}">
                    <a href="{{ route('attendances.index') }}" class="{{request()->is('hr/attendances') ? 'active' : ''}}">{{ __('hr.attendance') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendance_report.index') && menuManagerCheck(2,23,'attendance_report.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'attendance_report.index')->position }}">
                    <a href="{{ route('attendance_report.index') }}" class="{{request()->is('attendance/hr/attendance') ? 'active' : ''}}">{{ __('hr.attendance_report') }}</a>
                </li>
            @endif
            @if (permissionCheck('events.index') && menuManagerCheck(2,23,'events.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'events.index')->position }}">
                    <a href="{{ route('events.index') }}" class="{{request()->is('events') || request()->is('events/*') ? 'active' : ''}}">{{ __('hr.event') }}</a>
                </li>
            @endif
            @if (permissionCheck('holidays.index') && menuManagerCheck(2,23,'holidays.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,23,'holidays.index')->position }}">
                    <a href="{{ route('holidays.index') }}" class="{{request()->is('attendance/holidays') ? 'active' : ''}}">{{ __('hr.holiday_setup') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
