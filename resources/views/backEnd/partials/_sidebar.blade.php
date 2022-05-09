<!-- sidebar part here -->

<nav id="sidebar" class="sidebar">
    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{ url('/login') }}">
            <img src="{{showImage(app('general_setting')->logo)}}" alt="">
        </a>
        <a class="mini_logo" href="{{ url('/login') }}">
            <img src="{{showImage(app('general_setting')->favicon)}}" alt="">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>
    <ul id="sidebar_menu">

        @if(permissionCheck('admin.dashboard'))
            <li class="{{ request()->is('admin-dashboard') || request()->is('seller/dashboard') ?'mm-active' : '' }} sortable_li"
                data-position="{{ menuManagerCheck(1,1)->position }}" data-status="{{ menuManagerCheck(1,1)->status }}">

                <a @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff") href="{{ route('admin.dashboard') }}"  @endif aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-th"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('common.dashboard') }}</span>
                    </div>
                </a>
            </li>
        @endif

        @if(permissionCheck('seller.dashboard') && auth()->user()->role->type == 'seller' && isModuleActive('MultiVendor'))
            <li class="{{ request()->is('seller/dashboard') ?'mm-active' : '' }} sortable_li"
                data-position="{{ menuManagerCheck(1,34)->position }}" data-status="{{ menuManagerCheck(1,34)->status }}">
                <a href="{{ route('seller.dashboard') }}" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-th"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('common.dashboard') }}</span>
                    </div>
                </a>
            </li>
        @endif



        @if(isModuleActive('MultiVendor'))
            @include('multivendor::menu')
        @endif

        @if(isModuleActive('Lead'))
            @include('lead::menu')
        @endif

        @include('adminreport::seller.menu')


        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @include('frontendcms::menu')
            @include('appearance::menu')
            @include('blog::menu')
            @include('customer::menu')
        @endif

        @include('seller::menu')
        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @include('wallet::menu')
            @include('contactrequest::menu')
        @endif
        @include('marketing::menu')

        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @include('giftcard::menu')
        @endif

        @if(isModuleActive("Affiliate") && permissionCheck('affiliate'))
            @include('affiliate::menu')
        @endif

        @if(isModuleActive('Affiliate') && permissionCheck('page_builder'))
            @include('pagebuilder::menu')
        @endif

        @if(permissionCheck('form_builder'))
            @include('formbuilder::menu')
        @endif

        @include('product::menu')
        @include('review::menu')
        @include('ordermanage::menu')
        @include('refund::menu')
        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @include('generalsetting::menu')
            @include('paymentgateway::menu')
            @include('setup::menu')
            @if (file_exists(base_path().'/Modules/GST/'))
                @include('gst::menu')
            @endif
            @include('account::menu')
        @endif

        @include('sidebarmanager::menu')
        @if(isModuleActive('Otp'))
            @include('otp::menu')
        @endif
        @include('utilities::menu')


        @include('supportticket::menu')
        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @include('useractivitylog::menu')
            @include('backEnd.menu')
            @include('visitor::menu')
            @include('adminreport::menu')
            @include('backup::menu')
        @endif

        @if(permissionCheck('seller_subscription_payment') && isModuleActive('MultiVendor'))
            @if (auth()->check() && auth()->user()->role->type == "seller")
                <li class="{{ request()->is('seller/my-subscription-payment-list') ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,29)->position }}" data-status="{{ menuManagerCheck(1,29)->status }}">
                    <a class="" href="{{ route('seller.my_subscription_payment_list') }}" aria-expanded="false">
                        <div class="nav_icon_small">
                            <span class="fas fa-th"></span>
                        </div>
                        <div class="nav_title">
                            <span>{{ __('common.subscription_payment') }}</span>
                        </div>
                    </a>
                </li>
            @endif
        @endif




        @if(permissionCheck('customer_panel') && isModuleActive('MultiVendor'))

        @php
            $customer_backkend = false;
            if(strpos(request()->getUri(),'my-purchase-orders') != false || strpos(request()->getUri(),'purchased-gift-cards') != false || strpos(request()->getUri(),'my-wishlist') != false || request()->is('refund/my-refund-list') || request()->is('digital-products') || request()->is('profile/coupons') || request()->is('profile/referral') || request()->is('profile'))
            {
                $customer_backkend = true;
            }
        @endphp

        <li class="{{ $customer_backkend ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,26)->position }}" data-status="{{ menuManagerCheck(1,26)->status }}">
            <a href="javascript:;" class="has-arrow" aria-expanded="{{ $customer_backkend ? 'true' : 'false' }}">
                <div class="nav_icon_small">
                    <span class="fas fa-th"></span>
                </div>
                <div class="nav_title">
                    <span>{{__('customer_panel.customer_panel')}}</span>
                </div>
            </a>

            <ul class="mm-collapse">
                @if(permissionCheck('frontend.my_purchase_order_list') && menuManagerCheck(2,26,'frontend.my_purchase_order_list')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'frontend.my_purchase_order_list')->position }}">
                    <a href="{{ route('frontend.my_purchase_order_list') }}" @if (request()->is('my-purchase-orders')) class="active" @endif>{{__('customer_panel.my_purchases')}}</a>
                </li>
                @endif
                @if(permissionCheck('frontend.purchased-gift-card') && menuManagerCheck(2,26,'frontend.purchased-gift-card')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'frontend.purchased-gift-card')->position }}">
                    <a href="{{ route('frontend.purchased-gift-card') }}" @if (request()->is('purchased-gift-cards')) class="active" @endif>{{__('customer_panel.gift_card')}}</a>
                </li>
                @endif
                @if(permissionCheck('frontend.digital_product') && menuManagerCheck(2,26,'frontend.digital_product')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'frontend.digital_product')->position }}">
                    <a href="{{ route('frontend.digital_product') }}" @if (request()->is('digital-products')) class="active" @endif>{{ __('customer_panel.digital_product') }}</a>
                </li>
                @endif
                @if(permissionCheck('frontend.my-wishlist') && menuManagerCheck(2,26,'frontend.my-wishlist')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'frontend.my-wishlist')->position }}">
                    <a href="{{route('frontend.my-wishlist')}}" @if (request()->is('my-wishlist')) class="active" @endif>{{__('customer_panel.my_wishlist')}}</a>
                </li>
                @endif
                @if(permissionCheck('refund.frontend.index') && menuManagerCheck(2,26,'refund.frontend.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'refund.frontend.index')->position }}">
                    <a href="{{route('refund.frontend.index')}}" @if (request()->is('refund/my-refund-list')) class="active" @endif>{{__('customer_panel.refund_dispute')}}</a>
                </li>
                @endif
                @if(permissionCheck('customer_panel.coupon') && menuManagerCheck(2,26,'customer_panel.coupon')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'customer_panel.coupon')->position }}">
                    <a href="{{route('customer_panel.coupon')}}" @if (request()->is('profile/coupons')) class="active" @endif>{{__('customer_panel.my_coupon')}}</a>
                </li>
                @endif
                @if(permissionCheck('frontend.customer_profile') && menuManagerCheck(2,26,'frontend.customer_profile')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'frontend.customer_profile')->position }}">
                    <a href="{{route('frontend.customer_profile')}}" @if (request()->is('profile')) class="active" @endif>{{__('customer_panel.my_account')}}</a>
                </li>
                @endif

                @if(permissionCheck('customer_panel.referral') && menuManagerCheck(2,26,'customer_panel.referral')->status == 1)
                <li data-position="{{ menuManagerCheck(2,26,'customer_panel.referral')->position }}">
                    <a href="{{route('customer_panel.referral')}}" @if (request()->is('profile/referral')) class="active" @endif>{{__('customer_panel.my_referral')}}</a>
                </li>
                @endif

            </ul>
        </li>
        @endif

    </ul>

</nav>
<!-- sidebar part end -->
