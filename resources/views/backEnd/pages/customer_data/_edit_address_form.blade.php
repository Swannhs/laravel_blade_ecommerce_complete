<form action="#" method="POST" id="address_form_edit">
@csrf
<input type="hidden" name="address_id" id="address_id" value="{{$address->id}}">
 <div class="form-row">
    <div class="col-md-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="address_name_edit">{{ __('common.name') }} <span class="text-danger">*</span></label>
            <input type="text" class="primary_input_field" id="address_name_edit" placeholder="" value="{{$address->name}}" name="name" autocomplete="off">
            <span class="text-danger" id="error_name"></span>
        </div>
    </div>
     <div class="col-md-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="Email_Address_edit">{{ __('common.email_address') }} <span class="text-danger">*</span></label>
            <input type="email" class="primary_input_field" id="Email_Address_edit" placeholder="" value="{{$address->email}}" name="email">
            <span class="text-danger" id="error_email"></span>
        </div>
        
     </div>
     <div class="col-md-6 primary_input mb-25">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="customer_phn_edit">{{ __('common.phone_number') }} <span class="text-danger">*</span></label>
            <input type="text" class="primary_input_field" id="customer_phn_edit" placeholder="" value="{{$address->phone}}" name="phone">
            <span class="text-danger" id="error_phone"></span>
        </div>
     </div>
     <div class="col-md-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="address_edit">{{ __('common.address') }} <span class="text-danger">*</span></label>
            <input type="text" class="primary_input_field" id="address_edit" placeholder="" name="address" value="{{$address->address}}" autocomplete="off">
            <span class="text-danger" id="error_address"></span>
         </div>
     </div>

     <div class="col-md-3">
        <div class="primary_input mb-25">
            <label class="primary_input_label">{{ __('common.country') }} <span class="text-danger">*</span></label>
            <select class="form-control primary_select" name="country" id="country_edit" autocomplete="off">
            <option value="">{{__('defaultTheme.select_from_options')}}</option>
            @foreach($countries as $key => $country)
            <option {{$address->country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
            </select>
            <span class="text-danger" id="error_country"></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="primary_input mb-25">
            <label class="primary_input_label">{{ __('common.state') }} <span class="text-danger">*</span></label>
            <select class="form-control primary_select" name="state" id="state_edit" autocomplete="off">
                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                @if($address->getCountry)
                    @foreach($address->getCountry->states as $key => $state)
                    <option {{$address->state == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger" id="error_state"></span>
        </div>
    </div>
     <div class="col-md-3">
        <div class="primary_input mb-25">
            <label class="primary_input_label">{{ __('common.city') }} <span class="text-danger">*</span></label>
            <select class="form-control primary_select" name="city" id="city_edit" autocomplete="off">
               <option value="">{{__('defaultTheme.select_from_options')}}</option>
               @if($address->getState)
                   @foreach($address->getState->cities as $key => $city)
                   <option {{$address->city == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                   @endforeach
               @endif
            </select>
            <span class="text-danger" id="error_city"></span>
        </div>
        
     </div>


     <div class="col-md-3">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="postal_code_edit">{{ __('common.postal_code') }} <span class="text-danger">*</span></label>
            <input type="text" class="primary_input_field" id="postal_code_edit" placeholder="" value="{{$address->postal_code}}" name="postal_code" autocomplete="off">
            <span class="text-danger" id="error_postcode"></span>
        </div>
        
     </div>
     <div class="form_btn col-md-12 text-center">
         <button type="submit" class="primary-btn semi_large2 fix-gr-bg float-none" type="submit">{{ __('common.update') }}</button>
         <button type="button" class="primary-btn semi_large2 fix-gr-bg float-none delete_address_btn" data-id="{{$address->id}}">{{__('common.delete')}}</button>
     </div>

 </div>
</form>

@include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.address'), 'form_id' => 'adrs_delete_form','modal_id' => 'adrs_delete_modal'])
