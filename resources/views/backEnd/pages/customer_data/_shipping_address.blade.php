<h4>{{__('common.make')}} {{__('common.default')}} {{__('defaultTheme.shipping')}} {{__('common.address')}}</h4>
<div class="QA_section QA_section_heading_custom check_box_table" id="address_list">
    <div class="QA_table ">
        <table class="table Crm_table_active2" id="address_table">
            <thead>
                <tr>
                    <th>{{__('common.full_name')}}</th>
                    <th>{{__('common.address')}}</th>
                    <th>{{__('common.region')}}</th>
                    <th>{{__('common.email')}}</th>
                    <th>{{__('common.phone_number')}}</th>
                    <th>{{__('common.make_default')}}</th>
                </tr>

            </thead>
            <tbody>
                @foreach($addressList as $key => $address)
                <tr>
                    <td>{{$address->name}}</td>
                    <td>{{$address->address}}</td>
                    <td>{{@$address->getCity->name.', '.@$address->getState->name.', '.@$address->getCountry->name}}</td>
                    <td>{{$address->email}}</td>
                    <td>{{$address->phone}}</td>
                    <td>
                        <ul id="" class="permission_list sms_list">
                            <li>
                                <label class="primary_checkbox d-flex mr-12 ">
                                    <input name="dft_adrs_shipping" type="radio" id="sms_gateway_id{{ $key }}" value="1" c_list_id="{{$address->id}}" c_id="{{$address->customer_id}}" @if($address->is_shipping_default==1) checked @endif>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
<button class="primary_btn_2 default_setup_shipping">{{__('common.save')}}</button>
