@php
    $pageBuilder= false;

    if(request()->is('page-builder/*'))
    {
        $pageBuilder = true;
    }
@endphp
<li class="{{ $pageBuilder ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,38)->position }}" data-status="{{ menuManagerCheck(1,38)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $pageBuilder ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-cogs"></span>
        </div>
        <div class="nav_title">
            <span>{{__('page-builder.Page Builder')}}</span>
            @if (config('app.sync'))
                <span class="demo_addons">Addon</span>
            @endif
        </div>
    </a>
    <ul>
        @if(permissionCheck('page_builder.pages.index') && menuManagerCheck(2,38,'page_builder.pages.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,38,'page_builder.pages.index')->position }}">
                <a href="{{route('page_builder.pages.index')}}" class="{{request()->routeIs('page_builder.pages.*') ? 'active' : ''}}">{{__('page-builder.Pages')}}</a>
            </li>
        @endif
    </ul>
</li>
