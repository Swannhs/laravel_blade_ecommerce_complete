@if (permissionCheck('marketing.coupon.update') || permissionCheck('marketing.coupon.delete'))
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('common.select') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
            @if (permissionCheck('marketing.coupon.update'))
                <a data-id="{{$coupon->id}}" data-start_date="{{date('m/d/Y',strtotime($coupon->start_date))}}" data-end_date="{{date('m/d/Y',strtotime($coupon->end_date))}}" class="dropdown-item edit_coupon">{{ __('common.edit') }}</a>
            @endif
            @if (permissionCheck('marketing.coupon.delete'))
                <a class="dropdown-item delete_coupon" data-id="{{$coupon->id}}">{{ __('common.delete') }}</a>
            @endif
        </div>
    </div>
@else
    <button class="primary_btn_2" type="button">No Action Permitted</button>
@endif
