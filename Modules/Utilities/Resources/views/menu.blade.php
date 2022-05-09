@if(permissionCheck('utilities.index'))
    <li class="{{request()->is('utilities') ? 'mm-active' :''}} sortable_li" data-position="{{ menuManagerCheck(1,35)->position }}" data-status="{{ menuManagerCheck(1,35)->status }}">
        <a href="{{ route('utilities.index') }}" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="ti-lock"></span>
            </div>
            <div class="nav_title">
                <span>{{__('utilities.utilities')}}</span>
            </div>
        </a>
    </li>
@endif
