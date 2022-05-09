<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.sl')}}</th>
        <th scope="col">{{__('common.name')}}</th>
        <th scope="col">{{__('gst.rate')}} (%)</th>
        <th scope="col">{{__('common.status')}}</th>
        <th scope="col" width="10%">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($gst_lists as $key => $gst)
        <tr>
            <th>{{ $key+1 }}</th>
            <td>{{ $gst->name }}</td>
            <td>{{ $gst->tax_percentage }}</td>
            <td>
                @if ($gst->is_active == 1)
                    <span class="badge_1">{{ __('common.active') }}</span>
                @else
                    <span class="badge_4">{{ __('common.inactive') }}</span>
                @endif
            </td>
            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{__('common.select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @if (permissionCheck('gst_tax.update'))
                            <a class="dropdown-item edit_gst" data-value="{{$gst}}" type="button">{{__('common.edit')}}</a>
                        @endif
                        @if (permissionCheck('gst_tax.destroy'))
                            <a class="dropdown-item delete_gst" data-id="{{$gst->id}}">{{__('common.delete')}}</a>
                        @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
