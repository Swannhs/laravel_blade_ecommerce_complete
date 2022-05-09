<div class="col-xl-3 col-md-5 col-lg-4">
    <div class="dashboard_sidebar">
        <div class="dashboard_menu_item">
            <a href="{{url('/profile/dashboard')}}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
            <a href="{{ route('frontend.my_purchase_order_list') }}"><i class="ti-shopping-cart-full"></i>{{ __('order.my_order') }}</a>
            <a href="{{ route('frontend.purchased-gift-card') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.gift_card') }}</a>
            <a href="{{ route('frontend.digital_product') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.digital_product') }}</a>
            <a href="{{route('frontend.notifications')}}"><i class="ti-bell"></i>{{ __('common.notifications') }}</a>
            <a href="{{route('frontend.my-wishlist')}}"><i class="ti-heart"></i>{{ __('customer_panel.my_wishlist') }}</a>
            <a href="{{route('refund.frontend.index')}}"><i class="ti-reload"></i>{{ __('customer_panel.refund_dispute') }}</a>
            <a href="{{url('/profile/coupons')}}" class=""><i class="ti-receipt"></i>{{ __('customer_panel.my_coupon') }}</a>
            <a href="{{url('/profile')}}"><i class="ti-user"></i>{{ __('customer_panel.my_account') }}</a>
            <a href="{{route('my-wallet.index', 'customer')}}"><i class="ti-wallet"></i>{{ __('wallet.my_wallet') }}</a>
            <a href="{{url('/profile/referral')}}"><i class="ti-user"></i>{{ __('common.referral') }}</a>
            <a href="{{url('/support-ticket')}}"><i class="ti-headphone-alt"></i>{{ __('ticket.support_ticket') }}</a>
            @if(isModuleActive('Affiliate'))
                @if(isAffiliateUser())
                    <a href="{{route('affiliate.my_affiliate.index')}}"><i class="ti-money"></i>
                        {{ __('affiliate.My Affiliate') }}
                        @if (config('app.sync'))
                            <span class="demo_addons">Addon</span>
                        @endif
                    </a>
                @else
                    <a href="{{route('affiliate.users.request')}}"><i class="ti-money"></i>
                        {{ __('affiliate.Join Affiliate Program') }}
                        @if (config('app.sync'))
                            <span class="demo_addons">Addon</span>
                        @endif
                    </a>
                @endif
            @endif
            <a href="{{ route('logout') }}" class="log_out"><i class="ti-shift-right"></i>{{ __('defaultTheme.log_out') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
