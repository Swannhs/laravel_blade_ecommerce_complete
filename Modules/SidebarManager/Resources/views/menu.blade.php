@if(permissionCheck('sidebar-manager.index'))
    <li class="{{request()->is('menumanager/index') ? 'mm-active' :''}} sortable_li" data-position="{{ menuManagerCheck(1,25)->position }}" data-status="{{ menuManagerCheck(1,25)->status }}">
        <a href="{{ route('sidebar-manager.index') }}" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-bars"></span>
            </div>
            <div class="nav_title">
                <span>{{__('common.sidebar_manager')}}</span>
            </div>
        </a>
    </li>
@endif
