
@if(permissionCheck('backup.index'))
<li class="{{request()->is('backup') ? 'mm-active' :''}} sortable_li" data-position="{{ menuManagerCheck(1,33)->position }}" data-status="{{ menuManagerCheck(1,33)->status }}">
    <a href="{{ route('backup.index') }}" class="" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-file-download"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('general_settings.backup') }}</span>
        </div>
    </a>
</li>
@endif
