

@php
$langs = \Modules\Language\Entities\Language::where('status',1)->get();

$locale = app('general_setting')->language_code;

if(\Session::has('locale')){
    $locale = \Session::get('locale');
}

if(auth()->check()){
    $locale = auth()->user()->lang_code;
}
@endphp


<div class="container-fluid no-gutters">
<div class="row">
    <div class="col-lg-12 p-0">
        <div class="header_iner d-flex justify-content-between align-items-center">
            <div class="small_logo_crm d-lg-none">
                <a href="{{url('/login')}}"> <img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
            </div>
            <div id="sidebarCollapse" class="sidebar_icon  d-lg-none">
                <i class="ti-menu"></i>
            </div>
            <div class="collaspe_icon open_miniSide">
                <i class="ti-menu"></i>
            </div>

            <div class="serach_field-area ml-40">
                <div class="search_inner">
                    <form action="#">
                        <div class="search_field">
                            <input type="text" class="form-control primary-input input-left-icon"
                                   placeholder="{{__('common.search')}}" id="search" onkeyup="showResult(this.value)">
                        </div>
                        <button type="submit"><i class="ti-search"></i></button>
                    </form>
                </div>
                <div id="livesearch" style="display: none;"></div>
            </div>
            <div class="header_middle d-none d-md-block">
                <div class="select_style d-flex">
                    <a target="_blank" class="primary-btn white mr-10" href="{{url('/')}}">{{__('common.website')}}</a>
                    <div class="border_1px"></div>

                    <select name="#" class="nice_Select bgLess mb-0" id="language_select">
                        @foreach($langs as $key => $lang)
                            <option {{ $locale == $lang->code?'selected':'' }} value="{{$lang->code}}">{{$lang->native}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="header_right d-flex justify-content-between align-items-center">
                <div class="header_notification_warp d-flex align-items-center">
                    <li class="notification_warp_pop">
                        <a class="popUP_clicker gredient_hover" href="#">
                            <!-- plus     -->
                            <i class="fas fa-plus-square"></i>
                            <!--/ plus      -->
                        </a>
                        <div class="menu_popUp_list_wrapper">
                            <!-- popUp_single_wrap  -->
                            <div class="popUp_single_wrap">
                                @if (permissionCheck('appearance.header.index') || permissionCheck('menu.manage'))
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('appearance.appearance') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('appearance.header.index'))
                                        <li><a href="{{ route('appearance.header.index') }}"> <i
                                                    class="ti-plus"></i> {{__('appearance.header')}}</a></li>
                                        @endif
                                        @if (permissionCheck('menu.manage'))
                                        <li><a href="{{ route('menu.manage') }}"><i
                                                    class="ti-plus"></i>{{ __('appearance.menus') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                @if (permissionCheck('blog.tags.index') || permissionCheck('blog.posts.create'))
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('blog.blog') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('blog.tags.index'))
                                        <li><a href="{{ route('blog.tags.index') }}"><i
                                                    class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                        @endif
                                        @if(permissionCheck('blog.posts.create'))
                                        <li><a href="{{ route('blog.posts.create') }}"><i
                                                    class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                @if(isModuleActive('MultiVendor'))
                                    @if (permissionCheck('admin.merchants_list.get-data') ||
                                    permissionCheck('admin.merchants_create'))
                                    <div class="popup_single_item">
                                        <div class="main-title2 mb_10">
                                            <h4 class="mb_15">{{ __('common.seller') }}</h4>
                                        </div>
                                        <ul>
                                            @if (permissionCheck('admin.merchants_list.get-data'))
                                            <li><a href="{{ route('admin.merchants_list') }}"> <i class="ti-plus"></i>
                                                    {{ __('common.list') }}</a></li>
                                            @endif
                                            @if (permissionCheck('admin.merchants_create'))
                                            <li><a href="{{ route('admin.merchants_create') }}"><i
                                                        class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            <!-- popUp_single_wrap  -->
                            <div class="popUp_single_wrap">
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('common.order') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('order_manage.total_sales_get_data'))
                                        <li><a href="{{route('order_manage.total_sales_index')}}"> <i
                                                    class="ti-plus"></i>{{ __('order.total_order') }}</a></li>
                                        @endif
                                        @if(isModuleActive('MultiVendor'))
                                            <li><a href="{{route('order_manage.my_sales_index')}}"><i
                                                    class="ti-plus"></i>{{ __('order.my_order') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @if (permissionCheck('admin.inhouse-order.get-data') ||
                                permissionCheck('admin.inhouse-order.create'))
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('order.in_house_order') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('admin.inhouse-order.get-data'))
                                        <li><a href="{{route('admin.inhouse-order.index')}}"> <i
                                                    class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                        @endif
                                        @if (permissionCheck('admin.inhouse-order.create'))
                                        <li><a href="{{ route('admin.inhouse-order.create') }}"><i
                                                    class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                @if (permissionCheck('product.index') || permissionCheck('product.create'))
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('common.product') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('product.index'))
                                        <li><a href="{{ route('product.index') }}"> <i
                                                    class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                        @endif
                                        @if (permissionCheck('product.create'))
                                        <li><a href="{{route("product.create")}}"><i
                                                    class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <!-- popUp_single_wrap  -->
                            <div class="popUp_single_wrap">
                                @if(isModuleActive('MultiVendor'))
                                    @if (permissionCheck('admin.my-product.index') ||
                                        permissionCheck('admin.my-product.create'))
                                        <div class="popup_single_item">
                                            <div class="main-title2 mb_10">
                                                <h4 class="mb_15">{{ __('common.inhouse_product') }}</h4>
                                            </div>
                                            <ul>
                                                @if (permissionCheck('admin.my-product.index'))
                                                <li><a href="{{ route('admin.my-product.index') }}"> <i
                                                            class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                                @endif
                                                @if (permissionCheck('admin.my-product.create'))
                                                <li><a href="{{ route('admin.my-product.create') }}"><i
                                                            class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                                @if (permissionCheck('review.seller.index') ||
                                permissionCheck('review.product.index'))
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('review.review') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('review.seller.index'))
                                        <li><a href="{{route('review.seller.index')}}"> <i
                                                    class="ti-plus"></i>{{ __('review.seller_review') }}</a></li>
                                        @endif
                                        @if (permissionCheck('review.product.index'))
                                        <li><a href="{{ route('review.product.index') }}"><i
                                                    class="ti-plus"></i>{{ __('review.product_review') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('common.refund') }}</h4>
                                    </div>
                                    <ul>
                                        @if (permissionCheck('refund.total_refund_list'))
                                        <li><a href="{{route('refund.total_refund_list')}}"> <i
                                                    class="ti-plus"></i>{{ __('common.pending_request') }}</a></li>
                                        @endif
                                        @if(isModuleActive('MultiVendor'))
                                        <li><a href="{{route('refund.my_refund_list')}}"><i
                                                    class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- popUp_single_wrap  -->
                            @if (Auth::user()->role->type == "superadmin")

                            <div class="popUp_single_wrap">
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('ticket.support_ticket') }}</h4>
                                    </div>
                                    <ul>
                                        <li><a href="{{route('ticket.tickets.index')}}"> <i
                                                    class="ti-plus"></i>{{ __('ticket.all_ticket') }}</a></li>
                                        <li><a href="{{ route('ticket.my_ticket') }}"><i
                                                    class="ti-plus"></i>{{ __('customer_panel.my_ticket') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('common.flash_deals') }}</h4>
                                    </div>
                                    <ul>
                                        <li><a href="{{ route('marketing.flash-deals') }}"> <i
                                                    class="ti-plus"></i>{{ __('common.list') }}</a></li>
                                        <li><a href="{{ route('marketing.flash-deals.create') }}"><i
                                                    class="ti-plus"></i>{{ __('common.create') }}</a></li>
                                    </ul>
                                </div>
                                <div class="popup_single_item">
                                    <div class="main-title2 mb_10">
                                        <h4 class="mb_15">{{ __('common.others') }}</h4>
                                    </div>
                                    <ul>
                                        <li><a href="{{route('marketing.coupon')}}"> <i
                                                    class="ti-plus"></i>{{ __('common.coupon') }}</a></li>
                                        <li><a href="{{ route('marketing.new-user-zone.create') }}"><i
                                                    class="ti-plus"></i>{{ __('common.user_zone') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </li>

                    <li class="scroll_notification_list">
                        <a class="pulse theme_color bell_notification_clicker" href="javascript:void(0)">
                            <!-- bell   -->
                            <i class="fa fa-bell"></i>

                            <!--/ bell   -->
                            @if (count($notifications) > 0)
                            <span class="notification_count">{{count($notifications)}} </span>
                            <span class="pulse-ring notification_count_pulse"></span>
                            @endif
                        </a>
                        <!-- Menu_NOtification_Wrap  -->
                        <div class="Menu_NOtification_Wrap">
                            <div class="notification_Header">
                                <h4>{{ __('common.notifications') }}</h4>
                            </div>
                            <div class="Notification_body">
                                <!-- single_notify  -->

                                @forelse ($notifications as $notification)
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_content">
                                        <a class="notification-content"
                                            href="{{$notification->url}}">
                                            {{$loop->index+1}}. {{ucfirst($notification->title)}}
                                        </a>
                                        <br />
                                    </div>
                                </div>
                                @empty
                                <div class="single_notify d-flex align-items-center">
                                    <div class="notify_content">
                                        {{ __('common.no_notification_found') }}.
                                        <br />
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            <div class="nofity_footer">
                                <div class="submit_button text-center pt_20">
                                    <a href="{{route('user.notificationsetting.index')}}"
                                        class="primary-btn radius_30px text_white  fix-gr-bg">{{ __('common.setting') }}</a>
                                    @if (count($notifications) > 0)
                                    <a href="{{route('frontend.mark_as_read')}}"
                                        class="primary-btn radius_30px text_white  fix-gr-bg">{{ __('common.read_all') }}</a>
                                    <a href="{{route('frontend.notifications')}}"
                                        class="primary-btn radius_30px text_white  fix-gr-bg">{{ __('common.view') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/ Menu_NOtification_Wrap  -->
                    </li>
                </div>
                <div class="profile_info">

                    <div class="user_avatar_div">
                        <img id="profile_pic" src="{{showImage(auth()->user()->avatar !=null?auth()->user()->avatar:'backend/img/avatar.png')}}" alt="">
                    </div>

                    <div class="profile_info_iner">
                        <p> {{__('common.welcome')}} 
                            @if(auth()->user()->role->type == 'superadmin') SuperAdmin
                            @elseif(auth()->user()->role->type == 'admin') Admin
                            @elseif(auth()->user()->role->type == 'seller') Seller
                            @elseif(auth()->user()->role->type == 'staff') Staff @endif!</p>
                        <h5>{{ auth()->user()->first_name }}</h5>
                        <div class="profile_info_details">
                            @if(auth()->user()->role->type == 'superadmin' || auth()->user()->role->type == 'admin' || auth()->user()->role->type == 'staff')
                            <a href="{{url('/profile')}}">{{ __('customer_panel.my_profile') }}<i
                                    class="ti-user"></i></a>
                            @if(permissionCheck('company_info'))
                            <a href="{{url('/generalsetting/company-info')}}">{{ __('customer_panel.company_info') }}<i
                                    class="ti-user"></i></a>
                            @endif
                            @if(permissionCheck('generalsetting.index'))
                            <a href="{{url('/generalsetting')}}">{{ __('common.settings') }}<i
                                    class="ti-settings"></i></a>
                            @endif
                            @endif

                            @if(auth()->user()->role->type == 'seller')
                            <a href="{{url('/profile')}}">{{ __('customer_panel.customer_profile') }}<i
                                    class="ti-user"></i></a>
                            <a href="{{url('/seller/profile')}}">{{ __('seller.seller_profile') }}<i
                                    class="ti-user"></i></a>
                            <a href="{{url('/seller/setting')}}">{{ __('common.setting') }}<i
                                    class="ti-user"></i></a>
                            @endif

                            @if (auth()->user()->secret_login)
                            <a href="{{ route('secret_logout') }}">{{ __('common.log_out') }}<i
                                    class="ti-shift-left"></i></a>
                            @else
                            <a href="{{ route('logout') }}" class="log_out" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('common.log_out') }}<i
                                    class="ti-shift-left"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
