@if(count($customer->customerAddresses)>0)
<table class="table table-hover tablesaw tablesaw-stack text-center">
    <thead>
        <tr class="text-center">
            <th>{{__('common.name')}}</th>
            <th>{{__('common.address')}}</th>
            <th>{{__('common.email_address')}}</th>
            <th>{{__('common.phone_number')}}</th>
            <th>{{__('common.select')}}</th>
        </tr>
    </thead>
    <tbody class="cart_table_body mt-20">

        @foreach($customer->customerAddresses as $key => $address)
        
        <tr>
            <td>{{$address->name}}</td>
            <td>{{$address->address}}</td>
            <td>{{$address->email}}</td>
            <td>{{$address->phone}}</td>
            <td><input {{$address->is_billing_default ==1?'checked':''}} name="billing_select" data-id="{{$address->id}}" class="billing_select_input" type="radio"></td>
        </tr>
        @endforeach

    </tbody>

</table>
<div class="row">
    <div class="col-md-5 offset-md-7">
        <input type="hidden" id="billing_address_id" value="{{$customer->customerAddresses->where('is_billing_default',1)->first()->id}}">
        <button type="button" class="btn_2 text-black" data-dismiss="modal" aria-label="Close">{{__('common.cancel')}}</button>
        <button type="submit" class="btn_1" id="billing_address_set_btn">{{__('common.save')}}</button>
    </div>
</div>

@endif

