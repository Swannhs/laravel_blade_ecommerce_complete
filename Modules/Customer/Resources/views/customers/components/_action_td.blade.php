<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"> {{__('common.select')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('customer.show_details'))
            <a href="{{route('customer.show_details',$customer->id)}}" class="dropdown-item" type="button">{{__('common.details')}}</a>
        @endif
        @if (permissionCheck('admin.customer.edit'))
            <a href="{{route('admin.customer.edit',$customer->id)}}" class="dropdown-item" type="button">{{__('common.edit')}}</a>
        @endif
        @if (permissionCheck('admin.customer.destroy'))
            <a data-value="{{route('admin.customer.destroy', $customer->id)}}" class="dropdown-item delete_customer" type="button">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
