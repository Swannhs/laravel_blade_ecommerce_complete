
@if (permissionCheck('wallet_manage'))
    @php
        $wallet_manage_admin = false;
        if(request()->is('wallet/online-recharge-requests') || request()->is('wallet/bank-recharge-requests') || request()->is('wallet/withdraw-requests') != false || request()->is('wallet/recharge-offline-index') || request()->is('wallet/wallet-configuration'))
        {
            $wallet_manage_admin = true;
        }
    @endphp
    <li class="{{ $wallet_manage_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,8)->position }}" data-status="{{ menuManagerCheck(1,8)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $wallet_manage_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-wallet"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('wallet.wallet_manage') }}</span>
            </div>
        </a>
        <ul id="wallet_manage_ul">
            @if (permissionCheck('wallet_recharge.get-data') && menuManagerCheck(2,8,'wallet_recharge.get-data')->status == 1)
                <li data-position="{{ menuManagerCheck(2,8,'wallet_recharge.get-data')->position }}">
                    <a href="{{route('wallet_recharge.index')}}" @if (request()->is('wallet/online-recharge-requests')) class="active" @endif>{{ __('wallet.online_recharge') }}</a>
                </li>
            @endif

            @if (permissionCheck('bank_recharge.index') && menuManagerCheck(2,8,'bank_recharge.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,8,'bank_recharge.index')->position }}">
                    <a href="{{route('bank_recharge.index')}}" @if (request()->is('wallet/bank-recharge-requests')) class="active" @endif>{{ __('wallet.bank_recharge') }}</a>
                </li>
            @endif

            @if (isModuleActive('MultiVendor') && permissionCheck('wallet.withdraw_requests.get_data') && menuManagerCheck(2,8,'wallet.withdraw_requests.get_data')->status == 1)
                <li data-position="{{ menuManagerCheck(2,8,'wallet.withdraw_requests.get_data')->position }}">
                    <a href="{{route('wallet.withdraw_requests')}}" @if (request()->is('wallet/withdraw-requests')) class="active" @endif>{{ __('wallet.withdraw_requests') }}</a>
                </li>
            @endif

            @if (permissionCheck('wallet_recharge.offline_index_get_data') && menuManagerCheck(2,8,'wallet_recharge.offline_index_get_data')->status == 1)
                <li data-position="{{ menuManagerCheck(2,8,'wallet_recharge.offline_index_get_data')->position }}">
                    <a href="{{route('wallet_recharge.offline_index')}}" @if (request()->is('wallet/recharge-offline-index')) class="active" @endif>{{ __('wallet.offline_recharge') }} </a>
                </li>
            @endif
            @if (permissionCheck('wallet.wallet_configuration') && menuManagerCheck(2,8,'wallet.wallet_configuration')->status == 1)
                <li data-position="{{ menuManagerCheck(2,8,'wallet.wallet_configuration')->position }}">
                    <a href="{{route('wallet.wallet_configuration')}}" @if (request()->is('wallet/wallet-configuration')) class="active" @endif>{{ __('common.configuration') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
