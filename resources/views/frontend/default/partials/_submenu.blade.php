<div class="sub_menu {{$top_bar->status == 0 ? 'd-none':''}}" id="top_bar">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-4 align-items-center">
                <div class="left_sub_menu">
                    <div class="select_option submenu_icon">
                        <a href="javascript:void(0)"
                            class="select_btn"><span>{{strtoupper($locale)}}</span><span>{{strtoupper($currency_code)}}</span></a>
                        <form action="{{route('frontend.locale')}}" method="POST">
                            @csrf
                            <div class="select_option_list text-center">
                                <div class="single_select_option">
                                    <p>{{ __('defaultTheme.language') }}</p>
                                    <select name="lang" class="country_list">
                                        @foreach($langs as $key => $lang)
                                        <option {{ $locale==$lang->code?'selected':'' }} value="{{$lang->code}}">
                                            {{$lang->native}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="single_select_option">
                                    <p>{{ __('defaultTheme.currency') }}</p>
                                    <select name="currency" class="country_list">
                                        @foreach($currencies as $key => $item)
                                        <option {{$currency_code==$item->code?'selected':'' }}
                                            value="{{$item->id}}">
                                            {{$item->name}} ({{$item->symbol}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn_1">{{ __('defaultTheme.save_change') }}</button>
                            </div>
                        </form>
                    </div>
                    <ul class="left_ul_tupbar">
                        @if(isset($topnavbar_left_menu))
                        @foreach($topnavbar_left_menu->elements->where('has_parent',null) as $element)

                        @if($element->type == 'page' && $element->page->slug == 'merchant' && isModuleActive('MultiVendor'))
                        <li>
                            @if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type',
                                'Multi-Vendor System Activate')->first()->status)
                                @if(auth()->check() && auth()->user()->role->type == 'customer')
                                    <a href="{{ route('frontend.merchant-register-step-first') }}">{{__('defaultTheme.become a merchant')}}</a>
                                @elseif(!auth()->check())
                                    <a href="{{ route('frontend.merchant-register-step-first') }}">{{__('defaultTheme.become a merchant')}}</a>
                                @endif
                            @endif
                        </li>

                        @elseif($element->type == 'page' && $element->page->slug == 'track-order')
                        <li>
                            <a class="d-none d-sm-block" href="{{ route('frontend.order.track') }}">{{
                                __('defaultTheme.track_your_order') }}</a>
                        </li>

                        @elseif($element->type == 'page' && $element->page->slug == 'contact-us')
                        <li>
                            <a class="d-none d-sm-block" href="{{ url('/contact-us') }}">{{ __('defaultTheme.support')
                                }}</a>
                        </li>
                        @elseif($element->type == 'page' && $element->page->slug == 'compare')
                        <li>
                            <a href="{{ url('/compare') }}">
                                <i class="ti-exchange-vertical compare_icon"><span class="compare_count">{{$compares}}</span></i>{{
                                __('defaultTheme.compare') }}</a>
                        </li>
                        @elseif($element->type == 'page' && $element->page->slug == 'my-wishlist')
                            @if(auth()->check())
                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                    <li>
                                        <a href="{{ route('frontend.my-wishlist') }}"> <i class="ti-heart compare_icon"><span
                                                    class="wishlist_count">{{$wishlists}}</span></i>{{ __('defaultTheme.wishlist')
                                            }}</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="{{ route('frontend.my-wishlist') }}"> <i class="ti-heart compare_icon"><span
                                                class="wishlist_count">{{$wishlists}}</span></i>{{ __('defaultTheme.wishlist')
                                        }}</a>
                                </li>
                            @endif
                        @elseif($element->type == 'page' && $element->page->slug == 'cart')
                        <li>
                            <div class="cart_menu" id="cart_inner">
                                @include('frontend.default.partials._cart_details_submenu')
                            </div>
                        </li>
                        @elseif($element->type == 'page' && $element->page->slug == 'profile')

                        <li>
                            <div class="cart_menu user_account submenu_icon">
                                <a href="{{ url('/profile') }}" class="cart_menu_item">
                                    <i class="ti-user"></i>{{ __('defaultTheme.account') }}</a>
                                <div class="cart_iner user_account_iner">

                                    @guest
                                    <div class="account_btn">
                                        <a href="{{ url('/register') }}" class="sing_up">{{ __('defaultTheme.sign_up')
                                            }}</a>
                                        <a href="{{ url('/login') }}" class="login">{{ __('defaultTheme.login') }}</a>
                                    </div>

                                    @else

                                    <div class="user_account_details">
                                        @foreach($element->childs as $key => $element)
                                            @if($element->type == 'page' && $element->page->slug == 'profile/dashboard')
                                                @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
                                                    <a href="{{ route('admin.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                @elseif (auth()->check() && auth()->user()->role->type == "seller" && isModuleActive('MultiVendor'))
                                                    <a href="{{ route('seller.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                @elseif (auth()->check() && auth()->user()->role->type == "affiliate")
                                                    <a href="{{ route('affiliate.my_affiliate.index') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                @else
                                                    <a href="{{ route('frontend.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                @endif

                                            @elseif($element->type == 'page' && $element->page->slug == 'my-purchase-orders')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ route('frontend.my_purchase_order_list') }}"><i
                                                            class="ti-shopping-cart-full"></i>{{ __('order.my_order') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'purchased-gift-cards')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ route('frontend.purchased-gift-card') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.gift_card')}}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'digital-products')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ route('frontend.digital_product') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.digital_product') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'my-wishlist')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ route('frontend.my-wishlist') }}"><i class="ti-heart"></i>{{ __('customer_panel.my_wishlist') }}</a>
                                                @endif

                                            @elseif($element->type == 'page' && $element->page->slug == 'refund/my-refund-list')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ route('refund.frontend.index') }}"><i class="ti-reload"></i>{{ __('customer_panel.refund_dispute') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'profile/coupons')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{ url('/profile/coupons') }}"><i class="ti-receipt"></i>{{ __('customer_panel.my_coupon') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'profile')
                                                <a href="{{ url('/profile') }}"><i class="ti-user"></i>{{ __('customer_panel.my_account') }}</a>
                                            @elseif($element->type == 'page' && $element->page->slug == 'wallet/customer/my-wallet-index')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{route('my-wallet.index', 'customer')}}"><i class="ti-wallet"></i>{{ __('wallet.my_wallet') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'profile/referral')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{url('/profile/referral')}}"><i class="ti-user"></i>{{ __('common.referral') }}</a>
                                                @endif
                                            @elseif($element->type == 'page' && $element->page->slug == 'support-ticket')
                                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                    <a href="{{url('/support-ticket')}}"><i class="ti-headphone-alt"></i>{{ __('ticket.support_ticket') }}</a>
                                                @endif
                                            @elseif($element->type == 'link')
                                                <a href="{{ $element->link }}"><i class="fas fa-align-left"></i>{{ $element->title }}</a>
                                            @elseif($element->type == 'category')
                                                <a href="{{route('frontend.category-product',['slug' => $element->category->slug, 'item' =>'category'])}}"><i class="fas fa-bible"></i>{{ $element->title }}</a>
                                            @elseif($element->type == 'brand')
                                                <a href="{{route('frontend.category-product',['slug' => $element->brand->slug, 'item' =>'brand'])}}"><i class="fas fa-code-branch"></i>{{ $element->title }}</a>
                                            @elseif($element->type == 'tag')
                                                <a href="{{route('frontend.category-product',['slug' => $element->tag->name, 'item' =>'tag'])}}"><i class="fas fa-tag"></i>{{ $element->title }}</a>
                                            @elseif($element->type == 'product' && @$element->product)
                                                <a href="{{route('frontend.item.show',@$element->product->slug)}}"><i class="fa fa-product-hunt"></i>{{ $element->title }}</a>
                                            @elseif($element->type == 'page' && $element->page->status == 1)
                                                @if(!isModuleActive('Lead') && $element->page->module == 'Lead')
                                                    @continue
                                                @endif
                                                    <a  href="{{ url(@$element->page->slug) }}"><i class="fa fa-link"></i>{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a>
                                            @endif

                                        @endforeach



                                    </div>
                                    <a href="{{ route('logout') }}" class="log_out"><i class="ti-shift-right"></i>{{ __('defaultTheme.log_out') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    @endguest
                                </div>
                            </div>
                        </li>
                        @elseif($element->type == 'link')
                        <li>
                            <a href="{{ $element->link }}">{{ $element->title }}</a>
                        </li>
                        @elseif($element->type == 'page' && $element->page->status == 1)
                            @if(!isModuleActive('Lead') && $element->page->module == 'Lead')
                                @continue
                            @endif
                                <li><a  href="{{ url(@$element->page->slug) }}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
                        @elseif($element->type == 'category')

                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->category->slug, 'item' =>'category'])}}">
                                <i class="fas fa-bible"></i>{{ $element->title }}</a>
                        </li>

                        @elseif($element->type == 'brand')
                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->brand->slug, 'item' =>'brand'])}}">
                                <i class="fas fa-code-branch"></i>{{ $element->title }}</a>
                        </li>
                        @elseif($element->type == 'tag')
                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->tag->name, 'item' =>'tag'])}}">
                                <i class="fas fa-tag"></i>{{ $element->title }}</a>
                        </li>
                        @elseif($element->type == 'product' && @$element->product)
                        <li>
                            <a href="{{route('frontend.item.show',@$element->product->slug)}}"> <i
                                    class="fa fa-product-hunt"></i>{{ $element->title }}</a>
                        </li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-8">
                <div class="right_sub_menu">
                    <ul>
                        @if(isset($topnavbar_right_menu))
                        @auth
                        <li>
                            <div class="cart_menu" id="cart_inner2">
                                @include('frontend.default.partials._notifications')
                            </div>
                        </li>
                        @endauth

                        @foreach($topnavbar_right_menu->elements->where('has_parent',null) as $element)


                        @if($element->type == 'page' && $element->page->slug == 'track-order')
                        <li>
                            <a class="d-none d-sm-block" href="{{ route('frontend.order.track') }}">{{ __('defaultTheme.track_your_order') }}</a>
                        </li>

                        @elseif($element->type == 'page' && $element->page->slug == 'contact-us')
                        <li>
                            <a class="d-none d-sm-block" href="{{ url('/contact-us') }}">{{ __('defaultTheme.support')
                                }}</a>
                        </li>

                        @elseif($element->type == 'page' && $element->page->slug == 'compare')
                        <li>
                            <a href="{{ url('/compare') }}">
                                <i class="ti-exchange-vertical compare_icon"><span class="compare_count">{{$compares}}</span></i>{{
                                __('defaultTheme.compare') }}</a>
                        </li>
                        @elseif($element->type == 'page' && $element->page->slug == 'my-wishlist')
                            @if(auth()->check())
                                @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                    <li>
                                        <a href="{{ route('frontend.my-wishlist') }}"> <i class="ti-heart compare_icon"><span class="wishlist_count">{{$wishlists}}</span></i>{{ __('defaultTheme.wishlist') }}</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="{{ route('frontend.my-wishlist') }}"> <i class="ti-heart compare_icon"><span class="wishlist_count">{{$wishlists}}</span></i>{{ __('defaultTheme.wishlist') }}</a>
                                </li>
                            @endif
                        @elseif($element->type == 'page' && $element->page->slug == 'cart')
                        <li>
                            <div class="cart_menu" id="cart_inner">
                                @include('frontend.default.partials._cart_details_submenu')
                            </div>
                        </li>

                        @elseif($element->type == 'page' && $element->page->slug == 'profile')

                        <li>
                            <div class="cart_menu user_account submenu_icon">
                                <a href="javascript:void(0)" class="cart_menu_item">
                                    <i class="ti-user"></i>{{ __('defaultTheme.account') }}</a>
                                <div class="cart_iner user_account_iner">

                                    @guest
                                    <div class="account_btn">
                                        <a href="{{ url('/register') }}" class="sing_up">{{ __('defaultTheme.sign_up') }}</a>
                                        <a href="{{ url('/login') }}" class="login">{{ __('defaultTheme.login') }}</a>
                                    </div>

                                    @else
                                    <div class="account_btn">
                                        <p>hello! <span>{{ substr(auth()->user()->first_name,0,25) }}
                                                @if(strlen(auth()->user()->first_name) > 25)... @endif</span></p>
                                    </div>

                                    <div class="user_account_details">
                                        @if(auth()->check() && auth()->user()->role->type == "affiliate")
                                            <a href="{{ route('affiliate.my_affiliate.index') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>

                                        @else
                                            @if (auth()->user()->role->type == 'customer' && isModuleActive('MultiVendor'))
                                                <a href="{{route('frontend.merchant-register-step-first')}}" target="_blank"><i
                                                        class="far fa-user"></i>{{ __('common.convert_as_seller') }}</a>
                                            @endif

                                            @foreach($element->childs as $key => $element)
                                                @if($element->type == 'page' && $element->page->slug == 'profile/dashboard')
                                                    @if(auth()->check())
                                                        @if (auth()->user()->role->type == "superadmin" || auth()->user()->role->type == "admin" || auth()->user()->role->type == "staff")
                                                            <a href="{{ route('admin.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                        @elseif (auth()->user()->role->type == "seller" && isModuleActive('MultiVendor'))
                                                            <a href="{{ route('seller.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                        @else
                                                            <a href="{{ route('frontend.dashboard') }}"><i class="ti-dashboard"></i>{{ __('common.dashboard') }}</a>
                                                        @endif
                                                    @endif

                                                @elseif($element->type == 'page' && $element->page->slug == 'my-purchase-orders')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ route('frontend.my_purchase_order_list') }}"><i class="ti-shopping-cart-full"></i>{{ __('order.my_order') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'purchased-gift-cards')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ route('frontend.purchased-gift-card') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.gift_card') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'digital-products')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ route('frontend.digital_product') }}"><i class="ti-shopping-cart-full"></i>{{ __('customer_panel.digital_product') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'my-wishlist')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ route('frontend.my-wishlist') }}"><i class="ti-heart"></i>{{ __('customer_panel.my_wishlist') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'refund/my-refund-list')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ route('refund.frontend.index') }}"><i class="ti-reload"></i>{{
                                                    __('customer_panel.refund_dispute') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'profile/coupons')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{ url('/profile/coupons') }}"><i class="ti-receipt"></i>{{
                                                    __('customer_panel.my_coupon') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'profile')
                                                    <a href="{{ url('/profile') }}"><i class="ti-user"></i>{{
                                            __('customer_panel.my_account') }}</a>
                                                @elseif($element->type == 'page' && $element->page->slug == 'wallet/customer/my-wallet-index')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{route('my-wallet.index', 'customer')}}"><i class="ti-wallet"></i>{{
                                                    __('wallet.my_wallet') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'profile/referral')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{url('/profile/referral')}}"><i class="ti-user"></i>{{
                                                    __('common.referral') }}</a>
                                                    @endif
                                                @elseif($element->type == 'page' && $element->page->slug == 'support-ticket')
                                                    @if(isModuleActive('MultiVendor') && auth()->user()->role->type != 'superadmin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'admin' || isModuleActive('MultiVendor') && auth()->user()->role->type != 'staff' || auth()->user()->role->type == 'customer')
                                                        <a href="{{url('/support-ticket')}}"><i class="ti-headphone-alt"></i>{{
                                                    __('ticket.support_ticket') }}</a>
                                                    @endif
                                                @elseif($element->type == 'link')
                                                    <a href="{{ $element->link }}"><i class="ti-headphone-alt"></i>{{
                                            $element->title }}</a>
                                                @elseif($element->type == 'category')
                                                    <a
                                                        href="{{route('frontend.category-product',['slug' => $element->category->slug, 'item' =>'category'])}}"><i
                                                            class="fas fa-bible"></i>{{ $element->title }}</a>
                                                @elseif($element->type == 'brand')
                                                    <a
                                                        href="{{route('frontend.category-product',['slug' => $element->brand->slug, 'item' =>'brand'])}}"><i
                                                            class="fas fa-code-branch"></i>{{ $element->title }}</a>
                                                @elseif($element->type == 'tag')
                                                    <a
                                                        href="{{route('frontend.category-product',['slug' => $element->tag->name, 'item' =>'tag'])}}"><i
                                                            class="fas fa-tag"></i>{{ $element->title }}</a>
                                                @elseif($element->type == 'product' && @$element->product)
                                                    <a href="{{route('frontend.item.show',@$element->product->slug)}}"><i
                                                            class="fa fa-product-hunt"></i>{{ $element->title }}</a>
                                                @elseif($element->type == 'page' && $element->page->status == 1)
                                                    @if(!isModuleActive('Lead') && $element->page->module == 'Lead')
                                                        @continue
                                                    @endif
                                                    <a  href="{{ url(@$element->page->slug) }}">
                                                        <i class="fa fa-link"></i>
                                                        {{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            <a href="{{route('frontend.notifications')}}"><i class="ti-bell"></i>{{ __('common.notifications') }}</a>

                                        @endif


                                    </div>

                                    <a href="{{ route('logout') }}" class="log_out"><i class="ti-shift-right"></i>{{ __('defaultTheme.log_out') }} </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    @endguest
                                </div>
                            </div>
                        </li>
                        @elseif($element->type == 'link')
                        <li>
                            <a href="{{ $element->link }}">{{ $element->title }}</a>
                        </li>

                        @elseif($element->type == 'page' && $element->page->status == 1)
                            @if(!isModuleActive('Lead') && $element->page->module == 'Lead')
                                @continue
                            @else
                                <li><a  href="{{ url(@$element->page->slug) }}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
                            @endif
                        @elseif($element->type == 'category')

                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->category->slug, 'item' =>'category'])}}">
                                <i class="fas fa-bible"></i>{{ $element->title }}</a>
                        </li>

                        @elseif($element->type == 'brand')
                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->brand->slug, 'item' =>'brand'])}}">
                                <i class="fas fa-code-branch"></i>{{ $element->title }}</a>
                        </li>
                        @elseif($element->type == 'tag')
                        <li>
                            <a
                                href="{{route('frontend.category-product',['slug' => $element->tag->name, 'item' =>'tag'])}}">
                                <i class="fas fa-tag"></i>{{ $element->title }}</a>
                        </li>
                        @elseif($element->type == 'product' && @$element->product)
                        <li>
                            <a href="{{route('frontend.item.show',@$element->product->slug)}}"> <i
                                    class="fa fa-product-hunt"></i>{{ $element->title }}</a>
                        </li>

                        @endif
                        @endforeach
                        @endif


                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
