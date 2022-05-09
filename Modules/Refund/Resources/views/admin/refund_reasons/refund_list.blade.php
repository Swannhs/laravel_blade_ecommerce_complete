<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.id')}}</th>
        <th scope="col">{{__('common.name')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $item)
        <tr>
            <th>{{ $key+1 }}</th>
            <td>{{ $item->reason }}</td>
            <td>
                @if (permissionCheck('refund.reasons_update') || permissionCheck('refund.destroy'))
                    <!-- shortby  -->
                    <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('common.select') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            @if (permissionCheck('refund.reasons_update'))
                                <a class="dropdown-item edit_reason" data-value="{{$item}}" type="button">{{ __('common.edit') }}</a>
                            @endif
                            @if (permissionCheck('refund.destroy'))
                                <a class="dropdown-item delete-item" data-value="{{route('refund.destroy', $item->id)}}">{{__('common.delete')}}</a>
                            @endif
                        </div>
                    </div>
                    <!-- shortby  -->
                @else
                <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
