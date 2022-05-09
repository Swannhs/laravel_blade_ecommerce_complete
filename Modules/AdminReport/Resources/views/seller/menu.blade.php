@if(permissionCheck('seller_report') && auth()->user()->role->type == 'seller' && isModuleActive('MultiVendor'))
@php
    $report_seller = false;
    if(request()->is('seller-report/*'))
    {
        $report_seller = true;
    }
@endphp
<li class="{{ $report_seller ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,32)->position }}" data-status="{{ menuManagerCheck(1,32)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $report_seller ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="ti-agenda"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('report.my_reports') }}</span>
        </div>
    </a>
    <ul id="seller_report_ul">
        
        @if(permissionCheck('seller_report.product'))
            @if(menuManagerCheck(2,32,'seller_report.product')->status == 1)
                <li data-position="{{ menuManagerCheck(2,32,'seller_report.product')->position }}">
                    <a href="{{ route('seller_report.product') }}" @if (strpos(request()->getUri(),'product') != false)
                        class="active" @endif>{{ __('common.product') }}</a>
                </li>
            @endif
        @endif
        @if(permissionCheck('seller_report.top_customer'))
            @if(menuManagerCheck(2,32,'seller_report.top_customer')->status == 1)
                <li data-position="{{ menuManagerCheck(2,32,'seller_report.top_customer')->position }}">
                    <a href="{{ route('seller_report.top_customer') }}" @if (strpos(request()->getUri(),'top-customer') != false)
                        class="active" @endif>{{ __('dashboard.top_customers') }}</a>
                </li>
            @endif
        @endif
        @if(permissionCheck('seller_report.top_selling_item') && menuManagerCheck(2,32, 'seller_report.top_selling_item')->status == 1)
        <li data-position="{{ menuManagerCheck(2,32,'seller_report.top_selling_item')->position }}">
            <a href="{{ route('seller_report.top_selling_item') }}" @if (strpos(request()->getUri(),'top-selling-item') != false)
                class="active" @endif>{{ __('report.top_selling_item') }}</a>
        </li>
        @endif
        @if(permissionCheck('seller_report.order') && menuManagerCheck(2,32, 'seller_report.order')->status == 1)
        <li data-position="{{ menuManagerCheck(2,32,'seller_report.order')->position }}">
            <a href="{{ route('seller_report.order') }}" @if (strpos(request()->getUri(),'order') != false)
                class="active" @endif>{{ __('common.order') }}</a>
        </li>
        @endif
        @if(permissionCheck('seller_report.review') && menuManagerCheck(2,32, 'seller_report.review')->status == 1)
        <li data-position="{{ menuManagerCheck(2,32,'seller_report.review')->position }}">
            <a href="{{ route('seller_report.review') }}" @if (strpos(request()->getUri(),'review') != false)
                class="active" @endif> {{ __('review.review') }}</a>
        </li>
        @endif
    </ul>
</li>
@endif
