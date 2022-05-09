@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{__('defaultTheme.place_a_refund_request')}}
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/refund_create.css'))}}" />

@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="cart_part">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="cart_product_list">
                    <div class="order_details_status">
                        <ul class="w-100">
                            <li>
                                <p><span>{{__('common.order_id')}}</span>: {{ $order->order_number }}</p>
                                <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $order->created_at }}</p>
                            </li>
                            <li>
                                @if($order->is_cancelled == 1)
                                    <p><span>{{__('common.status')}}</span>: {{__('common.cancelled')}}</p>
                                @elseif($order->is_completed == 1)
                                    <p><span>{{__('common.status')}}</span>: {{__('common.completed')}}</p>
                                @else
                                    @if ($order->is_confirmed == 1)
                                        <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                    @elseif ($order->is_confirmed == 2)
                                        <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                    @else
                                        <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                    @endif
                                @endif

                                @if ($order->is_paid == 1)
                                    <p><span>{{__('common.payment')}}</span>: {{__('common.paid')}}</p>
                                @else
                                    <p><span>{{__('common.payment')}}</span>: {{__('common.pending')}}</p>
                                @endif
                            </li>
                            <li>
                                <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price($order->grand_total) }}</p>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <form action="{{ route('refund.refund_make_request_store') }}" method="post">
                        @csrf
                        @php
                            $e_items = [];
                        @endphp
                        <table class="table table-hover tablesaw tablesaw-stack">
                            <tbody class="cart_table_body">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                @foreach ($order->packages as $key => $package)
                                    @foreach ($package->products->where('type','product') as $k => $package_product)
                                        @php
                                            //ga4
                                            $e_items[]=[
                                                            "item_id"=>$package_product->product_sku_id,
                                                            "item_name"=> $package_product->seller_product_sku->sku->product->product_name,
                                                            "currency"=> currencyCode(),
                                                            "price"=> $package_product->price
                                                        ];
                                        @endphp
                                        <input type="hidden" name='e_items' value="{{json_encode($e_items)}}" >
                                        <tr>
                                            <td>
                                                <label class="primary_bulet_checkbox d-inline-flex" for="product_id{{ $package_product->id }}">
                                                    <input name="product_ids[]" id="product_id{{ $package_product->id }}" type="checkbox" value="{{ $package->id }}-{{ $package_product->product_sku_id }}-{{ $package->seller_id }}-{{ $package_product->price }}">
                                                    <span class="checkmark mr_10"></span>
                                                    <span class="label_name"></span>
                                                </label>
                                                <strong>{{ @$package_product->seller_product_sku->sku->product->product_name }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div class="product_img_div">
                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                        <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                    @else

                                                        <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</td>
                                            <td>
                                                <div class="product_count">
                                                    <input  type="text" name="qty_{{ $package_product->product_sku_id }}" class="qty" maxlength="{{ $package_product->qty }}" min="1" value="1" class="input-text qty" />
                                                    <div class="button-container">
                                                        <button class="cart-qty-plus" type="button" value="+"><i class="ti-plus"></i></button>
                                                        <button class="cart-qty-minus" type="button" value="-"><i class="ti-minus"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <select required class="nc_select form-control" id="reason_{{ $package_product->product_sku_id }}" name="reason_{{ $package_product->product_sku_id }}">
                                                    @foreach ($reasons as $key => $reason)
                                                        <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        <section class="send_query p-20 bg-gray contact_form">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="textarea">{{__('defaultTheme.additional_information')}} <small>({{__('defaultTheme.optional')}})</small> </label>
                                            <textarea name="additional_info" id="additional_info" maxlength="255" placeholder="{{__('defaultTheme.additional_information')}}"></textarea>
                                            <span class="text-danger"  id="error_message"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('defaultTheme.set_prefered_option')}}</label>
                                            <select name="money_get_method" id="money_get_method" class="form-control nc_select">
                                                <option value="wallet">{{__('defaultTheme.wallet')}}</option>
                                                <option value="bank_transfer">{{__('defaultTheme.bank_transfer')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bank_info_div row d-none">
                                    <div class="col-md-12">
                                        <h5>{{__('defaultTheme.bank_information_to_recieve_money')}}</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('common.bank_name')}}</label>
                                            <input type="text" id="bank_name" name="bank_name" placeholder="{{__('common.bank_name')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('common.branch_name')}}</label>
                                            <input type="text" id="branch_name" name="branch_name" placeholder="{{__('common.branch_name')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('common.account_name')}}</label>
                                            <input type="text" id="account_name" name="account_name" placeholder="{{__('common.account_name')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('common.account_number')}}</label>
                                            <input type="text" id="account_no" name="account_no" placeholder="{{__('common.account_number')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="query_type">{{__('defaultTheme.set_shipment_option')}}</label>
                                            <select name="shipping_way" id="shipping_way" class="form-control nc_select">
                                                <option value="courier">{{ __('shipping.courier_pick_up') }}</option>
                                                <option value="drop_off">{{ __('shipping.drop_off') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipment_info_div1 row">
                                    <div class="col-md-12">
                                        <h5>{{ __('shipping.courier_pick_up_information') }}</h5>
                                        <small>{{__('defaultTheme.please_select_pick_up_courier_you_prefer')}}</small>
                                    </div>
                                    @foreach ($shipping_methods->where('id', '!=', 1) as $n => $shipping_method)
                                        <div class="col-md-4">
                                            <div class="form-group mb-0 p-3">
                                                <label class="primary_bulet_checkbox d-inline-flex" for="couriers{{ $shipping_method->id }}">
                                                    <input name="couriers" id="couriers{{ $shipping_method->id }}" type="radio" @if ($n == 1) checked @endif value="{{ $shipping_method->id }}">
                                                    <span class="checkmark mr_10"></span>
                                                    <span class="label_name">{{ $shipping_method->method_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="query_type">{{__('common.pickup_address')}}</label>
                                            <select name="pick_up_address_id" id="pick_up_address_id" class="form-control nc_select">
                                                @foreach (auth()->user()->customerAddresses as $key_num => $address)
                                                    <option value="{{ $address->id }}">{{ $address->address }}, {{ @$address->getCity->name }}, {{ @$address->getState->name }}; ({{ $address->phone }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipment_info_div2 row d-none">
                                    <div class="col-md-12 mb-1">
                                        <h5>{{ __('shipping.drop_off_information') }}</h5>
                                        <small>{{__('defaultTheme.drop_off_your_return_item_at_a_nearby_courier_office')}}</small>
                                    </div>
                                    @foreach ($shipping_methods->where('id', '!=', 1) as $m => $shipping_method)

                                        <div class="col-md-4">
                                            <div class="form-group mb-0 p-3">
                                                <label class="primary_bulet_checkbox d-inline-flex" for="drop_off_couriers{{ $shipping_method->id }}">
                                                    <input name="drop_off_couriers" id="drop_off_couriers{{ $shipping_method->id }}" type="radio" @if ($m == 0) checked @endif value="{{ $shipping_method->id }}">
                                                    <span class="checkmark mr_10"></span>
                                                    <span class="label_name">{{ $shipping_method->method_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="query_type">{{__('defaultTheme.courier_address')}}</label>
                                            <input type="text" id="drop_off_courier_address" name="drop_off_courier_address" placeholder="{{__('defaultTheme.courier_address')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="send_query_btn text-right">
                            <button id="contactBtn" type="submit" class="btn_1">{{__('common.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function() {
                $(document).on('change', '#money_get_method', function() {
                    $('#pre-loader').show();
                    var method = this.value;
                    if (method == "bank_transfer") {
                        $('.bank_info_div').removeClass('d-none');
                    }else {
                        $('.bank_info_div').addClass('d-none');
                    }
                    $('#pre-loader').hide();
                });
                $(document).on('change', '#shipping_way', function() {
                    $('#pre-loader').show();
                    var way = this.value;
                    if (way == "courier") {
                        $('.shipment_info_div1').removeClass('d-none');
                        $('.shipment_info_div2').addClass('d-none');
                    }else {
                        $('.shipment_info_div1').addClass('d-none');
                        $('.shipment_info_div2').removeClass('d-none');
                    }
                    $('#pre-loader').hide();
                });
                var incrementPlus;
                var incrementMinus;
                var buttonPlus  = $(".cart-qty-plus");
                var buttonMinus = $(".cart-qty-minus");

                var incrementPlus = buttonPlus.on('click',function() {
                  var $n = $(this)
                    .parent(".button-container")
                    .parent(".product_count")
                    .find(".qty");
                    var max_qty = parseInt($n.attr("maxlength"));
                    if (Number($n.val()) < max_qty) {
                        $n.val(Number($n.val())+1 );
                    }
                });

                var incrementMinus = buttonMinus.on('click',function() {
                    var $n = $(this)
                    .parent(".button-container")
                    .parent(".product_count")
                    .find(".qty");
                  var amount = Number($n.val());
                  if (amount > 0) {
                    $n.val(amount-1);
                  }
                });
            });
        })(jQuery);
    </script>
@endpush
