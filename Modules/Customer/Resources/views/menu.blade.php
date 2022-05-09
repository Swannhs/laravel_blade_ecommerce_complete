@if (permissionCheck('cusotmer.list_active'))
    @php
        $customer = false;

        if(request()->is('customer/*'))
        {
            $customer = true;
        }
    @endphp
    <li class="{{ $customer ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,5)->position }}" data-status="{{ menuManagerCheck(1,5)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $customer ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-users"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('common.customer') }}</span>
            </div>
        </a>
        <ul>
            @if (menuManagerCheck(2,5,'customer.show_details')->status == 1)
            <li data-position="{{ menuManagerCheck(2,5,'customer.show_details')->position }}">
                <a href="{{route('cusotmer.list_active')}}" @if (request()->is('customer/active-customer-list') || request()->is('customer/profile/details')) class="active" @endif>{{ __('common.all_customer') }}</a>
            </li>
            @endif
        </ul>
    </li>
@endif
