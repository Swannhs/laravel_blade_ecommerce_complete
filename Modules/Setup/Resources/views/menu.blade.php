@if (permissionCheck('setup_module') || permissionCheck('location_manage'))
    @php
        $setup_location_admin = false;
        $setup_admin = false;
        if(request()->is('language') || request()->is('setup/*'))
        {
            $setup_admin = true;
        }
        if (strpos(request()->getUri(),'location') != false) {
            $setup_location_admin = true;
        }
    @endphp
    <li class="{{ $setup_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,18)->position }}" data-status="{{ menuManagerCheck(1,18)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $setup_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-wrench"></span>
            </div>
            <div class="nav_title">
                <span>{{__('setup.setup')}}</span>
            </div>
        </a>
        <ul>
            @include('language::menu')
            
            <li data-position="{{ menuManagerCheck(2,18,'currencies.index')->position }}">
                <a href="{{ route('currencies.index') }}" @if (request()->is('setup/currencies')) class="active" @endif>{{ __('general_settings.currency_list') }}</a>
            </li>

            @if (permissionCheck('tags.index') && menuManagerCheck(2,18,'tags.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,18,'tags.index')->position }}">
                    <a href="{{ route('tags.index') }}" @if (request()->is('setup/tags')) class="active" @endif>{{ __('common.tag') }}</a>
                </li>
            @endif
            @if (permissionCheck('location_manage') && menuManagerCheck(2,18,'location_manage')->status == 1)
                <li class="{{ $setup_location_admin ?'mm-active' : '' }}" data-position="{{ menuManagerCheck(2,18,'location_manage')->position }}">
                    <a href="javascript:void(0)" class="has-arrow" aria-expanded="{{ $setup_location_admin ? 'true' : 'false' }}">
                        <div class="nav_title">
                            <span>{{ __('setup.location') }}</span>
                        </div>
                    </a>
                    <ul class="{{$setup_location_admin ? 'mm-collapse mm-show' : ''}}">
                        @if (permissionCheck('setup.country.index'))
                            <li>
                                <a href="{{route('setup.country.index')}}" @if (request()->is('setup/location/country')) class="active" @endif> {{__('common.country')}}</a>
                            </li>
                        @endif
                        @if (permissionCheck('setup.state.index'))
                            <li>
                                <a href="{{route('setup.state.index')}}" @if (request()->is('setup/location/state')) class="active" @endif> {{__('common.state')}}</a>
                            </li>
                        @endif
                        @if (permissionCheck('setup.city.index'))
                            <li>
                                <a href="{{route('setup.city.index')}}" @if (request()->is('setup/location/city')) class="active" @endif> {{__('common.city')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @include('shipping::menu')
        </ul>
    </li>
@endif

