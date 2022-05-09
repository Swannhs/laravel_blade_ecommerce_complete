@extends('frontend.default.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/checkout.css'))}}" />
@endsection
@section('breadcrumb')
    {{ __('Select Shipping') }}
@endsection
@section('content')
    @include('frontend.default.partials._breadcrumb')
    <form action="{{route('frontend.checkout')}}" method="GET" enctype="multipart/form-data" id="mainOrderForm">
    <input type="hidden" name="step" value="select_payment">
        <div id="mainDiv">
            <div class="checkout_v3_area">
                <div class="checkout_v3_left d-flex justify-content-end">
                    <div class="checkout_v3_inner">
                        <div class="shiping_address_box checkout_form m-0">
                            <div class="billing_address">
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="shipingV3_info mb_30">
                                            <div class="single_shipingV3_info d-flex align-items-start">
                                                <span>{{__('defaultTheme.contact')}}</span>
                                                <h5 class="m-0 flex-fill">{{$address->email}}</h5>
                                                <a href="{{url()->previous()}}" class="edit_info_text">{{__('common.change')}}</a>
                                            </div>
                                            <div class="single_shipingV3_info d-flex align-items-start">
                                                <span>{{__('defaultTheme.ship_to')}}</span>
                                                <h5 class="m-0 flex-fill">{{$address->address}}</h5>
                                                <a href="{{url()->previous()}}" class="edit_info_text">{{__('common.change')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!isModuleActive('MultiVendor'))
                                        <div class="col-12">
                                            <h3 class="check_v3_title2 mb_10 ">{{__('defaultTheme.shipping_method')}}</h3>
                                        </div>
                                    @endif
                                    <div class="col-12 mb_30">
                                        @php
                                            $additional_cost = 0;
                                        @endphp
                                        @if(!isModuleActive('MultiVendor'))
                                            @foreach ($cartData as $ct => $item)
                                                @if($item->product_type == 'product')
                                                    @php
                                                        $additional_cost += $item->product->sku->additional_shipping;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        

                                            @foreach($shipping_methods->where('id','>',1) as $key => $shipping)
                                                @php
                                                    $cost = 0;
                                                    if($shipping->cost > 0){
                                                        $cost = $shipping->cost + $additional_cost;
                                                    }
                                                @endphp
                                                <div class="standard_shiping_box d-flex align-items-center justify-content-between">
                                                    <div class="product_ceck m-0">
                                                        <ul>
                                                            <li class="mb-0">
                                                                <label class="primary_bulet_checkbox">
                                                                    <input type="radio" data-cost="{{$cost}}" class="shipping_method" name="shipping_method" value="{{$shipping->id}}" {{$key == 1?'checked':''}}>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <a href="#Electronics">{{$shipping->method_name}}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @if($key == 1)
                                                        <input type="hidden" id="shipping_method_cost" value="{{$cost}}">
                                                    @endif
                                                    <span>{{single_price($cost)}}</span>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                    </div>
                                    <div class="col-12">
                                        <div class="check_v3_btns flex-wrap d-flex align-items-center">
                                            <button type="submit" class="btn_1 m-0 text-uppercase ">{{__('defaultTheme.continue_to_payment')}}</button>
                                            <a href="{{url('/checkout')}}" class="return_text">{{__('defaultTheme.return_to_information')}}</a>
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
                                $tax = 0;

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
                                        $subtotal += $cart->product->selling_price * $cart->qty;
                                    @endphp

                                    @if (file_exists(base_path().'/Modules/GST/') && $cart->product->product->product->is_physical == 1)
                                        @if ($address && app('gst_config')['enable_gst'] == "gst")
                                            @if (app('general_setting')->state_id == $address->state)
                                                @php
                                                    $sameStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['within_a_single_state'])->get();
                                                @endphp
                                                @foreach ($sameStateTaxes as $key => $sameStateTax)
                                                    @php
                                                        $gstAmount = ($cart->total_price * $sameStateTax->tax_percentage) / 100;
                                                        $tax += $gstAmount;
                                                    @endphp
                                                @endforeach
                                            @else
                                                @php
                                                    $diffStateTaxes = \Modules\GST\Entities\GstTax::whereIn('id', app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])->get();
                                                @endphp
                                                @foreach ($diffStateTaxes as $key => $diffStateTax)
                                                    @php
                                                        $gstAmount = ($cart->total_price * $diffStateTax->tax_percentage) / 100;
                                                        $tax += $gstAmount;
                                                    @endphp
                                                @endforeach
                                            @endif

                                        @else
                                            @php
                                                $flatTax = \Modules\GST\Entities\GstTax::where('id', app('gst_config')['flat_tax_id'])->first();
                                                $gstAmount = ($cart->total_price * $flatTax->tax_percentage) / 100;
                                                $tax += $gstAmount;
                                            @endphp
                                        
                                        @endif

                                    @endif

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

                            @php
                                $total = $actual_price + $tax;
                                $discount = $subtotal - $actual_price;
                            @endphp
                        @endif
                        <h3 class="check_v3_title mb_25">{{__('common.order_summary')}}</h3>
                        <div class="subtotal_lists">
                            <div class="single_total_list d-flex align-items-center">
                                <div class="single_total_left flex-fill">
                                    <h4 >{{ __('common.subtotal') }}</h4>
                                </div>
                                <div class="single_total_right">
                                    <span>+ {{single_price($subtotal)}}</span>
                                </div>
                            </div>
                            <div class="single_total_list d-flex align-items-center">
                                <div class="single_total_left flex-fill">
                                    <h4 >{{__('common.discount')}}</h4>
                                </div>
                                <div class="single_total_right">
                                    <span>- {{single_price($discount)}}</span>
                                </div>
                            </div>
                            <div class="single_total_list d-flex align-items-center flex-wrap">
                                <div class="single_total_left flex-fill">
                                    <h4>{{__('common.shipping_charge')}}</h4>
                                    <p>{{ __('defaultTheme.package_wise_shipping_charge') }}</p>
                                </div>
                                <div class="single_total_right">
                                    <span>+ <span id="shipping_cost"></span></span>
                                </div>
                            </div>
                            <div class="single_total_list d-flex align-items-center flex-wrap">
                                <div class="single_total_left flex-fill">
                                    <h4>{{__('common.tax')}}/{{__('gst.gst')}}</h4>
                                </div>
                                <div class="single_total_right">
                                    <span>+ {{single_price($tax)}}</span>
                                </div>
                            </div>

                            @if(\Session::has('coupon_type')&&\Session::has('coupon_discount'))
                            @php
                                $coupon = 0;
                            
                                $coupon_id = null;
                                $total_for_coupon = $actual_price;
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
                                $total = $total - $coupon;
                            @endphp
                                <div class="single_total_list d-flex align-items-center flex-wrap">
                                    <div class="single_total_left flex-fill">
                                        <h4>{{__('common.coupon')}} {{__('common.discount')}}</h4>
                                    </div>
                                    <div class="single_total_right">
                                        <span>- {{single_price($coupon)}}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="total_amount d-flex align-items-center flex-wrap">
                                <div class="single_total_left flex-fill">
                                    <span class="total_text">{{__('common.total')}} (Incl. {{__('common.tax')}}/{{__('gst.gst')}}) {{$total}}</span>
                                </div>
                                <input type="hidden" id="total" value="{{$total}}">
                                <div class="single_total_right">
                                    <span class="total_text"><span id="grand_total"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                let shipping_amount = $('#shipping_method_cost').val();
                shipping_cost(shipping_amount);
                let total = $('#total').val();
                let format_total = parseFloat(total) + parseFloat(shipping_amount);
                grand_total(format_total);
                
                $(document).on('click', '.shipping_method', function(){
                    let cost = $(this).data('cost');
                    shipping_cost(cost);
                    grand_total(parseFloat(total) + parseFloat(cost));
                    $('#shipping_method_cost').val(cost);
                });

                function shipping_cost(cost){
                    $('#shipping_cost').text(currency_format(cost));
                }
                function grand_total(total){
                    $('#grand_total').text(currency_format(total));
                }
            });
        })(jQuery);
    </script>
@endpush
