<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.sl')}}</th>
        <th scope="col">{{__('common.name')}}</th>
        <th scope="col">{{__('common.status')}}</th>
        <th scope="col" width="10%">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($units as $key => $unit)
        <tr>
            <th>{{ $key+1 }}</th>
            <td>{{ $unit->name }}</td>
            <td>
                @if ($unit->status == 1)
                    <span class="badge_1">{{ __('common.active') }}</span>
                @else
                    <span class="badge_4">{{ __('common.inactive') }}</span>
                @endif
            </td>
            <td>
                @if (permissionCheck('product.units.update') || permissionCheck('product.units.destroy'))
                    <!-- shortby  -->
                    <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('common.select')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            @if (permissionCheck('product.units.update'))
                                <a class="dropdown-item edit_unit" data-value="{{$unit}}" type="button">{{__('common.edit')}}</a>
                            @endif
                            @if (permissionCheck('product.units.destroy'))
                                <a class="dropdown-item delete_unit" data-value="{{route('product.units.destroy', $unit->id)}}">{{__('common.delete')}}</a>
                            @endif
                        </div>
                    </div>
                    <!-- shortby  -->
                @else
                    <button class="primary_btn_2" type="button">

                        {{ __('common.you_don_t_have_this_permission') }}
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
