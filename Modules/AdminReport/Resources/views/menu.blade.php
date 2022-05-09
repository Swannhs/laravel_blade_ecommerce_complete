
@if (permissionCheck('admin_report'))
    @php
    $report_admin = false;
    if(request()->is('admin-report/*')){
        $report_admin = true;
    }
    @endphp
<li class="{{ $report_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,31)->position }}" data-status="{{ menuManagerCheck(1,31)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $report_admin ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="ti-agenda"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('report.admin_reports') }}</span>
        </div>
    </a>
    <ul id="admin_report_ul">
        @if(permissionCheck('report.seller_wise_sales') && menuManagerCheck(2,31, 'report.seller_wise_sales')->status == 1 && isModuleActive('MultiVendor'))
        <li data-position="{{ menuManagerCheck(2,31,'report.seller_wise_sales')->position }}">
            <a href="{{ route('report.seller_wise_sales') }}" @if (strpos(request()->getUri(),'seller-wise-sale-report') != false) class="active" @endif>{{ __('report.seller_wise_sales') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.user_searches') && menuManagerCheck(2,31, 'report.user_searches')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.user_searches')->position }}">
            <a href="{{ route('report.user_searches') }}" @if (strpos(request()->getUri(),'user-searches-keyword') != false) class="active" @endif>{{ __('report.keywords') }} {{ __('report.search') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.visitor_report') && menuManagerCheck(2,31, 'report.visitor_report')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.visitor_report')->position }}">
            <a href="{{ route('report.visitor_report') }}" @if (strpos(request()->getUri(),'visitor-report') != false)
                class="active" @endif>{{ __('report.visitor') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.inhouse_product_sale') && menuManagerCheck(2,31, 'report.inhouse_product_sale')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.inhouse_product_sale')->position }}">
            <a href="{{ route('report.inhouse_product_sale') }}" @if (strpos(request()->getUri(),'inhouse-product-sale') != false)
                class="active" @endif>{{ __('report.inhouse_product_sale') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.product_stock') && menuManagerCheck(2,31, 'report.product_stock')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.product_stock')->position }}">
            <a href="{{ route('report.product_stock') }}" @if (strpos(request()->getUri(),'product-stock') != false)
                class="active" @endif>{{ __('report.product_stock') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.wishlist') && menuManagerCheck(2,31, 'report.wishlist')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.wishlist')->position }}">
            <a href="{{ route('report.wishlist') }}" @if (strpos(request()->getUri(),'wishlist') != false)
                class="active" @endif>{{ __('defaultTheme.wishlist') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.wallet_recharge_history') && menuManagerCheck(2,31, 'report.wallet_recharge_history')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.wallet_recharge_history')->position }}">
            <a href="{{ route('report.wallet_recharge_history') }}" @if (strpos(request()->getUri(),'/wallet-recharge-history') != false)
                class="active" @endif>{{ __('report.wallet_recharge_history') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.top_seller') && menuManagerCheck(2,31, 'report.top_seller')->status == 1 && isModuleActive('MultiVendor'))
        <li data-position="{{ menuManagerCheck(2,31,'report.top_seller')->position }}">
            <a href="{{ route('report.top_seller') }}" @if (strpos(request()->getUri(),'top-seller') != false)
                class="active" @endif>{{ __('dashboard.top_sellers') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.top_customer') && menuManagerCheck(2,31, 'report.top_customer')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.top_customer')->position }}">
            <a href="{{ route('report.top_customer') }}" @if (strpos(request()->getUri(),'top-customer') != false)
                class="active" @endif>{{ __('dashboard.top_customers') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.top_selling_item') && menuManagerCheck(2,31, 'report.top_selling_item')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.top_selling_item')->position }}">
            <a href="{{ route('report.top_selling_item') }}" @if (strpos(request()->getUri(),'top-selling-item') != false)
                class="active" @endif>{{ __('report.top_selling_item') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.order') && menuManagerCheck(2,31, 'report.order')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.order')->position }}">
            <a href="{{ route('report.order') }}" @if (strpos(request()->getUri(),'order') != false)
                class="active" @endif>{{ __('common.order') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.payment') && menuManagerCheck(2,31, 'report.payment')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.payment')->position }}">
            <a href="{{ route('report.payment') }}" @if (strpos(request()->getUri(),'payment') != false)
                class="active" @endif>{{ __('common.payment') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.product_review') && menuManagerCheck(2,31, 'report.product_review')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.product_review')->position }}">
            <a href="{{ route('report.product_review') }}" @if (strpos(request()->getUri(),'product-review') != false)
                class="active" @endif>{{ __('common.product') }} {{ __('review.review') }}</a>
        </li>
        @endif
        @if(permissionCheck('report.seller_review') && menuManagerCheck(2,31, 'report.seller_review')->status == 1)
        <li data-position="{{ menuManagerCheck(2,31,'report.seller_review')->position }}">
            <a href="{{ route('report.seller_review') }}" @if (strpos(request()->getUri(),'seller-review') != false)
                class="active" @endif>@if(isModuleActive('MultiVendor')){{ __('review.seller_review') }}@else {{ __('review.company_review') }} @endif</a>
        </li>
        @endif
    </ul>
</li>
@endif


