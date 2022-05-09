<thead>
    <tr>
        <th>{{__('common.full_name')}}</th>
        <th>{{__('common.address')}}</th>
        <th>{{__('common.region')}}</th>
        <th>{{__('common.email')}}</th>
        <th>{{__('common.phone_number')}}</th>
        <th></th>
        <th></th>
    </tr>

</thead>
<tbody>
    @foreach ($addressList as $address)
        <tr>
            <td>{{ $address->name }}</td>
            <td>{{ $address->address }}</td>
            <td>{{@$address->getCity->name.', '.@$address->getState->name.', '.@$address->getCountry->name}}</td>
            <td>{{ $address->email }}</td>
            <td>{{ $address->phone }}</td>
            <td>
                @if ($address->is_shipping_default == 1)
                    <p>{{__('common.default')}} {{__('defaultTheme.shipping')}} {{__('common.address')}}</p>
                @endif
                @if ($address->is_billing_default == 1)
                    <p>{{__('common.default')}} {{__('defaultTheme.billing')}} {{__('common.address')}}</p>
                @endif
            </td>
            <td><a href="" class="edit_address" data-id="{{ $address->id }}">{{__('common.edit')}}</a>
            </td>

        </tr>
    @endforeach
</tbody>
