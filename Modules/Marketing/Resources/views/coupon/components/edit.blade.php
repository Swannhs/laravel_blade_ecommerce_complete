<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{ __('common.edit') }} {{ __('common.coupon') }} </h3>
        </div>
    </div>
</div>
<div class="row">
    <div id="formHtml" class="col-lg-12">
        <div class="white-box">
            <form action="" id="edit_form">
                <div class="add-visitor">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="coupon_type">{{ __('marketing.coupon_type') }} <span
                                    class="text-danger">*</span></label>
                                <select name="coupon_type" id="coupon_type" class="primary_select mb-15" disabled>

                                    <option selected value="{{$coupon->coupon_type}}">
                                        @if($coupon->coupon_type == 1)
                                        {{__('marketing.product_base')}}
                                        @elseif($coupon->coupon_type == 2)
                                        {{__('marketing.order_base')}}
                                        @elseif($coupon->coupon_type == 3)
                                        {{__('marketing.free_shipping')}}
                                        @endif
                                    </option>

                                </select>
                                <span class="text-danger" id="error_coupon_type"></span>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="coupon_title">{{ __('common.title') }} <span
                                        class="text-danger">*</span></label>
                                <input class="primary_input_field" type="text" id="coupon_title" name="coupon_title"
                                    autocomplete="off" value="{{$coupon->title}}" placeholder="{{ __('common.title') }}">
                                    <span class="text-danger" id="error_coupon_title"></span>
                            </div>


                        </div>


                    </div>
                    <input type="hidden" name="id" value="{{$coupon->id}}">
                    <div id="formDataDiv">
                        @if($coupon->coupon_type == 1)
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="ml-10">{{__('marketing.add_coupon_based_on_products')}}</h4>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="coupon_code">{{ __('marketing.coupon_code') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="coupon_code" name="coupon_code"
                                        autocomplete="off" value="{{$coupon->coupon_code}}" placeholder="{{ __('marketing.coupon_code') }}">
                                        <span class="text-danger" id="error_coupon_code"></span>
                                </div>


                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="all_user">{{ __('common.products') }} <span
                                        class="text-danger">*</span></label>
                                    <select name="product_list[]" id="product_list" class="primary_select mb-15"
                                        multiple>
                                        <option disabled>{{ __('common.select') }}</option>

                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        @if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff')
                                            @foreach($products as $key => $product)
                                                <option @if($coupon->products->where('product_id',$product->id)->where('coupon_id',$coupon->id)->first()) selected @endif value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [@if($product->seller->role->type == 'seller') {{$product->seller->first_name}} @else Inhouse @endif] @endif</option>
                                            @endforeach
                                        @elseif($user->role->type == 'seller')
                                            @foreach($products->where('user_id', $user->id) as $key => $product)
                                                <option @if($coupon->products->where('product_id',$product->id)->where('coupon_id',$coupon->id)->first()) selected @endif value="{{$product->id}}">{{$product->product_name}}</option>
                                            @endforeach

                                        @endif
                                    </select>
                                    <span class="text-danger" id="error_products"></span>
                                </div>


                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('common.date')}} <span
                                        class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{__('common.date')}}" class="primary_input_field primary-input form-control" id="date" type="text" value="{{date('d-m-Y',strtotime($coupon->start_date)).' to '.date('d-m-Y',strtotime($coupon->end_date))}}" name="date" autocomplete="off" readonly>
                                                </div>
                                                <input type="hidden" name="start_date" id="start_date" value="{{date('d-m-Y',strtotime($coupon->start_date))}}">
                                                <input type="hidden" name="end_date" id="end_date" value="{{date('d-m-Y',strtotime($coupon->end_date))}}">
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="error_date"></span>
                                </div>


                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="discount">{{ __('common.discount') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" name="discount" id="discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$coupon->discount}}">
                                    <span class="text-danger" id="error_discount"></span>
                                </div>


                            </div>

                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="title">{{ __('common.discount_type') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="primary_input mb-25">
                                        <select class="primary_select mb-25" name="discount_type" id="discount_type">
                                            <option {{$coupon->discount_type == 1?'selected':''}} value="1">{{ __('common.amount') }}</option>
                                            <option {{$coupon->discount_type == 0?'selected':''}}  value="0">{{ __('common.percentage') }}</option>
                                        </select>
                                        <span class="text-danger" id="error_discount_type"></span>
                                    </div>
                                </div>


                            </div>
                        </div>
                        @elseif($coupon->coupon_type == 2)
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="ml-10">{{__('marketing.add_coupon_based_on_order')}}</h4>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="coupon_code">{{ __('marketing.coupon_code') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="coupon_code" name="coupon_code"
                                        autocomplete="off" value="{{$coupon->coupon_code}}" placeholder="{{ __('marketing.coupon_code') }}">
                                    <span class="text-danger" id="error_coupon_code"></span>
                                </div>


                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="minimum_shopping">{{ __('marketing.minimum_shopping') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" id="minimum_shopping" name="minimum_shopping"
                                        autocomplete="off"  placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$coupon->minimum_shopping}}">
                                    <span class="text-danger" id="error_minimum_shopping"></span>

                                </div>


                            </div>

                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('common.date')}} <span
                                        class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{__('common.date')}}" class="primary_input_field primary-input form-control" id="date" type="text" value="{{date('d-m-Y',strtotime($coupon->start_date)).' to '.date('d-m-Y',strtotime($coupon->end_date))}}" name="date" autocomplete="off" readonly>
                                                </div>
                                                <input type="hidden" name="start_date" id="start_date" value="{{date('d-m-Y',strtotime($coupon->start_date))}}">
                                                <input type="hidden" name="end_date" id="end_date" value="{{date('d-m-Y',strtotime($coupon->end_date))}}">
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="error_date"></span>
                                </div>


                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="maximum_discount">{{ __('marketing.maximum_discount') }}</label>
                                    <input class="primary_input_field" id="maximum_discount" name="maximum_discount"
                                        autocomplete="off"  placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$coupon->maximum_discount}}">
                                    <span class="text-danger" id="error_maximum_discount"></span>
                                </div>


                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="discount">{{ __('common.discount') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" name="discount" id="discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$coupon->discount}}">
                                    <span class="text-danger" id="error_discount"></span>
                                </div>


                            </div>

                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="discount_type">{{ __('common.discount_type') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="primary_input mb-25">
                                        <select class="primary_select mb-25" name="discount_type" id="discount_type">
                                            <option {{$coupon->discount_type == 1?'selected':''}} value="1">{{ __('common.amount') }}</option>
                                            <option {{$coupon->discount_type == 0?'selected':''}}  value="0">{{ __('common.percentage') }}</option>
                                        </select>
                                        <span class="text-danger" id="error_discount_type"></span>
                                    </div>
                                </div>


                            </div>
                        </div>
                        @elseif($coupon->coupon_type == 3)
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="ml-10">{{__('marketing.add_coupon_for_free_shipping')}}</h4>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="coupon_code">{{ __('marketing.coupon_code') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="coupon_code" name="coupon_code"
                                        autocomplete="off" value="{{$coupon->coupon_code}}" placeholder="{{ __('marketing.coupon_code') }}">
                                    <span class="text-danger" id="error_coupon_code"></span>
                                </div>


                            </div>

                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('common.date')}} <span
                                        class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{__('common.date')}}" class="primary_input_field primary-input form-control" id="date" type="text" name="date" value="{{date('d-m-Y',strtotime($coupon->start_date)).' to '.date('d-m-Y',strtotime($coupon->end_date))}}" autocomplete="off" readonly>
                                                </div>
                                                <input type="hidden" name="start_date" id="start_date" value="{{date('d-m-Y',strtotime($coupon->start_date))}}">
                                                <input type="hidden" name="end_date" id="end_date" value="{{date('d-m-Y',strtotime($coupon->end_date))}}">
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="error_date"></span>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="maximum_discount">{{ __('marketing.maximum_discount') }}</label>
                                    <input class="primary_input_field" name="maximum_discount" id="maximum_discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$coupon->maximum_discount}}">
                                    <span class="text-danger" id="error_maximum_discount"></span>
                                </div>



                            </div>


                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input">
                                    <ul id="theme_nav" class="permission_list sms_list ">
                                        <li>
                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                <input name="is_multiple" {{$coupon->is_multiple_buy == 1?'checked':''}} id="is_multiple" value="1" type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('marketing.allow_multiple_buy') }}</p>
                                        </li>
                                    </ul>
                                    <span class="text-danger" id="is_featured_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                data-toggle="tooltip" title="" data-original-title="">
                                <span class="ti-check"></span>
                                {{ __('common.update') }} </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


