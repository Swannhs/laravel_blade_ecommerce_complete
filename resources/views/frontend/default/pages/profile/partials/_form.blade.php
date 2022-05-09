<form action="#" method="POST" id="address_form">
@csrf
 <div class="form-row">
     <div class="col-md-6">
         <div class="form-group">
            <label for="address_name">{{ __('common.name') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="address_name" placeholder="{{ __('common.name') }}" name="name" value="{{isset($primary_address->name)?$primary_address->name:''}}" autocomplete="off" >
         </div>
         <span class="text-red" id="error_name"></span>
     </div>
     <div class="col-md-6">
         <div class="form-group">
            <label for="Email_Address1">{{ __('common.email_address') }} <span class="text-red">*</span></label>
            <input type="email" class="form-control" id="Email_Address1" placeholder="{{ __('common.email_address') }}" name="email" value="{{isset($primary_address->email)?$primary_address->email:''}}">
         </div>
         <span class="text-red" id="error_email"></span>
     </div>
     <div class="col-md-6">
         <div class="form-group">
            <label for="customer_phn">{{ __('common.phone_number') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="customer_phn" placeholder="{{ __('common.phone_number') }}" name="phone" value="{{isset($primary_address->phone)?$primary_address->phone:''}}">
         </div>
         <span class="text-red" id="error_phone"></span>
     </div>
     <div class="col-md-6">
         <div class="form-group">
            <label for="Address">{{ __('common.address') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="Address" placeholder="{{ __('common.address') }}" name="address" value="{{isset($primary_address->address_one)?$primary_address->address:''}}" autocomplete="off">
         </div>
         <span class="text-red" id="error_address"></span>
     </div>

     <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('common.country') }} <span class="text-red">*</span></label>
            <select class="form-control nc_select" name="country" id="country" autocomplete="off">
                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                @foreach($countries as $key => $country)
                    <option value="{{$country->id}}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{$country->name}}</option>
                @endforeach
            </select>
        </div>
        <span class="text-red" id="error_country"></span>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('common.state') }} <span class="text-red">*</span></label>
            <select class="form-control nc_select" name="state" id="state" autocomplete="off">
                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                @if(app('general_setting')->default_country != null)
                    @foreach ($states as $state)
                        <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <span class="text-red" id="error_state"></span>
    </div>
     <div class="col-md-3">
         <div class="form-group">
            <label>{{ __('common.city') }} <span class="text-red">*</span></label>
            <select class="form-control nc_select" name="city" id="city" autocomplete="off">
                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                @foreach ($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
         </div>
         <span class="text-red" id="error_city"></span>
     </div>


     <div class="col-md-3">
         <div class="form-group">
            <label for="postal_code">{{ __('common.postal_code') }} <span class="text-red">*</span></label>
            <input type="text" class="form-control" id="postal_code" placeholder="{{ __('common.postal_code') }}" name="postal_code" value="{{isset($primary_address->postal_code)?$primary_address->postal_code:''}}" autocomplete="off" aria-autocomplete="none">
         </div>
         <span class="text-red" id="error_postcode"></span>
     </div>
     <div class="form_btn col-md-12 text-center">
         <button class="btn_1 float-none" type="submit">{{ __('common.save') }}</button>
     </div>
 </div>
</form>
