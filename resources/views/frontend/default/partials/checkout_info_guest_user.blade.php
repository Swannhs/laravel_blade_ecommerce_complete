
@php
    $existDigital = 0;
@endphp
<div class="col-lg-7">
    <div class="billing_address @if (session()->has('billing_address')) d-none @endif">
        <h4>{{__('defaultTheme.billing')}} {{__('common.address')}}</h4>
        <div id="billing_address_form_guest">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="name">{{__('common.name')}} <span class="text-red">*</span></label>
                    <input class="form-control" type="text" id="address_name" name="name"
                        placeholder="{{__('common.name')}}">

                </div>

                <div class="col-md-6">
                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label> <span
                        class="new_address_email text-red"></span>
                    <input class="form-control" type="text" id="address_email" name="email"
                        placeholder="{{__('common.email_address')}}">

                </div>
                <div class="col-md-6">
                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label> <span
                        class="new_address_phone text-red"></span>
                    <input class="form-control" type="text" id="address_phone" name="phone"
                        placeholder="{{__('common.phone_number')}}">

                </div>
                <div class="col-md-6">
                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label> <span
                        class="new_address_address text-red"></span>
                    <input class="form-control" type="text" id="address_address" name="address"
                        placeholder="{{__('common.address')}}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('common.country')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="country" id="address_country" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach ($countries as $key => $country)
                            <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <span class="new_address_country text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.state')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="state" id="address_state" autocomplete="off">
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
                    <label>{{__('common.city')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="city" id="address_city" autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <span class="new_address_city text-red"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="address">{{__('common.postcode')}} <span class="text-red">*</span></label> <span
                        class="new_address_postal_code text-red"></span>
                    <input class="form-control" type="text" id="address_postal_code" name="postal_code"
                        placeholder="{{__('common.postcode')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="extra-checkbox @if (session()->has('billing_address')) d-none @endif">
        <label class="cs_checkbox mr-3">
            <input id="check_shipping_address" type="checkbox" value="0" name="check_shipping_address">
            <span class="checkmark"></span>
        </label>
        <p class="pl-4 ml-2">{{ __('defaultTheme.billing_address_is_not_as_same_as_shipping_address') }}</p>
    </div>
    <div class="shipping_address_div billing_address mt-5 d-none @if (session()->has('billing_address')) d-none @endif">
        <h4>{{__('defaultTheme.shipping')}} {{__('common.address')}}</h4>
        <div id="shipping_address_form_guest">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="name">{{__('common.name')}} <span class="text-red">*</span></label> <span
                    class="shipping_address_name text-red"></span>
                    <input class="form-control" type="text" id="shipping_address_name" name="shipping_adress_name"
                        placeholder="{{__('common.name')}}">
                </div>

                <div class="col-md-6">
                    <label for="email">{{__('common.email_address')}} <span class="text-red">*</span></label> <span
                        class="shipping_address_email text-red"></span>
                    <input class="form-control" type="text" id="shipping_address_email" name="shipping_adress_email"
                        placeholder="{{__('common.email_address')}}">
                </div>
                <div class="col-md-6">
                    <label for="phone">{{__('common.phone_number')}} <span class="text-red">*</span></label> <span
                        class="shipping_address_phone text-red"></span>
                    <input class="form-control" type="text" id="shipping_address_phone" name="shipping_adress_phone"
                        placeholder="{{__('common.phone_number')}}">
                </div>
                <div class="col-md-6">
                    <label for="address">{{__('common.address')}} <span class="text-red">*</span></label> <span
                        class="shipping_address_address text-red"></span>
                    <input class="form-control" type="text" id="shipping_address_address" name="shipping_adress_address"
                        placeholder="{{__('common.address')}}">
                </div>

                <div class="col-md-6 form-group">
                    <label>{{__('common.country')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="shipping_adress_country" id="shipping_address_country"
                        autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach ($countries as $key => $country)
                            <option value="{{ $country->id }}" @if(app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <span class="shipping_adress_country text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.state')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="shipping_adress_state" id="shipping_address_state"
                        autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @if(app('general_setting')->default_country != null)
                            @foreach ($states as $state)
                                <option value="{{$state->id}}" @if(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="shipping_adress_state text-red"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{__('common.city')}} <span class="text-red">*</span></label>
                    <select class="primary_select nc_select" name="shipping_adress_city" id="shipping_address_city"
                        autocomplete="off">
                        <option value="">{{__('defaultTheme.select_from_options')}}</option>
                        @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <span class="shipping_adress_city text-red"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="address">{{__('common.postcode')}} <span class="text-red">*</span></label> <span
                        class="shipping_address_postal_code text-red"></span>
                    <input class="form-control" type="text" id="shipping_address_postal_code"
                        name="shipping_adress_postal_code" placeholder="{{__('common.postcode')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="form-row @if (session()->has('billing_address')) d-none @endif">
        <div class="col-md-4 offset-md-4">
            <a href="javascript:void(0);" id="guest_add_submit_btn" class="btn_1">{{__('common.save')}}</a>
        </div>
    </div>
    <div class="row">

        @php
            $items = 0;
            $index = 0;
            $totalItem = 0;
            $subtotal = 0;
            $actualtotal = 0;
            $shippingtotal = 0;
            $empty_check = 0;
            $taxAmount = 0;
            $total_product = 0;
            foreach ($cartData as $data) {
                $empty_check += count($data);
                $items += count($data);

                foreach($data as $products){
                    foreach($products as $product){
                        $total_product += $product['qty'];
                    }
                }
            }

            $gstAmountTotal = 0;
        @endphp

        <div class="col-lg-12">
            <div class="card main_card">
                <div class="main_card_header card-header d-flex justify-content-between">
                    <strong>{{__('common.total_items')}}({{$total_product}})</strong>
                    <strong>{{__('common.price')}}</strong>
                    <strong>{{__('common.quantity')}}</strong>
                    <strong>{{__('common.total_price')}}</strong>
                </div>
            </div>
        </div>

        @foreach($cartData as $key => $cartItems)
            @php

                $seller = App\Models\User::where('id',$key)->first();

            @endphp

            @foreach($cartItems as $key => $cartItems)
                @php
                $addtional_charge = 0;
                    foreach($cartItems as $item){
                        if ($item['product_type'] != "gift_card") {
                            $seller_product_sku = Modules\Seller\Entities\SellerProductSKU::findOrFail($item['product_id']);
                            $addtional_charge += $seller_product_sku->sku->additional_shipping;
                        }
                    }
                    $index ++;
                    $shipping_method = Modules\Shipping\Entities\ShippingMethod::findOrFail($item['shipping_method_id']);
                    $shippingtotal += $shipping_method->cost + $addtional_charge;
                    $package_wise_shipping_cost = $shipping_method->cost + $addtional_charge;
                @endphp

                <div class="col-lg-12">
                    <div class="package_div">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="delivery_title">{{__('common.package')}} {{$index}} {{__('common.of')}} {{$items}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="d-inline font-weight-400">{{__('defaultTheme.shippied_by')}}:</p>
                                        <p class="d-inline delivery_title"><strong>@if($seller->role->type == 'seller'){{$seller->first_name .' '. $seller->last_name}} @else {{ app('general_setting')->company_name }} @endif</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="delivery_title">{{__('defaultTheme.delivery_option')}}</p>
                                        <div class="delivery_des_div">
                                            <ul class="delivery_des_ul">

                                                <li>{{single_price($shipping_method->cost)}}</li>
                                                @if($addtional_charge > 0)
                                                <li>
                                                    {{__('defaultTheme.addtional_shipping_charge')}}:
                                                    {{single_price($addtional_charge)}}
                                                </li>
                                                @endif
                                                <li>{{$shipping_method->method_name}}</li>
                                                <li>

                                                    @php
                                                    $shipment_time = $shipping_method->shipment_time;
                                                    $shipment_time = explode(" ", $shipment_time);
                                                    $dayOrOur = $shipment_time[1];

                                                    $shipment_time = explode("-", $shipment_time[0]);
                                                    $start_ = $shipment_time[0];
                                                    $end_ = $shipment_time[1];
                                                    $date = date('d-m-Y');
                                                    $start_date = date('d M', strtotime($date. '+ '.$start_.' '.$dayOrOur));
                                                    $end_date = date('d M', strtotime($date. '+ '.$end_.' '.$dayOrOur));
                                                    @endphp
                                                    @if($dayOrOur == 'days' || $dayOrOur == 'Days' ||$dayOrOur == 'Day')
                                                    {{__('Est arrival date')}}: {{$start_date}} - {{$end_date}}
                                                    @elseif($dayOrOur == 'hrs' || $dayOrOur == 'Hrs')
                                                    {{__('Est arrival time')}}: {{$shipping_method->shipment_time}}
                                                    @else

                                                    @endif
                                                </li>
                                                <input type="hidden" name="shipping_cost[]" value="{{$package_wise_shipping_cost}}">
                                                <input type="hidden" name="shipping_method[]" value="{{$shipping_method->id}}">
                                                <input type="hidden" name="delivery_date[]"
                                                    value="@if($dayOrOur == 'days' || $dayOrOur == 'Days' ||$dayOrOur == 'Day'){{__('Est arrival date')}}: {{$start_date}} - {{$end_date}}@elseif($dayOrOur == 'hrs' || $dayOrOur == 'Hrs'){{__('Est arrival time')}}: {{$shipping_method->shipment_time}}@else @endif">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @if (file_exists(base_path().'/Modules/GST/'))
                                            @if (session()->has('billing_address') && app('gst_config')['enable_gst'] == "gst")
                                                <p class="delivery_title">{{__('gst.gst')}} ({{ __('gst.goods_and_services_tax') }})</p>
                                                <div class="delivery_des_div">
                                                    <ul class="delivery_des_ul">
                                                        @php
                                                            if (session()->get('billing_address')['check_shipping_address'] == 0) {
                                                                $shipping_address = session()->get('billing_address');
                                                                $shipping_state = session()->get('billing_address')['state'];
                                                            }else {
                                                                $shipping_address = session()->get('shipping_address');
                                                                $shipping_state = session()->get('shipping_address')['shipping_state'];
                                                            }
                                                            $billing_address = session()->get('billing_address');
                                                        @endphp
                                                         @if($seller->role->type == "admin")
                                                         @if (app('general_setting')->state_id == $shipping_state)
                                                            @php
                                                            $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id',
                                                            app('gst_config')['within_a_single_state'])->get();
                                                            @endphp
                                                                @foreach ($sameStateTaxes as $key => $sameStateTax)
                                                                    @php
                                                                        $gstAmount = $cartItems->sum('total_price') * $sameStateTax->tax_percentage / 100;
                                                                        $gstAmountTotal += $gstAmount;
                                                                    @endphp
                                                                    <li>{{ $sameStateTax->name }}({{ $sameStateTax->tax_percentage }} %) :
                                                                        {{ single_price($gstAmount) }}</li>
                                                                    <input type="hidden" name="gst_package_{{ $index }}[]" value="{{ $sameStateTax->id }}">
                                                                    <input type="hidden" name="gst_amounts_package_{{ $index }}[]" value="{{ $gstAmount }}">
                                                                @endforeach
                                                            @else
                                                            @php
                                                                $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id',
                                                                app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                                                            @endphp
                                                            @foreach ($diffStateTaxes as $key => $diffStateTax)
                                                                @php
                                                                    $gstAmount = $cartItems->sum('total_price') * $diffStateTax->tax_percentage / 100;
                                                                    $gstAmountTotal += $gstAmount;
                                                                @endphp
                                                                <input type="hidden" name="gst_package_{{ $index }}[]" value="{{ $diffStateTax->id }}">
                                                                <input type="hidden" name="gst_amounts_package_{{ $index }}[]" value="{{ $gstAmount }}">
                                                                <li>{{ $diffStateTax->name }}({{ $diffStateTax->tax_percentage }} %) :
                                                                    {{ single_price($gstAmount) }}</li>
                                                            @endforeach
                                                            @endif
                                                         @else
                                                            @if ($seller->SellerBusinessInformation->business_state == $shipping_state)

                                                            @php
                                                            $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id',
                                                            app('gst_config')['within_a_single_state'])->get();
                                                            @endphp
                                                                @foreach ($sameStateTaxes as $key => $sameStateTax)
                                                                    @php
                                                                        $gstAmount = $cartItems->sum('total_price') * $sameStateTax->tax_percentage / 100;
                                                                        $gstAmountTotal += $gstAmount;
                                                                    @endphp
                                                                    <li>{{ $sameStateTax->name }}({{ $sameStateTax->tax_percentage }} %) :
                                                                        {{ single_price($gstAmount) }}</li>
                                                                    <input type="hidden" name="gst_package_{{ $index }}[]" value="{{ $sameStateTax->id }}">
                                                                    <input type="hidden" name="gst_amounts_package_{{ $index }}[]" value="{{ $gstAmount }}">
                                                                @endforeach
                                                            @else
                                                            @php
                                                                $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id',
                                                                app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                                                            @endphp
                                                            @foreach ($diffStateTaxes as $key => $diffStateTax)
                                                                @php
                                                                    $gstAmount = $cartItems->sum('total_price') * $diffStateTax->tax_percentage / 100;
                                                                    $gstAmountTotal += $gstAmount;
                                                                @endphp
                                                                <input type="hidden" name="gst_package_{{ $index }}[]" value="{{ $diffStateTax->id }}">
                                                                <input type="hidden" name="gst_amounts_package_{{ $index }}[]" value="{{ $gstAmount }}">
                                                                <li>{{ $diffStateTax->name }}({{ $diffStateTax->tax_percentage }} %) :
                                                                    {{ single_price($gstAmount) }}</li>
                                                            @endforeach
                                                            @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                            @else
                                                <p class="delivery_title">{{__('gst.gst')}} ({{ __('gst.flat_tax') }})</p>
                                                <div class="delivery_des_div">
                                                    @php
                                                        $flatTax = \Modules\GST\Entities\GstTax::where('id',
                                                        app('gst_config')['flat_tax_id'])->first();
                                                        $gstAmount = $cartItems->sum('total_price') * $flatTax->tax_percentage / 100;
                                                        $gstAmountTotal += $gstAmount;
                                                    @endphp
                                                    <ul class="delivery_des_ul">
                                                        <input type="hidden" name="gst_package_{{ $index }}[]" value="{{ $flatTax->id }}">
                                                        <input type="hidden" name="gst_amounts_package_{{ $index }}[]" value="{{ $gstAmount }}">
                                                        <li>{{ $flatTax->name }}({{ $flatTax->tax_percentage }} %) :
                                                            {{ single_price($gstAmount) }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>



                                @php
                                $packagewiseTax = 0;
                                @endphp

                                @foreach($cartItems as $key => $item)
                                @if ($item['product_type'] == "gift_card")
                                @php
                                $seller_product_sku =
                                \Modules\GiftCard\Entities\GiftCard::where('id',$item['product_id'])->first();
                                @endphp
                                <div class="single_product_div">
                                    <div class="row">
                                        <div class="col-md-2 single_img_div">
                                            <img src="{{asset(asset_path(@$seller_product_sku->thumbnail_image))}}" alt="#" />
                                        </div>
                                        <div class="col-md-4 single_product_name_div">
                                            <p class="name_p"><strong>{{$seller_product_sku->name}}</strong></p>
                                        </div>
                                        <div class="col-md-2 single_product_price_div">
                                            @php
                                                $product = $seller_product_sku;
                                                $totalItem += $item['qty'];
                                                $subtotal += $product->selling_price * $item['qty'];
                                                $actualtotal += $item['total_price'];
                                            @endphp

                                            <div class="price_with_dis">
                                                @if($product->hasDiscount())
                                                    @if($product->discount_type == 0)
                                                        <span class="offer_prise">-{{$product->discount}}%</span>
                                                    @else
                                                        <span class="offer_prise">-{{single_price($product->discount)}}</span>
                                                    @endif
                                                    <span class="curent_prise selling_original_price">{{single_price($product->selling_price)}}</span>
                                                @else
                                                    <span class="curent_prise price_rate">{{single_price($product->selling_price)}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-1 single_product_qty_div">
                                            <p class="qty_p">{{__('common.qty')}}: {{$item['qty']}}</p>
                                        </div>
                                        <div class="col-md-3 d-flex tax_price_sec">
                                            <div class="price_tax_div">
                                                <input type="hidden" name="tax_amount[]" value="0">
                                                <p>{{__('common.tax')}} : 0 %</p>
                                                <p>{{__('defaultTheme.tax_amount')}} : {{single_price(0)}}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @else
                                    @php
                                        $seller_product_sku = Modules\Seller\Entities\SellerProductSKU::findOrFail($item['product_id']);
                                    @endphp
                                    @if ($seller_product_sku->product->product->is_physical == 0)
                                        @php
                                            $existDigital = 1;
                                        @endphp
                                    @endif
                                    <div class="single_product_div">
                                        <div class="row">
                                            <div class="col-md-2 single_img_div">
                                                <img src="
                                                            @if(@$seller_product_sku->product->product->product_type == 1)
                                                                {{asset(asset_path(@$seller_product_sku->product->product->thumbnail_image_source))}}
                                                            @else
                                                                {{asset(asset_path(@$seller_product_sku->sku->variant_image?@$seller_product_sku->sku->variant_image:@$seller_product_sku->product->product->thumbnail_image_source))}}
                                                            @endif
                                                            " alt="#" />
                                            </div>
                                            <div class="col-md-4 single_product_name_div">
                                                <p class="name_p"><strong>{{$seller_product_sku->product->product->product_name}}</strong></p>
                                                @if($seller_product_sku->product->product->product_type == 2)
                                                <p class="variation_name">
                                                    @php
                                                    $countCombinatiion = count(@$seller_product_sku->product_variations);
                                                    @endphp
                                                    @foreach($seller_product_sku->product_variations as $key => $combination)
                                                    @if($combination->attribute->name == 'Color')
                                                    {{$combination->attribute->name}}:
                                                    {{$combination->attribute_value->color->name}}
                                                    @else
                                                    {{$combination->attribute->name}}: {{$combination->attribute_value->value}}
                                                    @endif

                                                    @if($countCombinatiion > $key +1)
                                                    ,
                                                    @endif
                                                    @endforeach


                                                </p>
                                                @endif
                                            </div>
                                            <div class="col-md-2 single_product_price_div">
                                                @php
                                                $taxAmount += tax_count($item['price'], $seller_product_sku->product->tax,
                                                $seller_product_sku->product->tax_type) * $item['qty'];

                                                $product =
                                                \Modules\Seller\Entities\SellerProductSKU::where('id',$seller_product_sku->id)->first();
                                                $totalItem += $item['qty'];
                                                $subtotal += $product->selling_price * $item['qty'];
                                                $actualtotal += $item['total_price'];
                                                @endphp
                                                <div class="price_with_dis">
                                                    @if($product->product->hasDeal)
                                                        @if($product->product->hasDeal->discount > 0)
                                                            @if($product->product->hasDeal->discount_type == 0)
                                                                <span class="offer_prise">-{{$product->product->hasDeal->discount}} %</span>
                                                                <span class="curent_prise selling_original_price">{{single_price($product->selling_price)}}</span>
                                                            @else

                                                                <span class="offer_prise">-{{single_price($product->product->hasDeal->discount)}}</span>
                                                                <span class="curent_prise selling_original_price">{{single_price($product->selling_price)}}</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if(@$product->product->hasDiscount == 'yes')
                                                            @if($product->product->discount_type == 0)
                                                                <span class="offer_prise">-{{$product->product->discount}} %</span>
                                                                <span class="curent_prise selling_original_price">{{single_price($product->selling_price)}}</span>
                                                            @else
                                                                <span class="offer_prise">-{{single_price($product->product->discount)}}</span>
                                                                <span class="curent_prise selling_original_price">{{single_price($product->selling_price)}}</span>
                                                            @endif
                                                        @else
                                                            <span class="curent_prise price_rate">{{single_price($product->selling_price)}}</span>
                                                        @endif
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-1 single_product_qty_div">
                                                <p class="qty_p">{{__('common.qty')}}: {{$item['qty']}}</p>
                                            </div>
                                            <div class="col-md-3 d-flex tax_price_sec">
                                                <div class="price_tax_div">
                                                    <input type="hidden" name="tax_amount[]"
                                                        value="{{tax_count($item['price'], $seller_product_sku->product->tax, $seller_product_sku->product->tax_type) * $item['qty']}}">
                                                    <p>{{__('common.tax')}} : @if($seller_product_sku->product->tax_type == 0)
                                                        {{$seller_product_sku->product->tax}} % @else
                                                        {{single_price($seller_product_sku->product->tax)}} @endif</p>
                                                    <p>{{__('defaultTheme.tax_amount')}} :
                                                        {{single_price(tax_count($item['price'], $seller_product_sku->product->tax, $seller_product_sku->product->tax_type) * $item['qty'])}}
                                                    </p>
                                                    <p>{{__('common.total')}}: {{single_price($item['total_price'])}}</p>
                                                    @php
                                                        $packagewiseTax += tax_count($item['price'], $seller_product_sku->product->tax,
                                                        $seller_product_sku->product->tax_type) * $item['qty'];
                                                    @endphp
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @endforeach
                                <input type="hidden" name="packagewiseTax[]" value="{{$packagewiseTax}}">

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

    </div>
</div>
<div class="col-lg-3">
    <div class="billing_address">
        @if(session()->has('billing_address'))
        @php
        if (session()->has('shipping_address')) {
        $shipping_address = session()->get('shipping_address');
        }
        $billing_address = session()->get('billing_address');
        @endphp
        <h4>{{__('defaultTheme.shipping')}} & {{__('defaultTheme.billing')}} {{__('common.address')}}</h4>

        <div class="shipping_information">
            <div class="row no-gutters" id="old_customer_email_div">
                <div class="col-md-8">
                    <p>{{ (session()->get('shipping_address')) ? $shipping_address['shipping_email'] : $billing_address['email'] }}
                    </p>
                    <input type="hidden" name="guest_shipping_email" id="guest_shipping_email"
                        value="{{ (session()->get('shipping_address')) ? $shipping_address['shipping_email'] : $billing_address['email'] }}">
                </div>
                <div class="col-md-4">
                    <button type="button" class="transfarent-btn float-right email_hide_how">
                        {{__('common.edit')}}</button>
                </div>
            </div>
            <div class="row d-none" id="new_customer_email_div">
                <div class="col-md-8">
                    <input type="email" name="guest_shipping_email_new" class="form-control"
                        id="guest_shipping_email_new" placeholder="{{__('common.email_address')}}"
                        value="{{ (session()->get('shipping_address')) ? $shipping_address['shipping_email'] : $billing_address['email'] }}"
                        autocomplete="off">

                </div>
                <div class="col-md-4">
                    <button type="button" class="btn_1 float-right" id="guest_shipping_email_new_btn">
                        {{__('common.save')}}</button>
                </div>
            </div>
            <div class="row" id="old_customer_phone_div">
                <div class="col-md-8">
                    <p>{{ (session()->get('shipping_address')) ? $shipping_address['shipping_phone'] : $billing_address['phone'] }}
                    </p>
                    <input type="hidden" name="guest_shipping_phone" id="guest_shipping_phone"
                        value="{{ (session()->get('shipping_address')) ? $shipping_address['shipping_phone'] : $billing_address['phone'] }}">
                </div>
                <div class="col-md-4">
                    <button type="button" class="transfarent-btn float-right phone_hide_show">
                        {{__('common.edit')}}</button>
                </div>
            </div>

            <div class="row d-none" id="new_customer_phone_div">
                <div class="col-md-8">
                    <input type="text" name="guest_shipping_phone_new" class="form-control"
                        id="guest_shipping_phone_new" placeholder="{{__('common.phone_number')}}"
                        value="{{ (session()->get('shipping_address')) ? $shipping_address['shipping_phone'] : $billing_address['phone'] }}">

                </div>
                <div class="col-md-4">
                    <button type="button" class="btn_1 float-right" id="guest_shipping_phone_new_btn">
                        {{__('common.save')}}</button>
                </div>
            </div>
        </div>
        @endif

        <div class="order_information">
            <h5>{{ __('common.summary') }}</h5>
            @php
            $discounttotal = $subtotal - $actualtotal;
            $grandtotal = $subtotal + $shippingtotal - $discounttotal + $gstAmountTotal;

            $coupon = 0;
            $coupon_id = null;
            if(auth()->check() && \Session::has('coupon_type')&&\Session::has('coupon_discount')){
            $coupon_type = \Session::get('coupon_type');
            $coupon_discount = \Session::get('coupon_discount');
            $coupon_discount_type = \Session::get('coupon_discount_type');
            $coupon_id = \Session::get('coupon_id');
            if($coupon_type == 1){
            $couponProducts = \Session::get('coupon_products');
            if($coupon_discount_type == 0){
            foreach($couponProducts as $key => $item){
            $cart =
            App\Models\Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_id',$item)->first();
            $coupon += ($cart->total_price/100)* $coupon_discount;
            }
            }else{

            $coupon = $coupon_discount;
            }

            }
            elseif($coupon_type == 2){
            if($coupon_discount_type == 0){

            $maximum_discount = \Session::get('maximum_discount');
            $coupon = ($grandtotal/100)* $coupon_discount;

            if($coupon > $maximum_discount){
            $coupon = $maximum_discount;
            }
            }else{
            $coupon = $coupon_discount;
            }
            }
            elseif($coupon_type == 3){
            $maximum_discount = \Session::get('maximum_discount');
            $coupon = $coupon_discount;
            if($coupon > $maximum_discount){
            $coupon = $maximum_discount;
            }
            }

            }
            $discounttotal = $subtotal - $actualtotal;
            $grandtotal = $subtotal + $shippingtotal + $taxAmount - $discounttotal - $coupon + $gstAmountTotal;
            @endphp

            <ul>
                <li>
                    <input type="hidden" name="number_of_item" id="total_item" value="{{$totalItem}}">
                    <input type="hidden" name="number_of_package" id="number_of_package" value="{{$items}}">
                    <p>{{__('common.items_count')}}</p><span>{{$totalItem}}</span>
                </li>
                <li>
                    <input type="hidden" name="sub_total" id="sub_total" value="{{$subtotal}}">
                    <p>{{__('common.subtotal')}}</p><span>{{single_price($subtotal)}}</span>
                </li>
                <li>
                    <input type="hidden" name="shipping_total" id="shipping_total" value="{{$shippingtotal}}">
                    <p>{{__('defaultTheme.shipping')}}</p><span>{{single_price($shippingtotal)}}</span>
                </li>
                @if (auth()->check())
                <li>
                    @if(\Session::has('coupon_type')&&\Session::has('coupon_discount'))
                    <input type="hidden" name="coupon_amount" id="coupon_amount" value="{{$coupon}}">
                    <input type="hidden" name="coupon_id" id="coupon_amount" value="{{$coupon_id}}">
                    <p>{{__('common.coupon')}} {{__('common.discount')}}</p><strong id="coupon_delete">X</strong><span>
                        -{{single_price($coupon)}}</span>
                    @else
                    <div class="input-group couponCodeDiv">
                        <input type="text" class="form-control" id="coupon_code"
                            placeholder="{{__('common.coupon')}} {{__('common.code')}}" onfocus="this.placeholder = ''"
                            onblur="this.placeholder = 'Coupon code'">
                        <div class="input-group-append">
                            <div class="input-group-text input_group_text coupon_apply_btn"
                                data-total="{{$actualtotal}}">{{__('common.apply')}}</div>
                        </div>
                    </div>
                    @endif
                </li>
                @endif
                <li>
                    <input type="hidden" name="discount_total" id="discount_total" value="{{$subtotal - $actualtotal}}">
                    <p>{{__('common.discount')}}</p><span> -{{single_price($subtotal - $actualtotal)}}</span>
                </li>
                <li>
                    <input type="hidden" name="tax_total" id="tax_total" value="{{$taxAmount}}">
                    <p>{{__('common.total')}} {{__('common.tax')}}</p><span> {{single_price($taxAmount)}}</span>
                </li>
                @if (file_exists(base_path().'/Modules/GST/'))
                <li>
                    <input type="hidden" name="gst_tax_total" id="gst_tax_total" value="{{$gstAmountTotal}}">
                    <p>{{__('gst.total_gst')}}</p><span> {{single_price($gstAmountTotal)}}</span>
                </li>
                @endif
            </ul>
            <div class="order-price">
                <h5>{{__('common.grand_total')}}</h5>

                <input type="hidden" name="grand_total" id="grand_total" value="{{$grandtotal}}">
                <h5>{{single_price($grandtotal)}}</h5>
            </div>
        </div>
        <a href="{{url('/shopping')}}" class="btn_2">{{__('common.continue')}} {{__('common.shopping')}}</a>
        <a href="{{url('/cart')}}" class="btn_1">{{__('common.update')}} {{__('common.shopping')}}
            {{__('common.cart')}}</a>
    </div>
</div>
<div class="col-lg-2">
    <div class="billing_address payment_option">
        <h4>{{__('common.payment_options')}}</h4>
        <div class="payment">
            @php
            if ($giftCardExist == 0 && $existDigital == 0) {
                $paymentGateways = $gateway_activations->whereNotIn('id',['2']);
            }else {
                $paymentGateways = $gateway_activations->whereNotIn('id',['2', '1']);
            }
            @endphp
            @foreach ($paymentGateways as $key => $gateway)
            <label class="primary_bulet_checkbox d-inline-flex" for="payment_method{{ $key }}">
                <input name="payment_method" id="payment_method{{ $key }}" type="radio" @isset($gateway_id) @if ($gateway_id == $gateway->id) checked @endif @endisset value="{{ $gateway->id }}">
                <span class="checkmark mr_10"></span>
                <span class="label_name">{{ $gateway->method }}</span>
            </label>
            @endforeach
        </div>
        @if (session()->has('billing_address'))
        <div class="form-row">
            <div class="col-md-12">
                @include('frontend.default.partials.payments.demo')
                @include('frontend.default.partials.payments.bank_payment')
                @include('frontend.default.partials.payments.payment_paypal')
                @include('frontend.default.partials.payments.paystack_payment')
                @include('frontend.default.partials.payments.razor_payment')
                @include('frontend.default.partials.payments.stripe_payment')
                @include('frontend.default.partials.payments.paytm_payment')
                @include('frontend.default.partials.payments.instamojo_payment')
                @include('frontend.default.partials.payments.midtrans_payment')
                @include('frontend.default.partials.payments.payumoney_payment')
                @include('frontend.default.partials.payments.jazzcash_payment_modal')
                @include('frontend.default.partials.payments.google_pay_script')
                @include('frontend.default.partials.payments.flutter_payment')
                <button type="submit" @if($items < 1 || !session()->has('billing_address')) id="orderConfirm" @endif
                    disabled class="btn_1 order_submit_btn regular_order_btn">{{__('defaultTheme.process_to_payment')}}</button>
            </div>
        </div>
        @endif
    </div>
</div>
