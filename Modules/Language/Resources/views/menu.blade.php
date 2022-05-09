@if (permissionCheck('languages.index') && menuManagerCheck(2,18,'languages.index')->status == 1)
    <li data-position="{{ menuManagerCheck(2,18,'languages.index')->position }}">
        <a href="{{ route('languages.index') }}" @if (request()->is('setup/language')) class="active" @endif>{{ __('language.Language Settings') }}</a>
    </li>
@endif
