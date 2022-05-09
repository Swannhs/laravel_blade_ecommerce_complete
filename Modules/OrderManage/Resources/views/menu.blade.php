@if (permissionCheck('order_manage'))
    @php
        $order_manage_admin = false;
        if(request()->is('ordermanage/*') || request()->is('admin/in-house-order') || request()->is('admin/in-house-order/create'))
        {
            $order_manage_admin = true;
        }
    @endphp
    <li class="{{ $order_manage_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,14)->position }}" data-status="{{ menuManagerCheck(1,14)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $order_manage_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-shopping-cart"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('order.order_manage') }}</span>
            </div>
        </a>
        <ul id="order_manage_ul">
            @if(permissionCheck('seller_order_manage') && menuManagerCheck(2,14,'my_orders')->status == 1 && isModuleActive('MultiVendor'))
                <li data-position="{{ menuManagerCheck(2,14,'my_orders')->position }}">
                    <a href="{{route('order_manage.my_sales_index')}}" @if (strpos(request()->getUri(),'my-sales-list') != false || strpos(request()->getUri(),'my-sales-details') != false) class="active" @endif>{{ __('order.my_order') }}</a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
                @if (permissionCheck('order_manage.total_sales_get_data') && menuManagerCheck(2,14,'order_manage.total_sales_get_data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,14,'order_manage.total_sales_get_data')->position }}">
                        <a href="{{route('order_manage.total_sales_index')}}" @if (strpos(request()->getUri(),'total-sales-list') != false || strpos(request()->getUri(),'sales-details') != false) class="active" @endif>{{ __('order.total_order') }}</a>
                    </li>
                @endif
                @if (permissionCheck('admin.inhouse-order.get-data') && menuManagerCheck(2,14,'admin.inhouse-order.get-data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,14,'admin.inhouse-order.get-data')->position }}">
                        <a href="{{route('admin.inhouse-order.index')}}" @if (request()->is('admin/in-house-order') || request()->is('admin/in-house-order/create')) class="active" @endif>{{ __('order.inhouse_orders') }}</a>
                    </li>
                @endif
                @if (permissionCheck('order_manage.process_index') && menuManagerCheck(2,14,'order_manage.process_index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,14,'order_manage.process_index')->position }}">
                        <a href="{{route('order_manage.process_index')}}" @if (request()->is('ordermanage/delivery-process')) class="active" @endif>{{ __('order.delivery_process') }}</a>
                    </li>
                @endif
                @if(menuManagerCheck(2,14,'order_manage.cancel_reason_index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,14,'order_manage.cancel_reason_index')->position }}">
                    <a href="{{route('order_manage.cancel_reason_index')}}" @if (request()->is('ordermanage/cancel-reason')) class="active" @endif>{{ __('order.cancel_reason') }}</a>
                </li>
                @endif
                
                <li data-position="{{ menuManagerCheck(2,14,'order_manage.cancel_reason_index')->position }}">
                    <a href="{{route('track_order_configuration')}}" @if (request()->is('ordermanage/track_order_configuration')) class="active"
                        @endif>{{ __('order.track_order') }} {{ __('common.config') }}</a>
                </li>
                
            @endif
        </ul>
    </li>
@endif

@if (permissionCheck('seller_order_manage') && auth()->user()->role->type == 'seller' && isModuleActive('MultiVendor'))
    @php
        $order_manage_seller = false;
        if(request()->is('ordermanage/my-sales-list'))
        {
            $order_manage_seller = true;
        }
    @endphp
    <li class="{{ $order_manage_seller ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,30)->position }}" data-status="{{ menuManagerCheck(1,30)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $order_manage_seller ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-shopping-cart"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('order.order_manage') }}</span>
            </div>
        </a>
        <ul id="order_manage_ul">
            @if(permissionCheck('order_manage.my_sales_index') && menuManagerCheck(2,30,'order_manage.my_sales_index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,30,'order_manage.my_sales_index')->position }}">
                <a href="{{route('order_manage.my_sales_index')}}" @if (strpos(request()->getUri(),'my-sales-list') != false || strpos(request()->getUri(),'my-sales-details') != false) class="active" @endif>{{ __('order.my_order') }}</a>
            </li>
            @endif
        </ul>
    </li>
@endif
