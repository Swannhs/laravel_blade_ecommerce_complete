<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.id')}}</th>
        <th scope="col">{{__('refund.process')}}</th>
        <th scope="col">{{__('refund.description')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $item)
        <tr>
            <th>{{ $key+1 }}</th>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('common.select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @if (permissionCheck('order_manage.cancel_reason_update'))
                            <a class="dropdown-item edit_reason" data-value="{{$item}}" type="button">{{ __('common.edit') }}</a>
                        @else
                            <a class="dropdown-item" type="button">{{ __('common.not_editable') }}</a>
                        @endif
                        @if (permissionCheck('order_manage.cancel_reason_destroy'))
                        <a class="dropdown-item delete_item" data-value="{{route('order_manage.cancel_reason_destroy', $item->id)}}">{{__('common.delete')}}</a>
                        @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
