<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.sl')}}</th>
        <th scope="col">{{__('product.attribute_name')}}</th>
        <th scope="col" width="60%">{{__('common.description')}}</th>
        <th scope="col">{{__('common.status')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attributes as $key => $variant_value)
        <tr>


            <th>{{ $key+1 }}</th>
            <td>{{ $variant_value->name }}</td>
            <td>{{ $variant_value->description }}</td>
            <td>
                @if($variant_value->status === 1)
                    <span class="badge_1">{{__("common.active")}}</span>
                @else
                    <span class="badge_4">{{__("common.inactive")}}</span>
                @endif
            </td>
            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{__('common.select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                         <a data-id="{{$variant_value->id}}" class="dropdown-item show_attribute">{{__('common.view')}}</a>
                         @if (permissionCheck('product.attribute.edit'))
                             <a class="dropdown-item edit_variant" data-value="{{$variant_value->id}}" type="button">{{__('common.edit')}}</a>
                         @endif
                         @if (permissionCheck('product.attribute.destroy'))
                             <a class="dropdown-item delete_attribute" data-value="{{route('product.attribute.destroy', $variant_value->id)}}">{{__('common.delete')}}</a>
                         @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
