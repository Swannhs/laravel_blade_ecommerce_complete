<form action="{{route('frontend.checkout')}}" method="GET" enctype="multipart/form-data" id="mainOrderForm">

    <div class="checkout_v3_area">
        <div class="checkout_v3_left d-flex justify-content-end">
            <div class="checkout_v3_inner">
                @guest
                  <div class="checout_head">
                      <i class="ti-folder"></i>
                      <p>{{__('defaultTheme.returning_customer')}}? <a href="{{url('/login')}}">{{__('defaultTheme.click_here_to_login')}}</a></p>
                  </div>
                @endguest

                @if(isModuleActive('MultiVendor'))
                    @php
                        $total = 0;
                        $subtotal = 0;
                        $actual_price = 0;
                        $tax = 0;
                        $current_pkg = 0;
                        $index = 0;
                        $total_shipping_charge = 0;
                    @endphp
                    <div class="checout_head_title d-flex align-items-center ">
                        <span class="flex-fill">{{$total_items}} ITEM(S)</span>
                        <span>QUANTITY</span>
                        <span>PRICE</span>
                    </div>
                    @foreach($cartData as $seller_id => $cartItems)
                        @php
                            $seller = App\Models\User::where('id',$seller_id)->first();
                        @endphp
                        @foreach($cartItems as $key => $packages)
                            @php
                                $current_pkg ++;
                            @endphp
                            <div class="checkout_shiped_box">
                                <div class="checout_shiped_head flex-wrap d-flex align-items-center ">
                                    <span class="package_text flex-fill">{{__('common.package')}} {{$current_pkg}} {{__('common.of')}} {{$total_package}}</span>
                                    <p><span class="Shipped_text">{{__('defaultTheme.shippied_by')}}</span> <span class="name_text">@if($seller->role->type == 'seller') {{$seller->first_name .' '.$seller->last_name}} @else {{ app('general_setting')->company_name }} @endif</span></p>
                                </div>
                                <div class="delevery_box">
                                    <span class="check_icon">
                                        <i class="ti-check"></i>
                                    </span>
                                    <div class="delevery_box_text">
                                        <h5>{{single_price($shipping_cost[$index])}}</h5>
                                        <h4>{{$packages[0]->shippingMethod->method_name}}</h4>
                                        <p>
                                            @php
                                                $total_shipping_charge += $shipping_cost[$index];
                                                $index ++;

                                                $shipment_time = $packages[0]->shippingMethod->shipment_time;
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
                                            {{__('Est arrival time')}}: {{$packages[0]->shippingMethod->shipment_time}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="checout_shiped_products">
                                    
                                    @foreach($packages as $key => $item)
                                        @if($item->product_type == 'product')
                                            @php
                                                $actual_price += $item->total_price;
                                                $subtotal += $item->product->selling_price * $item->qty;
                                            @endphp
                                            <div class="single_checkout_shiped_product d-flex align-items-center">
                                                <div class="product_information d-flex align-items-center flex-fill">
                                                    <div class="thumb">
                                                        <img src="
                                                        @if(@$item->product->product->product->product_type == 1)
                                                            {{asset(asset_path(@$item->product->product->product->thumbnail_image_source))}}
                                                        @else
                                                            {{asset(asset_path(@$item->product->sku->variant_image?@$item->product->sku->variant_image:@$item->product->product->product->thumbnail_image_source))}}
                                                        @endif
                                                        " alt="">
                                                    </div>
                                                    <div class="product_content">
                                                        
                                                        <p>{{ \Illuminate\Support\Str::limit(@$item->product->product->product_name, 28, $end='...') }}</p>
                                                        @if($item->product->product->product->product_type == 2)
                                                            <span>
                                                                @php
                                                                    $countCombinatiion = count(@$item->product->product_variations);
                                                                @endphp
                                                                @foreach($item->product->product_variations as $key => $combination)
                                                                    @if($combination->attribute->name == 'Color')
                                                                        {{$combination->attribute->name}}: {{$combination->attribute_value->color->name}}
                                                                    @else
                                                                        {{$combination->attribute->name}}: {{$combination->attribute_value->value}}
                                                                    @endif

                                                                    @if($countCombinatiion > $key +1)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                                <div class="offer_prise">
                                                    @if($item->product->product->hasDeal)
                                                        @if($item->product->product->hasDeal->discount > 0)
                                                            @if($item->product->product->hasDeal->discount_type == 0)
                                                                <span class="prise_offer">-{{$item->product->product->hasDeal->discount}}%</span>
                                                                <span class="prise">{{single_price($item->product->selling_price)}}</span>
                                                            @else
                                                                <span class="prise_offer">-{{single_price($item->product->product->hasDeal->discount)}}</span>
                                                                <span class="prise">{{single_price($item->product->selling_price)}}</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if(@$item->$product->product->hasDiscount == 'yes')
                                                            @if($item->product->product->discount_type == 0)
                                                                <span class="prise_offer">-{{$item->product->product->discount}}%</span>
                                                                <span class="prise">{{single_price($item->product->selling_price)}}</span>
                                                            @else
                                                                <span class="prise_offer">-{{single_price($item->product->product->discount)}}</span>
                                                                <span class="prise">{{single_price($item->product->selling_price)}}</span>
                                                            @endif
                                                        @else
                                                            <span class="prise">{{single_price($item->product->selling_price)}}</span>
                                                        @endif

                                                    @endif
                                                </div>
                                                <div class="quentity">
                                                    <span>{{__('common.qty')}}: {{$item->qty}}</span>
                                                </div>
                                                <div class="total_prise d-flex align-items-center">
                                                    <span>{{single_price($item->total_price)}}</span>
                                                </div>
                                            </div>
                                        @else
                                            @php
                                                $actual_price += $item->total_price;
                                                $subtotal += $item->giftCard->selling_price * $item->qty;
                                            @endphp
                                            <div class="single_checkout_shiped_product d-flex align-items-center">
                                                <div class="product_information d-flex align-items-center flex-fill">
                                                    <div class="thumb">
                                                        <img src="{{asset(asset_path($item->giftCard->thumbnail_image))}}" alt="">
                                                    </div>
                                                    <div class="product_content">
                                                        <p>{{@$item->giftCard->name}}</p>
                                                        <p>{{ \Illuminate\Support\Str::limit(@$item->giftCard->name, 28, $end='...') }}</p>
                                                    </div>
                                                </div>
                                                <div class="offer_prise">
                                                    @if($item->giftCard->hasDiscount())
                                                        @if($item->giftCard->discount_type == 0)
                                                            <span class="prise_offer">-{{$item->giftCard->discount}}%</span>
                                                        @else
                                                            <span class="prise_offer">-{{$item->giftCard->discount}}</span>
                                                        @endif
                                                        <span class="prise">{{$item->giftCard->selling_price}}</span>
                                                    @endif
                                                </div>
                                                <div class="quentity">
                                                    <span>{{__('common.qty')}}: {{$item->qty}}</span>
                                                </div>
                                                <div class="total_prise d-flex align-items-center">
                                                    <span>{{single_price($item->total_price)}}</span>
                                                </div>
                                            </div>
                                        @endif

                                    @endforeach
                                    
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
                
                <div class="shiping_address_box checkout_form m-0">
                    <div class="billing_address">
                        <h3 class="check_v3_title mb_25">{{__('defaultTheme.contact_information')}}</h3>
                        @if(auth()->check())
                        <div class="Contact_sVendor_box d-flex align-items-center mb_30">
                            <div class="thumb">
                                <img class="img-fluid" src="{{asset(asset_path(auth()->user()->avatar?auth()->user()->avatar:'frontend/default/img/avatar.jpg'))}}" alt="">
                            </div>
                            <div class="Contact_sVendor_info">
                                <h5>{{auth()->user()->first_name}} {{auth()->user()->last_name}} <span>({{auth()->user()->email}})</span> </h5>
                            </div>
                        </div>
                        @else
                        <div class="">
                            <label for="name">{{__('common.email')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_email">{{ $errors->first('email') }}</span>
                            <input class="form-control" type="email" id="email" placeholder="{{__('common.email')}}"  value="{{$shipping_address?$shipping_address->email:''}}" name="email">
                        </div>
                        @endif
                        <div class="product_ceck mb_20">
                            <ul>
                                <li>
                                    <label class="cs_checkbox">
                                        <input type="checkbox" name="news_letter" value="1" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="javascript:void(0)">{{__('defaultTheme.email_me_with_news_and_offers')}}</a>
                                </li>
                            </ul>
                        </div>

                        

                        <h3 class="check_v3_title mb_25">{{__('shipping.shipping_address')}}</h3>
                        <div class="row">
                            @php
                                $user_name = '';
                                $user_email = '';
                                $user_phone = '';
                            @endphp
                            @if(auth()->check())
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{__('defaultTheme.address_list')}} <span class="text-danger">*</span></label>
                                        <select class="form-control nc_select" name="address_id" id="address_id">
                                        <option value="0">{{__('defaultTheme.new_address')}}</option>
                                            @foreach (auth()->user()->customerAddresses as $address)
                                                <option value="{{$address->id}}" @if($shipping_address && $shipping_address->id == $address->id) selected @endif >{{$address->address}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $user_name = auth()->user()->first_name;
                                    $user_email = auth()->user()->email?auth()->user()->email:'';
                                    $user_phone = auth()->user()->phone?auth()->user()->phone:'';
                                @endphp
                            @endif
                          <div class="col-lg-6">
                                <label for="name">{{__('common.name')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_name">{{ $errors->first('name') }}</span>
                                <input class="form-control" type="text" id="name" name="name"
                                  placeholder="{{__('common.name')}}" value="{{$shipping_address?$shipping_address->name:$user_name}}">
                          </div>
                          <div class="col-lg-6">
                              <label for="name">{{__('common.address')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_address">{{ $errors->first('address') }}</span>
                              <input class="form-control" type="text" id="address" name="address"
                                  placeholder="{{__('common.address')}}" value="{{$shipping_address?$shipping_address->address:''}}">
                          </div>
                          @if(auth()->check())
                          <div class="col-lg-6">
                            <label for="name">{{__('common.email')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_email">{{ $errors->first('email') }}</span>
                            <input class="form-control" type="text" id="email" name="email"
                                placeholder="{{__('common.email')}}" value="{{$shipping_address?$shipping_address->email:$user_email}}">
                          </div>
                          @endif
                          <div class="col-lg-6">
                            <label for="name">{{__('common.phone')}} <span class="text-danger">*</span></label> <span class="text-danger" id="error_phone">{{ $errors->first('phone') }}</span>
                            <input class="form-control" type="text" id="phone" name="phone"
                                placeholder="{{__('common.phone')}}" value="{{$shipping_address?$shipping_address->phone:$user_phone}}">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>{{__('common.country')}} <span class="text-red">*</span></label>
                            <select class="primary_select nc_select" name="country" id="country" autocomplete="off">
                                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->id }}" @if($shipping_address && $shipping_address->country == $country->id) selected @elseif(!$shipping_address && app('general_setting')->default_country == $country->id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="error_country">{{ $errors->first('country') }}</span>
                          </div>
                          <div class="col-md-6 form-group">
                            <label>{{__('common.state')}} <span class="text-red">*</span></label>
                            <select class="primary_select nc_select" name="state" id="state" autocomplete="off">
                                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                @if(app('general_setting')->default_country != null)
                                    @foreach ($states as $state)
                                        <option value="{{$state->id}}" @if($shipping_address && $shipping_address->state == $state->id) selected @elseif(app('general_setting')->default_state == $state->id) selected @endif>{{$state->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="error_state">{{ $errors->first('state') }}</span>
                          </div>
                          <div class="col-md-6 form-group">
                            <label>{{__('common.city')}} <span class="text-red">*</span></label>

                            <select class="primary_select nc_select" name="city" id="city" autocomplete="off">
                                <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}" @if($shipping_address && $shipping_address->city == $city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="error_city">{{ $errors->first('city') }}</span>
                          </div>
                          <div class="col-lg-6">
                              <label for="postal_code">{{__('common.postal_code')}}</label>
                              <input class="form-control" type="text" id="postal_code" name="postal_code" placeholder="{{__('common.postal_code')}}" value="{{$shipping_address?$shipping_address->postal_code:''}}">
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                                <label for="note">{{__('common.note')}}</label>
                                <textarea name="note" id="note" placeholder="{{__('common.note')}}">{{session()->get('order_note')}}</textarea>
                                <span class="text-danger"  id="error_note"></span>
                            </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="product_ceck">
                                  <ul>
                                      <li>
                                          <label class="cs_checkbox">
                                              <input type="checkbox" value="1" id="term_check" checked>
                                              <span class="checkmark"></span>
                                          </label>
                                          <a href="javascript:void(0)">{{__('defaultTheme.I agree with the terms and conditions')}}.</a>
                                      </li>
                                      <li>
                                        <span class="text-danger" id="error_term_check"></span>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          <div class="col-12">
                              <div class="check_v3_btns flex-wrap d-flex align-items-center">
                                @if(isModuleActive('MultiVendor'))
                                    <input type="hidden" name="step" value="select_payment">
                                    <button type="submit" class="btn_1 m-0 text-uppercase ">{{__('defaultTheme.continue_to_payment')}}</button>
                                @else
                                    <input type="hidden" name="step" value="select_shipping">
                                    <button type="submit" class="btn_1 m-0 text-uppercase ">{{__('defaultTheme.continue_to_shipping')}}</button>
                                @endif
                                  <a href="{{url('/cart')}}" class="return_text">{{__('defaultTheme.return_to_cart')}}</a>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout_v3_right d-flex justify-content-start">
            <div class="order_sumery_box flex-fill">
                @if(!isModuleActive('MultiVendor'))
                  @php
                    $total = 0;
                    $subtotal = 0;
                    $actual_price = 0;
                  @endphp
                  @foreach($cartData as $key => $cart)
                    @if($cart->product_type == 'product')
                      <div class="singleVendor_product_lists">
                          <div class="singleVendor_product_list d-flex align-items-center">
                              <div class="thumb single_thumb">
                                  <img src="
                                    @if($cart->product->product->product->product_type == 1)
                                      {{asset(asset_path($cart->product->product->product->thumbnail_image_source))}}
                                    @else
                                      {{asset(asset_path(@$cart->product->sku->variant_image?@$cart->product->sku->variant_image:@$cart->product->product->product->thumbnail_image_source))}}
                                    @endif
                                  " alt="">
                              </div>
                              <div class="product_list_content">
                                  <h4><a href="{{route('frontend.item.show',$cart->product->product->slug)}}">{{ \Illuminate\Support\Str::limit(@$cart->product->product->product_name, 28, $end='...') }}</a></h4>
                                  @if($cart->product->product->product->product_type == 2)
                                    @php
                                        $countCombinatiion = count(@$cart->product->product_variations);
                                    @endphp
                                    <p>
                                      @foreach($cart->product->product_variations as $key => $combination)
                                          @if($combination->attribute->name == 'Color')
                                          {{$combination->attribute->name}}: {{$combination->attribute_value->color->name}}
                                          @else
                                          {{$combination->attribute->name}}: {{$combination->attribute_value->value}}
                                          @endif

                                          @if($countCombinatiion > $key +1)
                                          ,
                                          @endif
                                      @endforeach
                                    </p>
                                  @endif
                                    <h5 class="d-flex align-items-center"><span
                                        class="product_count_text">{{$cart->qty}}<span>x</span></span>{{single_price($cart->price)}}</h5>
                                </div>
                            </div>
                        </div>
                        @php
                            $actual_price += $cart->total_price;
                            $subtotal += $cart->product->sku->selling_price * $cart->qty;
                        @endphp
                    @else
                      <div class="singleVendor_product_lists">
                        <div class="singleVendor_product_list d-flex align-items-center">
                            <div class="thumb single_thumb">
                                <img src="{{asset(asset_path(@$cart->giftCard->thumbnail_image))}}" alt="">
                            </div>
                            <div class="product_list_content">
                                <h4><a href="{{route('frontend.gift-card.show',$cart->giftCard->sku)}}">{{ \Illuminate\Support\Str::limit(@$cart->giftCard->name, 28, $end='...') }}</a></h4>
                                <h5 class="d-flex align-items-center"><span class="product_count_text" >{{$cart->qty}}<span>x</span></span>{{single_price($cart->price)}}</h5>
                            </div>
                        </div>
                      </div>
                      @php
                            $actual_price += $cart->total_price;
                            $subtotal += $cart->giftCard->selling_price * $cart->qty;
                      @endphp
                    @endif
                  @endforeach
                @endif
                <h3 class="check_v3_title mb_25">{{__('common.order_summary')}}</h3>
                <div class="subtotal_lists">
                    <div class="single_total_list d-flex align-items-center">
                        <div class="single_total_left flex-fill">
                            <h4>{{ __('common.subtotal') }}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>+ {{single_price($subtotal)}}</span>
                        </div>
                    </div>
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.shipping_charge')}}</h4>
                            @if(isModuleActive('MultiVendor'))
                              <p>{{ __('defaultTheme.package_wise_shipping_charge') }}</p>
                            @endif
                        </div>
                        <div class="single_total_right">
                            <span>
                              @if(isModuleActive('MultiVendor'))
                                + {{single_price($total_shipping_charge)}}
                              @else
                              {{__('defaultTheme.calculated_at_next_step')}}
                              @endif
                            </span>
                        </div>
                    </div>
                        @php
                            if(isModuleActive('MultiVendor')){
                                // dd($subtotal);
                                $total = $actual_price + $total_shipping_charge;
                            }else{
                                $total = $actual_price;
                                $discount = $subtotal - $actual_price;
                            }
                        @endphp
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.discount')}}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>-{{single_price($discount)}}</span>
                        </div>
                    </div>
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.tax')}}/{{__('gst.gst')}}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>{{__('defaultTheme.calculated_at_next_step')}}</span>
                        </div>
                    </div>

                    @php
                        $coupon = 0;
                        $coupon_id = null;
                        $total_for_coupon = $actual_price;
                    @endphp
                    @auth
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        @php
                            if(\Session::has('coupon_type')&&\Session::has('coupon_discount')){
                                $coupon_type = \Session::get('coupon_type');
                                $coupon_discount = \Session::get('coupon_discount');
                                $coupon_discount_type = \Session::get('coupon_discount_type');
                                $coupon_id = \Session::get('coupon_id');

                                if($coupon_type == 1){
                                    $couponProducts = \Session::get('coupon_products');
                                    if($coupon_discount_type == 0){

                                        foreach($couponProducts as  $key => $item){
                                            $cart = \App\Models\Cart::where('user_id',auth()->user()->id)->where('is_select',1)->where('product_type', 'product')->whereHas('product',function($query) use($item){
                                                $query->whereHas('product', function($q) use($item){
                                                    $q->where('id', $item);
                                                });
                                            })->first();
                                            $coupon += ($cart->total_price/100)* $coupon_discount;
                                        }
                                    }else{
                                        if($total_for_coupon > $coupon_discount){
                                            $coupon = $coupon_discount;
                                        }else {
                                            $coupon = $total_for_coupon;
                                        }
                                    }

                                }
                                elseif($coupon_type == 2){

                                    if($coupon_discount_type == 0){

                                        $maximum_discount = \Session::get('maximum_discount');
                                        $coupon = ($total_for_coupon/100)* $coupon_discount;

                                        if($coupon > $maximum_discount && $maximum_discount > 0){
                                            $coupon = $maximum_discount;
                                        }
                                    }else{
                                        $coupon = $coupon_discount;
                                    }
                                }
                                elseif($coupon_type == 3){
                                    $maximum_discount = \Session::get('maximum_discount');
                                    $coupon = $shippingtotal;

                                    if($coupon > $maximum_discount && $maximum_discount > 0){
                                        $coupon = $maximum_discount;
                                    }

                                }

                            }
                        @endphp
                        @if(\Session::has('coupon_type')&&\Session::has('coupon_discount'))
                            <div class="single_total_left flex-fill">
                                <h4>{{__('common.coupon')}} {{__('common.discount')}}</h4>
                            </div>
                            <div class="single_total_left flex-fill">
                                <strong id="coupon_delete" class="text-red cursor_pointer">X</strong>
                            </div>
                            <div class="single_total_right">
                                <span>- {{single_price($coupon)}}</span>
                            </div>
                        @else
                            <div class="input-group couponCodeDiv">
                                <input type="text" class="form-control" id="coupon_code" placeholder="{{__('common.coupon')}} {{__('common.code')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Coupon code'">
                                <div class="input-group-append">
                                <div class="input-group-text input_group_text coupon_apply_btn cursor_pointer" data-total="{{$actual_price}}">{{__('common.apply')}}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endauth
                    
                    <div class="total_amount d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <span class="total_text">{{__('common.total')}}</span>
                        </div>
                        <div class="single_total_right">
                            <span class="total_text"><span>{{single_price($total-$coupon)}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
