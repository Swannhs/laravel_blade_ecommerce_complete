<div id="shipping_address_modal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('defaultTheme.shipping')}} {{__('common.address')}}</h5>
                <button type="button" id="modal_add_new" class="transfarent-btn">{{__('add_new')}} {{__('common.address')}}</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="list_div" class="col-md-12">
                        <div class="address_list_div" id="address_list_div">
                            @include('frontend.default.partials._customer_address_list_shipping')
                        </div>

                    </div>


                    <div id="new_address_form_div" class="col-md-12 d-none-custom">
                        <form id="new_address_form">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="name">{{__('common.name')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="{{__('common.name')}}">
                                    <span class="new_address_name text-red"></span>
                                </div>

                                <div class="col-md-6">
                                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="email" placeholder="{{__('common.email_address')}}">
                                    <span class="new_address_email text-red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="phone_number"
                                        placeholder="{{__('common.phone_number')}}">
                                    <span class="new_address_phone text-red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="address" placeholder="{{__('common.address')}}">
                                    <span class="new_address_address text-red"></span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>{{__('common.country')}}</label> <span class="text-red">*</span>
                                    <select class="primary_select nc_select" name="country" id="shipping_country" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @foreach ($countries as $key => $country)
                                            <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="new_address_country text-red"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('common.state')}}</label> <span class="text-red">*</span>
                                    <select class="primary_select nc_select" name="state" id="shipping_state" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @if(app('general_setting')->default_country != null)
                                            @foreach ($states as $state)
                                                <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="new_address_state text-red"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('common.city')}}</label> <span class="text-red">*</span>
                                    <select class="nc_select primary_select" name="city" id="shipping_city" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="new_address_city text-red"></span>
                                </div>



                                <div class="col-md-6 form-group">
                                    <label for="address">{{__('common.postcode')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="postal_code"
                                        placeholder="{{__('common.postcode')}}">
                                    <span class="new_address_postal_code text-red"></span>

                                </div>



                                <div class="col-md-4 offset-md-4">
                                    <button href="javascript:void(0);" id="new_add_submit_btn"
                                        class="btn_1">{{__('common.save')}}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="billing_address_modal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal_header_billing">
                <h5 class="modal-title" id="exampleModalLabel">{{__('defaultTheme.billing')}} {{__('common.address')}}</h5>
                <button type="button" id="modal_add_new_billing" class="transfarent-btn">{{__('common.add_new')}} {{__('common.address')}}</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="list_div_billing" class="col-md-12">
                        <div class="address_list_div" id="address_list_div_billing">
                            @include('frontend.default.partials._customer_address_list_billing')
                        </div>

                    </div>


                    <div id="new_address_form_div_billing" class="col-md-12 d-none-custom">
                        <form id="new_address_form_billing">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="name">{{__('common.name')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="{{__('common.name')}}">
                                    <span class="new_address_name text-red"></span>
                                </div>

                                <div class="col-md-6">
                                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="email" name="email" placeholder="{{__('common.email_address')}}">
                                    <span class="new_address_email text-red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="phone_number"
                                        placeholder="{{__('common.phone_number')}}">
                                    <span class="new_address_phone text-red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="address" placeholder="{{__('common.address')}}">
                                    <span class="new_address_address text-red"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('common.country')}}</label> <span class="text-red">*</span>
                                    <select class="primary_select nc_select" name="country" id="billing_country" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @foreach ($countries as $key => $country)
                                            <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="new_address_country text-red"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('common.state')}}</label> <span class="text-red">*</span>
                                    <select class="primary_select nc_select" name="state" id="billing_state" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @if(app('general_setting')->default_country != null)
                                            @foreach ($states as $state)
                                                <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="new_address_state text-red"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('common.city')}}</label> <span class="text-red">*</span>
                                    <select class="primary_select nc_select" name="city" id="billing_city" autocomplete="off">
                                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="new_address_city text-red"></span>
                                </div>



                                <div class="col-md-6 form-group">
                                    <label for="postal_code">{{__('common.postcode')}} <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="postal_code"
                                        placeholder="{{__('common.postcode')}}">
                                    <span class="new_address_postal_code text-red"></span>

                                </div>



                                <div class="col-md-4 offset-md-4">
                                    <button href="javascript:void(0);" id="new_add_submit_btn_billing"
                                        class="btn_1">{{__('common.save')}}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





