<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.id')}}</th>
        <th scope="col">{{__('shipping.logo')}}</th>
        <th scope="col">{{__('shipping.method_name')}}</th>
        <th scope="col">{{__('shipping.is_active')}}</th>
        <th scope="col">{{__('shipping.is_approved')}}</th>
        <th scope="col">{{__('shipping.phone')}}</th>
        <th scope="col">{{__('shipping.shipment_time')}}</th>
        <th scope="col">{{__('shipping.cost')}}</th>
        <th scope="col">{{__('shipping.requested_by')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($methods as $key => $method)
        <tr>
            <th>{{ $key+1 }}</th>
            <td>
                <div class="mini_logo_div">
                    <img class="mini_logo" src="{{showImage($method->logo??'backend/img/default.png')}}" alt="{{$method->method_name}}">
                </div>
            </td>
            <td>{{ $method->method_name }}</td>
            <td>
                <label class="switch_toggle" for="active_checkbox{{ $method->id }}">
                    <input type="checkbox" id="active_checkbox{{ $method->id }}" @if ($method->is_active == 1) checked @endif @if(permissionCheck('shipping_methods.update_status')) class="status_change" value="{{ $method->id }}" data-id="{{ $method->id }}" @else disabled @endif>
                    <div class="slider round"></div>
                </label>
            </td>
            <td>
                <label class="switch_toggle" for="approve_checkbox{{ $method->id }}">
                    <input type="checkbox" id="approve_checkbox{{ $method->id }}" @if ($method->is_approved == 1) checked @endif @if(permissionCheck('shipping_methods.update_approve_status')) class="approve_status_change" value="{{ $method->id }}" data-id="{{ $method->id }}" @else disabled @endif>
                    <div class="slider round"></div>
                </label>
            </td>
            <td>{{ $method->phone }}</td>
            <td>{{ $method->shipment_time }}</td>
            <td>{{ single_price($method->cost) }}</td>
            <td>{{ $method->request_user->first_name }}</td>
            <td>

                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{__('common.select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @if (permissionCheck('shipping_methods.update'))
                            <a class="dropdown-item edit_method" data-id="{{$method->id}}" type="button">{{__('common.edit')}}</a>
                        @endif
                        @if ($method->id > 1 && permissionCheck('shipping_methods.destroy'))
                            <a class="dropdown-item delete_method" data-id="{{$method->id}}">{{__('common.delete')}}</a>
                        @endif
                    </div>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
