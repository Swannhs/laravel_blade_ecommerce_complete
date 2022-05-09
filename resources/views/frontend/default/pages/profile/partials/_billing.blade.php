<h4>{{__('common.make')}} {{__('common.default')}} {{__('defaultTheme.billing')}} {{__('common.address')}}</h4>
    <table class="table" id="address_table">
        <thead>
            <tr>
                <th>{{__('common.full_name')}}</th>
                <th>{{__('common.address')}}</th>
                <th>{{__('common.region')}}</th>
                <th>{{__('common.email')}}</th>
                <th>{{__('common.phone_number')}}</th>
            </tr>
            
        </thead>
        <tbody>
            @foreach($addressList as $address)
            <tr>
                <td>{{$address->name}}</td>
                <td>{{$address->address}}</td>
                <td>{{@$address->getCity->name.', '.@$address->getState->name.', '.@$address->getCountry->name}}</td>
                <td>{{$address->email}}</td>
                <td>{{$address->phone}}</td>
                <td>
                    <input type="radio" name="dft_adrs_billing" value="1" c_list_id="{{$address->id}}"  c_id="{{$address->customer_id}}"@if($address->is_billing_default==1) checked @endif >
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table> 
    <div class="float-left">
        <button class="btn_1 default_setup_billing">{{__('common.save')}}</button>
        
    </div> 