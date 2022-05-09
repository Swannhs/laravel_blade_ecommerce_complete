<div class="row">
    <div class="col-lg-12">
        <div class="main-title d-flex">
            <h3 class="mb-3 mr-30">{{ __('shipping.address_info') }}</h3>
        </div>
    </div>

    @if(\Session::has('inhouse_order_shipping_address'))
        <div class="col-lg-8">
            @php
                $shipping_address = \Session::get('inhouse_order_shipping_address');
                $shipping_country = \Modules\Setup\Entities\Country::find($shipping_address['shipping_country'])->name;
                $shipping_state = \Modules\Setup\Entities\State::find($shipping_address['shipping_state'])->name;
                $shipping_city = \Modules\Setup\Entities\City::find($shipping_address['shipping_city'])->name;
            @endphp


            <table class="table-borderless clone_line_table">
                <tr>
                    <td><strong>{{__('shipping.shipping_address')}}</strong></td>
                </tr>
                <tr>
                    <td>{{__('common.name')}}</td>
                    <td>: {{$shipping_address['shipping_name']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.email') }}</td>
                    <td>: {{$shipping_address['shipping_email']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.phone') }}</td>
                    <td>: {{$shipping_address['shipping_phone']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.address') }}</td>
                    <td>: {{$shipping_address['shipping_address']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.country') }}</td>
                    <td>: {{$shipping_country}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.state') }}</td>
                    <td>: {{$shipping_state}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.city') }}</td>
                    <td>: {{$shipping_city}}</td>
                </tr>
            </table>

            @if($shipping_address['is_bill_address'] == 1)
            @php
                $billing_address = \Session::get('inhouse_order_billing_address');
                $billing_country = \Modules\Setup\Entities\Country::find($billing_address['billing_country'])->name;
                $billing_state = \Modules\Setup\Entities\State::find($billing_address['billing_state'])->name;
                $billing_city = \Modules\Setup\Entities\City::find($billing_address['billing_city'])->name;
            @endphp
            <table class="table-borderless clone_line_table">
                <tr>
                    <td><strong>{{__('common.billing_address')}}</strong></td>
                </tr>
                <tr>
                    <td>{{__('common.name')}}</td>
                    <td>: {{$billing_address['billing_name']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.email') }}</td>
                    <td>: {{$billing_address['billing_email']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.phone') }}</td>
                    <td>: {{$billing_address['billing_phone']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.address') }}</td>
                    <td>: {{$billing_address['billing_address']}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.country') }}</td>
                    <td>: {{$billing_country}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.state') }}</td>
                    <td>: {{$billing_state}}</td>
                </tr>
                <tr>
                    <td>{{ __('common.city') }}</td>
                    <td>: {{$billing_city}}</td>
                </tr>
            </table>
            @else
                {{ __('shipping.bill_to_the_same_address') }}
            @endif
        </div>
        <div class="col-lg-4">
            <a href="" id="resetAddress" class="primary-btn fix-gr-bg">{{ __('shipping.reset_address') }}

            </a>
        </div>
    @else

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="name">{{ __('common.name') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="shipping_name" name="shipping_name"
                    autocomplete="off" value="" placeholder="{{ __('common.name') }}">


            <span class="text-danger" id="error_shipping_name"></span>

        </div>
    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="email">{{ __('common.email') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="shipping_email" name="shipping_email"
                    autocomplete="off" value="" placeholder="{{ __('common.email') }}">


            <span class="text-danger" id="error_shipping_email"></span>

        </div>
    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="phone">{{ __('common.phone_number') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="shipping_phone" name="shipping_phone"
                    autocomplete="off" value="" placeholder="{{ __('common.phone_number') }}">


            <span class="text-danger" id="error_shipping_phone"></span>

        </div>
    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="address">{{ __('common.address') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="shipping_address" name="shipping_address"
                    autocomplete="off" value="{{old('address')}}" placeholder="{{ __('common.address') }}">


            <span class="text-danger" id="error_shipping_address"></span>

        </div>
    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.country') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="shipping_country" id="shipping_country" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>
                @foreach ($countries as $key => $country)
                    <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach

            </select>
            <span class="text-danger"  id="error_shipping_country"></span>
        </div>
    </div>

    <div class="col-lg-6" id="stateDiv">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.state') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="shipping_state" id="shipping_state" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>

                @if(app('general_setting')->default_country != null)
                    @foreach ($states as $state)
                        <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger"  id="error_shipping_state"></span>
        </div>
    </div>

    <div class="col-lg-6" id="cityDiv">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.city') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="shipping_city" id="shipping_city" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>
                @foreach ($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach

            </select>
            <span class="text-danger"  id="error_shipping_city"></span>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="postcode">{{ __('common.postcode') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="shipping_postcode" name="shipping_postcode"
                    autocomplete="off" value="" placeholder="{{ __('common.postcode') }}">


            <span class="text-danger" id="error_shipping_postcode"></span>

        </div>

    </div>


    <div class="col-xl-12">
        <div class="primary_input">
            <ul id="theme_nav" class="permission_list sms_list ">
                <li>
                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                        <input class="is_billing_address" name="is_billing_address" id="is_billing_address" value="1" type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <p>{{ __('shipping.billing_address_is_not_as_same_as_shipping_address') }}</p>
                </li>
            </ul>
            <span class="text-danger" id=""></span>
        </div>
    </div>


    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="name">{{ __('common.name') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="billing_name" name="billing_name"
                    autocomplete="off" value="" placeholder="{{ __('common.name') }}">


            <span class="text-danger" id="error_billing_name"></span>

        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="email">{{ __('common.email') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="billing_email" name="billing_email"
                    autocomplete="off" value="" placeholder="{{ __('common.email') }}">


            <span class="text-danger" id="error_billing_email"></span>

        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="phone">{{ __('common.phone_number') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="billing_phone" name="billing_phone"
                    autocomplete="off" value="" placeholder="{{ __('common.phone_number') }}">


            <span class="text-danger" id="error_billing_phone"></span>

        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="address">{{ __('common.address') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="billing_address" name="billing_address"
                    autocomplete="off" value="" placeholder="{{ __('common.address') }}">


            <span class="text-danger" id="error_billing_address"></span>

        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.country') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="country" id="billing_country" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>
                @foreach ($countries as $key => $country)
                    <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach

            </select>
            <span class="text-danger"  id="error_billing_country"></span>
        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none" id="stateDiv">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.state') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="billing_state" id="billing_state" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>
                @if(app('general_setting')->default_country != null)
                    @foreach ($states as $state)
                        <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                    @endforeach
                @endif

            </select>
            <span class="text-danger"  id="error_billing_state"></span>
        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none" id="cityDiv">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="">{{ __('common.city') }} {{__('common.list')}} <span
                class="text-danger">*</span></label>
            <select name="billing_city" id="billing_city" class="primary_select address_dropdown mb-15">
                <option value="" selected disabled>{{__('common.select_one')}}</option>

                @foreach ($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
            <span class="text-danger"  id="error_billing_city"></span>
        </div>
    </div>

    <div class="col-lg-6 billing_address_field d-none">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="postcode">{{ __('common.postcode') }} <span
                        class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="billing_postcode" name="billing_postcode"
                    autocomplete="off" value="" placeholder="{{ __('common.postcode') }}">


            <span class="text-danger" id="error_billing_postcode"></span>

        </div>

    </div>

    <div class="col-lg-12">
        <button id="save_address_btn" type="button" class="primary-btn fix-gr-bg"
                data-toggle="tooltip" title="" data-original-title="">
                <span class="ti-check"></span>
                {{ __('common.save') }} </button>
    </div>

    @endif




</div>
