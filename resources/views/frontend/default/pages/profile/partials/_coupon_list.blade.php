<table class="table table-hover red-header">
    <thead>
        <tr>
            <th class="text-nowrap">{{ __('customer_panel.coupon_value') }}</th>
            <th class="text-nowrap">{{ __('customer_panel.store_name') }}</th>
            <th class="text-nowrap">{{ __('common.coupon_code') }}</th>
            <th class="text-nowrap">{{ __('customer_panel.validity') }}</th>
            <th class="text-nowrap">{{ __('common.action') }}</th>
        </tr>
    </thead>
    <tbody class="cart_table_body">
        @foreach($coupons as $key => $coupon)
        <tr>
            <td>
                <h4>
                    @if($coupon->coupon->coupon_type == 3)
                        {{single_price($coupon->coupon->discount)}}
                    @else
                        @if($coupon->coupon->discount_type == 0)
                            {{$coupon->coupon->discount}} %
                        @else
                            {{single_price($coupon->coupon->discount)}}
                        @endif
                    @endif
                </h4>
            </td>
            <td>{{@$coupon->coupon->user->first_name}}</td>
            <td>{{@$coupon->coupon->coupon_code}}</td>
            <td>Start {{date('dS M, Y',strtotime(@$coupon->coupon->start_date))}} <br> End {{date('dS M, Y',strtotime(@$coupon->coupon->end_date))}}</td>
            <td><i data-id="{{$coupon->id}}" class="ti-trash coupon_delete_btn"></i></td>
        </tr>
        @endforeach

    </tbody>
</table>
@if(count($coupons) < 1)
<p class="empty_p">{{ __('common.empty_list') }}.</p>
@endif
