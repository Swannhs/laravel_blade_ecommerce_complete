
@if (permissionCheck('payment_gateway.index'))

    <li class="{{request()->is('paymentgateway') ? 'mm-active' :''}} sortable_li" data-position="{{ menuManagerCheck(1,17)->position }}" data-status="{{ menuManagerCheck(1,17)->status }}">
        <a href="{{ route('payment_gateway.index') }}" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="far fa-money-bill-alt"></span>
            </div>
            <div class="nav_title">
                <span>{{__('general_settings.Payment Gateways')}}</span>
            </div>
        </a>
    </li>
@endif

