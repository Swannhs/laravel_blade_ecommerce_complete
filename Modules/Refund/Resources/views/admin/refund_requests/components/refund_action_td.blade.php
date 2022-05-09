@if (permissionCheck('refund.refund_show_details'))
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false"> {{__('common.select')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a href="{{route('refund.refund_show_details',$data->id)}}" class="dropdown-item"
            type="button">{{ __('common.details') }}</a>
    </div>
</div>
@else
<button class="primary_btn_2" type="button">{{ __('common.no_action_permitted') }}</button>
@endif
