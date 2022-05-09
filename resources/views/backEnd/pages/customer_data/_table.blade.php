<thead>
    <tr>
        <th scope="col">{{__('common.full_name')}}</th>
        <th scope="col">{{__('common.address')}}</th>
        <th scope="col">{{__('common.region')}}</th>
        <th scope="col">{{__('common.email')}}</th>
        <th scope="col">{{__('common.phone_number')}}</th>
        <th scope="col" class="text-right">{{__('common.action')}}</th>
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
            <td class="text-right">
                <a class="primary-btn radius_30px mr-10 fix-gr-bg edit_address" data-id="{{ $address->id }}">{{__('common.edit')}}</a>
            </td>

        </tr>
    @endforeach
</tbody>
