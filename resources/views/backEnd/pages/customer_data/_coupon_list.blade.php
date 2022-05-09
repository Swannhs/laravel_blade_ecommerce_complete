<table class="table Crm_table_active2">
    <thead>
    <tr>
        <th scope="col">{{ __('common.sl') }}</th>
        <th>{{ __('customer_panel.coupon_value') }}</th>
        <th>{{ __('customer_panel.store_name') }}</th>
        <th>{{ __('common.coupon_code') }}</th>
        <th>{{ __('customer_panel.validity') }}</th>
        <th>{{ __('common.action') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($coupons as $key => $coupon)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>
                @if($coupon->coupon->coupon_type == 3)
                    <strong>{{single_price($coupon->coupon->discount)}}</strong>
                @else
                    @if($coupon->coupon->discount_type == 0)
                        <strong>{{$coupon->coupon->discount}} %</strong>
                    @else
                        <strong>{{single_price($coupon->coupon->discount)}}</strong>
                    @endif
                @endif
            </td>
            <td>{{@$coupon->coupon->user->first_name}}</td>
            <td>{{@$coupon->coupon->coupon_code}}</td>
            <td>{{date(app('general_setting')->dateFormat->format, strtotime(@$coupon->coupon->start_date))}} to {{date(app('general_setting')->dateFormat->format, strtotime(@$coupon->coupon->end_date))}}</td>
            <td><i class="fas fa-trash-alt required_mark2 f_s_13 deleteCoupon" data-id='{{ $coupon->id }}'></i></td>
        </tr>
        @endforeach
    </tbody>
</table>
