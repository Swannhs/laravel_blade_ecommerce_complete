@if (permissionCheck('appearance'))
    @php
        $appearance = false;

        if(request()->is('appearance/*') || request()->is('menu/*'))
        {
            $appearance = true;
        }
    @endphp
    <li class="{{ $appearance ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,3)->position }}" data-status="{{ menuManagerCheck(1,3)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $appearance ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-user"></span>
            </div>
            <div class="nav_title">
                <span>{{__('appearance.appearance')}}</span>
            </div>
        </a>
        <ul id="appeanrance_1">
            @if (permissionCheck('appearance.themes.index') && menuManagerCheck(2,3,'appearance.themes.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'appearance.themes.index')->position }}">
                    <a href="{{ route('appearance.themes.index') }}" class="{{request()->is('appearance/themes/*') ? 'active' : ''}}">{{__('appearance.themes')}}</a>
                </li>
            @endif


            @if (permissionCheck('appearance.color.index') && menuManagerCheck(2,3,'appearance.color.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'appearance.color.index')->position }}">
                    <a href="{{ route('appearance.themeColor.index') }}" class="{{request()->is('appearance/theme-color') ? 'active' : ''}}"> {{__('appearance.color')}} {{__('appearance.scheme')}}</a>
                </li>
            @endif

            @if (permissionCheck('menu.manage') && menuManagerCheck(2,3,'menu.manage')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'menu.manage')->position }}">
                    <a href="{{ route('menu.manage') }}" class="@if(request()->is('menu/manage') || request()->is('menu/setup/*')) active @endif">{{__('appearance.menu')}}</a>
            @endif

            @if (permissionCheck('appearance.header.index') && menuManagerCheck(2,3,'appearance.header.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'appearance.header.index')->position }}">
                    <a href="{{ route('appearance.header.index') }}" class="{{request()->is('appearance/headers*') ? 'active' : ''}}">{{__('appearance.header')}}</a>
                </li>
            @endif

            @if (permissionCheck('setup.dashoboard.index') && menuManagerCheck(2,3,'appearance.dashoboard.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'appearance.dashoboard.index')->position }}">
                    <a href="{{ route('appearance.dashoboard.index') }}" @if (request()->is('appearance/dashboard')) class="active" @endif>{{__('setup.dashboard_setup')}}</a>
            @endif

            @if (permissionCheck('appearance.color.index') && menuManagerCheck(2,3,'appearance.color.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,3,'appearance.color.index')->position }}">
                    <a href="{{ route('appearance.color.index') }}" class="{{request()->is('appearance/color') ? 'active' : ''}}">{{__('common.dashboard')}} {{__('appearance.color')}}</a>

                </li>
            @endif
        </ul>
    </li>


@endif
