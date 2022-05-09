<form action="#" method="POST" id="address_form_edit">
@csrf
<input type="hidden" name="address_id" id="address_id" value="{{$address->id}}">
 <div class="form-row">
     <div class="col-md-6">
         <div class="form-group">
            <label for="address_name_edit">{{ __('common.name') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="address_name_edit" placeholder="{{ __('common.name') }}" value="{{$address->name}}" name="name" autocomplete="off">
         </div>
         <span class="text-red" id="error_name"></span>
     </div>
     <div class="col-md-6">
         <div class="form-group">
            <label for="Email_Address_edit">{{ __('common.email_address') }} <span class="text-red">*</span></label>
            <input type="email" class="form-control" id="Email_Address_edit" placeholder="{{ __('common.email_address') }}" value="{{$address->email}}" name="email">
         </div>
         <span class="text-red" id="error_email"></span>
     </div>
     <div class="col-md-6 form-group">
        <div class="form-group">
            <label for="customer_phn_edit">{{ __('common.phone_number') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="customer_phn_edit" placeholder="{{ __('common.phone_number') }}" value="{{$address->phone}}" name="phone">
        </div>
        <span class="text-red" id="error_phone"></span>
     </div>
     <div class="col-md-6">
         <div class="form-group">
            <label for="address_edit">{{ __('common.address') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="address_edit" placeholder="{{ __('common.address') }}" name="address" value="{{$address->address}}" autocomplete="off">
         </div>
         <span class="text-red" id="error_address"></span>
     </div>

     <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('common.country') }} <span class="text-red">*</span></label>
            <select class="form-control nc_select" name="country" id="country_edit" autocomplete="off">
            <option value="">{{__('defaultTheme.select_from_options')}}</option>
            @foreach($countries as $key => $country)
            <option {{$address->country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
            </select>
        </div>
        <span class="text-red" id="error_country"></span>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('common.state') }}<span class="text-red">*</span></label>
            <select class="form-control nc_select" name="state" id="state_edit" autocomplete="off">
                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                @if($address->getCountry)
                    @foreach($address->getCountry->states as $key => $state)
                    <option {{$address->state == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <span class="text-red" id="error_state"></span>
    </div>
     <div class="col-md-3">
         <div class="form-group">
            <label>{{ __('common.city') }}<span class="text-red">*</span></label>
            <select class="form-control nc_select" name="city" id="city_edit" autocomplete="off">
               <option value="">{{__('defaultTheme.select_from_options')}}</option>
               @if($address->getState)
                   @foreach($address->getState->cities as $key => $city)
                   <option {{$address->city == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                   @endforeach
               @endif
            </select>
         </div>
         <span class="text-red" id="error_city"></span>
     </div>


     <div class="col-md-3">
         <div class="form-group">
            <label for="postal_code_edit">{{ __('common.postal_code') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="postal_code_edit" placeholder="{{ __('common.postal_code') }}" value="{{$address->postal_code}}" name="postal_code" required autocomplete="off">
         </div>
         <span class="text-red" id="error_postcode"></span>
     </div>
     <div class="form_btn col-md-12 text-center">
         <button type="submit" class="btn_1 float-none" type="submit">{{ __('common.update') }}</button>
         <button type="button" class="btn_1 float-none delete_address_btn" data-id="{{$address->id}}">{{ __('common.delete') }}</button>
     </div>

 </div>
</form>
@include('frontend.default.partials._delete_modal_for_ajax',['item_name' => __('common.address'),'form_id' => 'adrs_delete_form','modal_id' => 'adrs_delete_modal'])
