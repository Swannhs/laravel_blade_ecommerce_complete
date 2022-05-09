@if(permissionCheck('review_module'))
@php
    $review_backend = false;
    if(request()->is('review/*') || request()->is('seller/product-reviews') || request()->is('seller/my-reviews') || request()->is('review/review_configuration'))
    {
        $review_backend = true;
    }
@endphp
<li class="{{ $review_backend ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,13)->position }}" data-status="{{ menuManagerCheck(1,13)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $review_backend ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-user"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('review.review') }}</span>
        </div>
    </a>
    <ul id="review_ul">
        @if (auth()->check() && auth()->user()->role->type == "superadmin" ||  auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @if (permissionCheck('review.product.index') && menuManagerCheck(2,13,'review.product.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,13,'review.product.index')->position }}">
                    <a href="{{ route('review.product.index') }}" @if (request()->is('review/product-list')) class="active"
                        @endif>{{ __('review.product_review') }}</a>
                </li>
            @endif
            @if (permissionCheck('review.seller.index') && menuManagerCheck(2,13,'review.seller.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,13,'review.seller.index')->position }}">
                    <a href="{{route('review.seller.index')}}" @if (request()->is('review/seller-list')) class="active"
                        @endif>@if(isModuleActive('MultiVendor')){{ __('review.seller_review') }}@else {{ __('review.company_review') }} @endif</a>
                </li>
            @endif

            @if(permissionCheck('review.review_configuration') && menuManagerCheck(2,13,'review.review_configuration')->status == 1)
                <li data-position="{{ menuManagerCheck(2,13,'review.review_configuration')->position }}">
                    <a href="{{route('review.review_configuration')}}" @if (request()->is('review/review_configuration')) class="active"
                        @endif>{{ __('review.review') }} {{ __('common.configuration') }}</a>
                </li>
            @endif

        @endif

        @if (auth()->user()->role->type == "seller" && isModuleActive('MultiVendor'))
            @if(permissionCheck('seller.product-reviews.index') && menuManagerCheck(2,13,'seller.product-reviews.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,13,'seller.product-reviews.index')->position }}">
                    <a href="{{route('seller.product-reviews.index')}}" @if (request()->is('seller/product-reviews'))
                        class="active" @endif>{{ __('review.my_product_review') }}</a>
                </li>
            @endif

            @if(permissionCheck('my-reviews.index') && menuManagerCheck(2,13,'my-reviews.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,13,'my-reviews.index')->position }}">
                    <a href="{{route('seller.my-reviews.index')}}" @if (request()->is('seller/my-reviews')) class="active"
                        @endif>{{ __('review.my_review') }}</a>
                </li>
            @endif
        @endif
        
    </ul>
</li>
@endif
