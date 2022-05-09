<!-- information_form  -->
<div class="main-title mb-25">
    <h3 class="mb-0">{{__('general_settings.company_information')}}</h3>
</div>
<form action="{{ route('company_information_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('general_settings.company_name')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="company_name" name="company_name"
                    value="{{ $setting->company_name }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.email')}}</label>
                <input class="primary_input_field" placeholder="-" type="email" id="email" name="email"
                    value="{{ $setting->email }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.phone_number')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="phone" name="phone"
                    value="{{ $setting->phone }}">
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.vat_number')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="vat_number" name="vat_number"
                    value="{{ $setting->vat_number }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.address')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="address" name="address"
                    value="{{ $setting->address }}">
            </div>
        </div>


        <div class="col-xl-6">
            <label class="primary_input_label" for="country">{{__('seller.country_region')}} <span class="text-danger">*</span></label>
            <select name="country_id" id="business_country" class="primary_select mb-25">
                <option value="" disabled selected>{{__('common.select_one')}}</option>
                @foreach($countries as $country)
                <option {{$setting->country_id == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-6">
            <label class="primary_input_label" for="state">{{__('common.state')}} <span class="text-danger">*</span></label>
            <select name="state_id" id="business_state" class="primary_select mb-25">
                <option value="" disabled selected>{{__('common.select_one')}}</option>
                @if($setting->country_id)
                    @foreach($states as $key => $state)
                    <option {{$setting->state_id== $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-xl-6">
            <label class="primary_input_label" for="city">{{__('common.city')}} <span class="text-danger">*</span></label>
            <select name="city_id" id="business_city" class="primary_select mb-25">
                <option value="" disabled selected>{{__('common.select_one')}}</option>

                @if($setting->state_id)
                    @foreach($cities as $key => $city)
                    <option {{$setting->city_id == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.zip_code')}}</label>
                <input class="primary_input_field" placeholder="-" type="text" id="zip_code" name="zip_code"
                    value="{{ $setting->zip_code }}">
            </div>
        </div>

        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{__('common.company_information_format')}}</label>
                <textarea class="primary_textarea" placeholder="{{__('common.company_information_format')}}" id="company_info" cols="30" rows="10"
                    name="company_info">{{ $setting->company_info }}</textarea>
            </div>
        </div>
    </div>
    @if (permissionCheck('company_information_update'))
    <div class="col-12 mb-10 pt_15">
        <div class="submit_btn text-center">
            <button class="primary_btn_large company_info_form_submit" type="submit"> <i
                    class="ti-check"></i>{{__('common.save')}} </button>
        </div>
    </div>
    @else
    <div class="col-lg-12 text-center mt-2">
        <span class="alert alert-warning" role="alert">
            <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
        </span>
    </div>
    @endif
</form>


<!--/ information_form  -->
