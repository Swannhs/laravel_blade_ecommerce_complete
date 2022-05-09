@if (auth()->check())
    <div class="billing_address {{count($customer->customerAddresses)>0?'d-none':''}}">
        <h4>{{__('defaultTheme.shipping')}} & {{__('defaultTheme.billing')}} {{__('common.address')}}</h4>
        <div id="address_form">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="name">{{__('common.name')}} *</label> <span class="new_address_name text-red"></span>
                    <input class="form-control" type="text" id="address_name" name="name"
                        placeholder="{{__('common.name')}}">

                </div>

                <div class="col-md-6">
                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label> <span class="new_address_email text-red"></span>
                    <input class="form-control" type="text" id="address_email" name="email" placeholder="{{__('common.email_address')}}">

                </div>
                <div class="col-md-6">
                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label> <span class="new_address_phone text-red"></span>
                    <input class="form-control" type="text" id="address_phone" name="phone" placeholder="{{__('common.phone_number')}}">

                </div>
                <div class="col-md-6">
                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label> <span class="new_address_address text-red"></span>
                    <input class="form-control" type="text" id="address_address" name="address"
                        placeholder="{{__('common.address')}}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('common.country')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="country" id="address_country" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach($countries as $key => $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <span class="new_address_country text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.state')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="state" id="address_state" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>

                    </select>
                    <span class="new_address_state text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.city')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="city" id="address_city" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>

                    </select>
                    <span class="new_address_city text-red"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="address">{{__('common.postcode')}} <span class="text-red">*</span></label> <span class="new_address_postal_code text-red"></span>
                    <input class="form-control" type="text" id="address_postal_code" name="postal_code"
                        placeholder="{{__('common.postcode')}}">
                </div>

                <div class="col-md-4 offset-md-4">
                    <a href="javascript:void(0);" id="add_submit_btn" class="btn_1">{{__('common.save')}}</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="billing_address">
        <h4>{{__('defaultTheme.shipping')}} & {{__('defaultTheme.billing')}} {{__('common.address')}}</h4>
        <div id="address_form">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="name">{{__('common.name')}} *</label> <span class="new_address_name text-red"></span>
                    <input class="form-control" type="text" id="address_name" name="name"
                        placeholder="{{__('common.name')}}">

                </div>

                <div class="col-md-6">
                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label> <span class="new_address_email text-red"></span>
                    <input class="form-control" type="text" id="address_email" name="email" placeholder="{{__('common.email_address')}}">

                </div>
                <div class="col-md-6">
                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label> <span class="new_address_phone text-red"></span>
                    <input class="form-control" type="text" id="address_phone" name="phone" placeholder="{{__('common.phone_number')}}">

                </div>
                <div class="col-md-6">
                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label> <span class="new_address_address text-red"></span>
                    <input class="form-control" type="text" id="address_address" name="address"
                        placeholder="{{__('common.address')}}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('common.country')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="country" id="address_country" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach($countries as $key => $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <span class="new_address_country text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.state')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="state" id="address_state" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>

                    </select>
                    <span class="new_address_state text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.city')}} <span class="text-red">*</span></label>
                    <select class="form-control nc_select" name="city" id="address_city" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>

                    </select>
                    <span class="new_address_city text-red"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="address">{{__('common.postcode')}} <span class="text-red">*</span></label> <span class="new_address_postal_code text-red"></span>
                    <input class="form-control" type="text" id="address_postal_code" name="postal_code"
                        placeholder="{{__('common.postcode')}}">
                </div>

                <div class="col-md-4 offset-md-4">
                    <a href="javascript:void(0);" id="add_submit_btn" class="btn_1">{{__('common.save')}}</a>
                </div>
            </div>
        </div>
    </div>
@endif
