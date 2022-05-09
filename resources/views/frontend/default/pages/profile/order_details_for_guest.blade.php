@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{__('common.orders')}}
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/order_details_for_guest.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')
@php
    $total_gst = 0;
@endphp
<!--  dashboard part css here -->
<section class="custom_refund_disputes bg-white padding_top">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-3 col-md-5">
                <div class="refund_disputes_sidebar">
                    @foreach ($processes as $key => $process)
                        <div class="single_disputes_sidebar">
                            <h4>{{ $process->name }}</h4>
                            <p>{{ $process->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-8 col-md-7">
                <div class="order_details">
                    <div class="single_order_part">
                        <div class="order_details_status">
                            <ul class="w-100">
                                <li>
                                    <p><span>{{__('common.order_id')}}</span>: {{ $order->order_number }}</p>
                                    <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $order->created_at }}</p>
                                </li>
                                <li>
                                    @if ($order->is_confirmed == 1)
                                        <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                    @elseif ($order->is_confirmed == 2)
                                        <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                    @else
                                        <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
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
                    </div>
                    @foreach ($order->packages as $key => $package)
                        <div class="row">
                            <div class="col-12 text-center mt-3 mb-2">
                                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                    <div class="multy_step_form">
                                        <div class="step_form_header d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <h4>{{__('common.package')}} : {{ $package->package_code }}</h4>
                                                @if(isModuleActive("multiVendor"))
                                                <p>{{__('defaultTheme.sold_by')}} <a href="#">@if($package->seller->role->type == 'seller') {{ @$package->seller->first_name }} @else {{ app('general_setting')->company_name }} @endif</a></p>
                                                @endif
                                            </div>
                                            <div class="">
                                                @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                                    <h4>{{__('common.price')}} : {{ single_price($package->products->sum('total_price') + $package->tax_amount + $package->gst_taxes->sum('amount')) }}</h4>
                                                @else
                                                    <h4>{{__('common.price')}} : {{ single_price($package->products->sum('total_price') + $package->tax_amount) }}</h4>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="step_form_subheader">
                                            <p>{{ $package->shipping_date }}</p>
                                        </div>
                                        <div class="refund_disputes_content">
                                            <div class="disputes_content_progress">
                                                @foreach ($processes as $key => $process)
                                                    <div class="disputes_content_item @if ($package->delivery_status >= $process->id) step_complect @endif">
                                                        <div class="process_count">
                                                            <a href="#">{{ $key+1 }}</a>
                                                        </div>
                                                        <p>{{ $process->name }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="single_order_part">
                                            <div class="order_details_status order_details2">
                                                <fieldset class="show_fieldset">
                                                    <div class="step_form_content">
                                                        <ul class="tracking_list inline_list">
                                                            @foreach ($package->delivery_states->take(1) as $key => $first_state_info)
                                                                <li>
                                                                    <p><span>{{ $first_state_info->created_at }}</span>{{ $first_state_info->note }}</p>
                                                                </li>
                                                            @endforeach
                                                            <ul id="demo" class="collapse m-0 p-0">
                                                                @foreach ($package->delivery_states->skip(1) as $key => $state_info)
                                                                    <li>
                                                                        <p><span>{{ $state_info->created_at }}</span>{{ $state_info->note }}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </ul>
                                                        <div class="view_more">
                                                            <span type="button" data-toggle="collapse" data-target="#demo" class="view_collaspe_btn">{{__('defaultTheme.view_more')}}</span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single_order_part">
                            <div class="order_details_status">
                                <ul class="w-100">
                                    <li>
                                        <p><span>{{__('defaultTheme.package_code')}}</span>: {{ $package->package_code }}</p>
                                        @if(isModuleActive('MultiVendor'))
                                            <p>{{__('defaultTheme.sold_by')}} <a href="#">@if(@$package->seller->role->type == 'seller') {{ @$package->seller->first_name }} @else {{ app('general_setting')->company_name }} @endif</a></p>
                                        @endif
                                        
                                    </li>
                                    <li>
                                        @if(isModuleActive('MultiVendor'))
                                        <p><span>{{__('defaultTheme.store')}}</span>: {{ @$package->seller->SellerAccount->seller_shop_display_name }}</p>
                                        @endif
                                    </li>
                                    <li>
                                        <p><span>{{__('defaultTheme.order_amount')}}:</span>: {{ single_price($package->products->sum('total_price')) }}</p>
                                        <p><span>{{__('defaultTheme.tax_amount')}}:</span>: {{ single_price($package->tax_amount) }}</p>
                                        @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                            @foreach ($package->gst_taxes as $key => $gst_tax)
                                                @php
                                                    $total_gst += $gst_tax->amount;
                                                @endphp
                                                <p><span>{{ $gst_tax->gst->name }}:</span>: {{ single_price($gst_tax->amount) }}</p>
                                            @endforeach
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="order_details_iner">
                                <div class="order_item">
                                    @foreach ($package->products as $key => $package_product)
                                        @if ($package_product->type == "gift_card")
                                            <div class="single_order_item">
                                                <div class="order_item_name">
                                                    <img src="{{asset(asset_path(@$package_product->giftCard->thumbnail_image))}}" alt="#">
                                                    <p>{{ @$package_product->giftCard->name }}
                                                        @if ($order->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first() != null)
                                                            <br>Secret-Key : {{ $order->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first()->secret_code }}
                                                        @else
                                                            Check Shipping email for secret key
                                                        @endif
                                                    </p>
                                                </div>
                                                <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                            </div>
                                        @else
                                            <div class="single_order_item">
                                                <div class="order_item_name">
                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                        <img src="{{asset(asset_path(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source))}}" alt="#">
                                                    @else

                                                        <img src="{{asset(asset_path((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source))}}" alt="#">
                                                    @endif
                                                    <p>{{ @$package_product->seller_product_sku->product->product_name??@$package_product->seller_product_sku->sku->product->product_name }}</p>
                                                    @if($package_product->seller_product_sku->sku->product->product_type == 2)
                                                    <br>
                                                   <p>

                                                       @php
                                                           $countCombinatiion = count(@$package_product->seller_product_sku->product_variations);
                                                       @endphp
                                                       @foreach(@$package_product->seller_product_sku->product_variations as $key => $combination)
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
                                                </div>
                                                <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                                <p>{{__('common.tax')}}: {{single_price($package_product->tax_amount)}}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="order_details_btn">
                                    @if ($order->is_confirmed == 0 && $package->is_cancelled == 0)
                                        <a data-id={{ $package->id }} class="btn_2 order_cancel_by_id">{{__('defaultTheme.cancel_order')}}</a>

                                    @elseif($order->is_completed == 1 || $package->delivery_status >= 5)

                                        @if (\Carbon\Carbon::now() <= $order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $package->is_cancelled == 0)
                                            <a href="{{ route('refund.make_request', encrypt($order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                        @endif
                                    @elseif($package->is_cancelled == 1)
                                        <a class="btn_2">{{__('defaultTheme.order_cancelled')}}</a>
                                    @endif
                                    @if($package->delivery_status >4 && count(@$package->reviews)<1)

                                        <a href="/profile/product-review?order_id={{base64_encode($order->id)}}&&package_id={{base64_encode($package->id)}}&&seller_id={{base64_encode($package->seller_id)}}" class="btn_2">{{__('defaultTheme.write_a_review')}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="single_order_part">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table-borderless">
                                        <tr>
                                            <th><strong>{{__('defaultTheme.shipping_info')}}</strong></th>
                                            <th><strong>{{__('defaultTheme.billing_info')}}</strong></th>
                                            <th><strong>{{__('defaultTheme.payment_info')}}</strong></th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.secret_id')}}</span> <span>: {{$order->guest_info->guest_id}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info name --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.name')}}</span> <span>: {{$order->guest_info->billing_name}}</span>
                                                </div>
                                            </td>
                                            {{-- subtotal --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.subtotal')}}</span> <span>: {{single_price($order->sub_total)}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info name --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.name')}}</span> <span>:{{$order->guest_info->shipping_name}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info email --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.email')}}</span> <span><a class="email_tag" href="mailto:{{$order->guest_info->billing_email}}">: {{$order->guest_info->billing_email}}</a></span>
                                                </div>
                                            </td>
                                            {{-- discount total --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.discount')}}</span> <span>: - {{single_price($order->discount_total)}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info email --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.email')}}</span> <span><a class="email_tag" href="mailto:{{$order->guest_info->shipping_email}}">: {{$order->guest_info->shipping_email}}</a></span>
                                                </div>
                                            </td>

                                            {{-- billing info phone --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.phone_number')}}</span> <span>: {{$order->guest_info->billing_phone}}</span>
                                                </div>
                                            </td>
                                            {{-- shipping total --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.shipping_charge')}}</span> <span>: {{single_price($order->shipping_total)}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info phone --}}
                                            <td>
                                                <div class="table_td_div">
                                                <span>{{__('common.phone_number')}}</span> <span>: {{$order->guest_info->shipping_phone}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info address --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.address')}}</span> <span>: {{$order->guest_info->billing_address}}</span>
                                                </div>
                                            </td>
                                            {{-- coupon amount --}}
                                            <td>
                                                @if($order->coupon)
                                                    <div class="table_td_div">
                                                        <span>{{__('common.coupon')}}</span> <span>: - {{single_price($order->coupon->discount_amount)}}</span>
                                                    </div>
                                                @else
                                                   {{-- tax amount --}}

                                                    <div class="table_td_div">
                                                        <span>{{__('defaultTheme.tax_amount')}}</span> <span>: {{single_price($order->tax_amount)}}</span>
                                                    </div>

                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info address --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.address')}}</span> <span>: {{$order->guest_info->shipping_address}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info city --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.city')}}</span> <span>: {{@$order->guest_info->getBillingCity->name}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($order->coupon)
                                                    {{-- tax amount --}}

                                                    <div class="table_td_div">
                                                        <span>{{__('defaultTheme.tax_amount')}}</span> <span>: {{single_price($order->tax_amount)}}</span>
                                                    </div>

                                                @else
                                                    <div class="table_td_div">
                                                        <span>{{__('common.grand_total')}}</span> <span>: {{single_price($order->grand_total)}}</span>
                                                    </div>

                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info city --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.city')}}</span> <span>: {{@$order->guest_info->getShippingCity->name}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info state --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.state')}}</span> <span>: {{@$order->guest_info->getBillingState->name}}</span>
                                                </div>
                                            </td>
                                            {{-- grand total --}}
                                            <td>
                                                @if($order->coupon && file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))

                                                    <div class="table_td_div">
                                                        <span>{{__('defaultTheme.paid_by')}}</span> <span>: {{$order->GatewayName}}</span>
                                                    </div>
                                                @else
                                                    <div class="table_td_div">
                                                        <strong>{{__('defaultTheme.payment_status')}}</strong>

                                                        @if ($order->is_paid == 1)
                                                            <span>: {{__('common.paid')}}</span>
                                                        @else
                                                            <span>: {{__('common.pending')}}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            {{-- shipping info state --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.state')}}</span> <span>: {{@$order->guest_info->getShippingState->name}}</span>
                                                </div>
                                            </td>

                                            {{-- billing info country --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.country')}}</span> <span>: {{@$order->guest_info->getBillingCountry->name}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($order->coupon && file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                                    <div class="table_td_div">
                                                        <strong>{{__('defaultTheme.payment_status')}}</strong>

                                                        @if ($order->is_paid == 1)
                                                            <span>: {{__('common.paid')}}</span>
                                                        @else
                                                            <span>: {{__('common.pending')}}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- shipping info country --}}
                                            <td>
                                                <div class="table_td_div">
                                                    <span>{{__('common.country')}}</span> <span>: {{@$order->guest_info->getShippingCountry->name}}</span>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        @if($order->note != null)
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single_disputes_sidebar">
                                        <h5>{{__('common.order')}} {{__('common.note')}}:</h5>
                                        <p>{{ $order->note }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade admin-query" id="orderCancelReasonModal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.select_cancel_reason') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <section class="send_query bg-white contact_form">
                    <form id="contactForm" action="{{route('frontend.my_purchase_order_package_cancel')}}" method="post" class="send_query_form">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('refund.reason') }}<span class="text-red">*</span></label>
                            <select class="form-control nc_select" name="reason" id="reason" autocomplete="off">
                                @foreach ($cancel_reasons as $key => $cancel_reason)
                                    <option value="{{ $cancel_reason->id }}">{{ $cancel_reason->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"  id="error_secret_code"></span>
                        </div>
                        <input type="hidden" id="order_id" name="order_id" class="form-control order_id" required>
                        <div class="send_query_btn">
                            <button id="contactBtn" type="submit" class="btn_1">{{ __('common.send') }}</button>
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript">

        (function($) {
           "use strict";
            $(document).ready(function() {
                $(".next-step").trigger('click');

                $(document).on('click','.order_cancel_by_id', function(){
                    $('#orderCancelReasonModal').modal('show');
                    $('.order_id').val($(this).attr('data-id'));
                });

                $(document).on('click','.change_delivery_state_status', function(){
                    change_delivery_state_status($(this).attr('data-id'));
                });

                function change_delivery_state_status(el)
                {
                    $("#pre-loader").show();
                    $.post('{{ route('change_delivery_status_by_customer') }}', {_token:'{{ csrf_token() }}', package_id:el}, function(data){
                        if (data == 1) {
                            toastr.success("{{__('defaultTheme.order_has_been_recieved')}}", "{{__('common.success')}}");
                        }else {
                            toastr.error("{{__('defaultTheme.order_not_recieved')}} {{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                        $("#pre-loader").hide();
                    });
                }
            });


        })(jQuery);
    </script>
@endpush
