@php
    $formBuilder= false;

    if(request()->is('form-builder/*'))
    {
        $formBuilder = true;
    }
@endphp
<li class="{{ $formBuilder ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,39)->position }}" data-status="{{ menuManagerCheck(1,39)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $formBuilder ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-cogs"></span>
        </div>
        <div class="nav_title">
            <span>{{__('formBuilder.form_builder')}}</span>
        </div>
    </a>
    <ul>
        @if(permissionCheck('form_builder.forms.index') && menuManagerCheck(2,39,'form_builder.forms.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,39,'form_builder.forms.index')->position }}">
                <a href="{{route('form_builder.forms.index')}}" class="{{request()->routeIs('form_builder.forms.*') ? 'active' : ''}}">{{__('formBuilder.forms')}}</a>
            </li>
        @endif
    </ul>
</li>

