
@if(isModuleActive('MultiVendor'))
@php
    $my_wallet_route_backend = false;
    if(request()->is('wallet/seller/my-wallet-index') || request()->is('wallet/admin/my-wallet-index') || request()->is('wallet/my-withdraw-requests') || request()->is('wallet/my-wallet-create'))
    {
        $my_wallet_route_backend = true;
    }
@endphp
@if(permissionCheck('my_wallet'))
<li class="{{ $my_wallet_route_backend ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,7)->position }}" data-status="{{ menuManagerCheck(1,7)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $my_wallet_route_backend ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-wallet"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('wallet.my_wallet') }}</span>
        </div>
    </a>
    <ul>
        @if(permissionCheck('my-wallet.index') && menuManagerCheck(2,7,'my-wallet.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,7,'my-wallet.index')->position }}">
            <a href="@if(auth()->user()->role->type == 'superadmin' || auth()->user()->role->type == 'admin' || auth()->user()->role->type == 'staff') {{route('my-wallet.index', 'admin')}} @else {{route('my-wallet.index', 'seller')}} @endif" @if (request()->is('wallet/seller/my-wallet-index') || request()->is('wallet/admin/my-wallet-index') || request()->is('wallet/my-wallet-create')) class="active" @endif>{{ __('common.transactions') }}</a>
        </li>
        @endif
        @if(permissionCheck('my-wallet.withdraw_index') && menuManagerCheck(2,7,'my-wallet.withdraw_index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,7,'my-wallet.withdraw_index')->position }}">
            <a href="{{ route('my-wallet.withdraw_index') }}" @if (request()->is('wallet/my-withdraw-requests')) class="active" @endif>{{ __('wallet.withdraw') }}</a>
        </li>
        @endif
    </ul>
</li>
@endif
@endif

@if(permissionCheck('seller_staff_manage') && isModuleActive('MultiVendor'))
@if (auth()->user()->role->type == 'seller')
    <li class="{{ request()->is('seller/my-staff-create') || request()->is('seller/my-staff') ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,28)->position }}" data-status="{{ menuManagerCheck(1,28)->status }}">
        <a href="{{route('seller.sub_seller.index')}}" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-cog"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('seller.my_staff') }}</span>
            </div>
        </a>
    </li>
@endif
@endif


@if(auth()->user()->role->type == 'seller' && isModuleActive('MultiVendor'))
@if(permissionCheck('seller_product_module'))
@php
    $seller_products = false;
    if(request()->is('seller/product') || request()->is('seller/products/create'))
    {
        $seller_products = true;
    }
@endphp

<li class="{{ $seller_products ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,27)->position }}" data-status="{{ menuManagerCheck(1,27)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $seller_products ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fa fa-product-hunt"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('product.products') }}</span>
        </div>
    </a>
    <ul>
        @if(menuManagerCheck(2,27,'seller.product.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,27,'seller.product.index')->position }}">
            <a href="{{route('seller.product.index', 'seller')}}" @if (request()->is('seller/product') || request()->is('seller/products/create')) class="active" @endif>{{ __('product.my_product_list') }}</a>
        </li>
        @endif
    </ul>
</li>
@endif

@endif
