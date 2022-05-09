@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/ordermanage/css/my_sale_details.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$order->order_number}}</h3>
                            @if (permissionCheck('order_manage.print_order_details'))
                                <ul class="d-flex float-right">
                                    <li><a href="{{ route('my_order_manage.print_order_details', $order->id) }}" target="_blank"
                                       class="primary-btn fix-gr-bg radius_30px mr-10">{{__('order.print')}}</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 student-details">
                    <div class="white_box_50px box_shadow_white" id="printableArea">
                        <div class="row pb-30 border-bottom">
                            <div class="col-md-6 col-lg-6">
                                <div class="logo_div">
                                    <img src="{{showImage(app('general_setting')->logo)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-right">
                                <h4>{{$order->order_number}}</h4>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('defaultTheme.billing_info')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.name')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->name : $order->guest_info->billing_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.email')}}</td>
                                        <td><a href="mailto:{{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->billing_email}}">: {{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->shipping_email}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.phone')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->customer_phone : $order->guest_info->billing_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.address')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->address : $order->guest_info->billing_address}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.city')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getCity->name : $order->guest_info->getBillingCity->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.state')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getState->name : $order->guest_info->getBillingState->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.country')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getCountry->name : $order->guest_info->getBillingCountry->name}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('defaultTheme.seller_info')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.name')}}</td>
                                        <td>:  {{app('general_setting')->company_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.phone')}}</td>
                                        <td>:  <a href="tel:{{app('general_setting')->phone}}">{{app('general_setting')->phone}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.email')}}</td>
                                        <td>:  <a href="mailto:{{app('general_setting')->email}}">{{app('general_setting')->email}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('order.website')}}</td>
                                        <td><a href="#">:  {{ app('general_setting')->website_url }}</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('defaultTheme.shipping_info')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.name')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->name : $order->guest_info->shipping_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.email')}}</td>
                                        <td><a href="mailto:{{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->shipping_email}}">: {{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->shipping_email}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.phone')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->customer_phone : $order->guest_info->shipping_phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.address')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->address : $order->guest_info->shipping_address}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.city')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getCity->name : $order->guest_info->getShippingCity->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.state')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getState->name : $order->guest_info->getShippingState->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.country')}}</td>
                                        <td>: {{($order->customer_id) ? $order->shipping_address->getCountry->name : $order->guest_info->getShippingCountry->name}}</td>
                                    </tr>
                                </table>
                            </div>
                            @php
                                $seller_id = getParentSellerId();
                                $order_packages = $order->packages->where('seller_id', $seller_id)->where('package_code', $package->package_code)->first();
                            @endphp
                            @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                @php
                                    $total_gst = 0;
                                @endphp
                                @foreach ($order_packages->gst_taxes as $key => $gst_tax)
                                    @php
                                        $total_gst += $gst_tax->amount;
                                    @endphp
                                @endforeach
                            @endif
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('defaultTheme.payment_info')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.payment_method')}}</td>
                                        <td>: {{$order->GatewayName}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.amount')}}</td>
                                        <td>: {{single_price($order_packages->products->sum('total_price') + $order_packages->shipping_cost + $order_packages->tax_amount + $total_gst)}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('order.txn_id')}}</td>
                                        <td>: {{@$order->order_payment->txn_id}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('common.date')}}</td>
                                        <td>: {{date(app('general_setting')->dateFormat->format, strtotime(@$order->order_payment->created_at))}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('defaultTheme.payment_status')}}</td>
                                        <td>:
                                            @if ($order->is_paid == 1)
                                                <span>{{__('common.paid')}}</span>
                                            @else
                                                <span>{{__('common.pending')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-12 mt-30">
                                @if ($order_packages->is_cancelled == 1)
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label red" for="">
                                            {{__('defaultTheme.order_cancelled')}} - ({{ $order_packages->package_code }})
                                        </label>
                                    </div>

                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label sub-title" for="">
                                            {{ @$order_packages->cancel_reason->name }}
                                        </label>
                                    </div>
                                @endif
                                <div class="box_header common_table_header">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.package')}}: {{ $order_packages->package_code }}</h3>
                                    <ul class="d-flex float-right">
                                        <li> <strong>Shipping Method : {{ $order_packages->shipping->method_name }}</strong></li>
                                    </ul>
                                </div>
                                <div class="box_header common_table_header">
                                    @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                        <div>
                                            @foreach ($order_packages->gst_taxes as $key => $gst_tax)
                                                <h5>{{ $gst_tax->gst->name }} : {{ single_price($gst_tax->amount) }}</h5>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{__('common.sl')}}</th>
                                                        <th scope="col">{{__('common.image')}}</th>
                                                        <th scope="col">{{__('common.name')}}</th>
                                                        <th scope="col">{{__('common.qty')}}</th>
                                                        <th scope="col">{{__('common.price')}}</th>
                                                        <th scope="col">{{__('common.tax')}}</th>
                                                        <th scope="col">{{__('common.total')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order_packages->products as $key => $package_product)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>
                                                                <div class="product_img_div">
                                                                    @if ($package_product->type == "gift_card")
                                                                        <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}"
                                                                             alt="#">
                                                                    @else
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}"
                                                                                 alt="#">
                                                                        @else
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}"
                                                                                 alt="#">
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if ($package_product->type == "gift_card")
                                                                    {{ @$package_product->giftCard->name }} <br>
                                                                    <a class="green gift_card_div pointer" data-gift-card-id='{{ $package_product->giftCard->id }}' data-qty='{{ $package_product->qty }}' data-customer-mail='{{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->shipping_email}}' data-order-id='{{ $order->id }}'><i class="ti-email mr-1 green"></i>
                                                                        {{($order->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first() != null && $order->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first()->is_mail_sent) ? "Sent Already" : "Send Code Now"}}
                                                                    </a>
                                                                @else
                                                                    {{ @$package_product->seller_product_sku->sku->product->product_name }}
                                                                    @if (@$package_product->seller_product_sku->product->is_digital)
                                                                        <br><a class="green is_digital_div pointer" data-customer-id='{{ $order->customer_id }}' data-product-sku-id='{{ @$package_product->seller_product_sku->product_sku_id }}' data-seller-sku-id='{{ @$package_product->seller_product_sku->id }}' data-seller-id='{{ $order_packages->seller_id }}' data-package-id='{{ $order_packages->id }}' data-qty='{{ $package_product->qty }}' data-customer-mail='{{($order->customer_id) ? $order->shipping_address->customer_email : $order->guest_info->shipping_email}}' data-order-id='{{ $order->id }}'><i class="ti-email mr-1 green"></i>
                                                                            Sent Link to mail
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @if ($package_product->type == "gift_card")
                                                                <td>Qty: {{ $package_product->qty }}</td>
                                                            @else
                                                                @if (@$package_product->seller_product_sku->sku->product->product_type == 2)
                                                                    <td>
                                                                        Qty: {{ $package_product->qty }}
                                                                        <br>
                                                                        @php
                                                                            $countCombinatiion = count(@$package_product->seller_product_sku->product_variations);
                                                                        @endphp
                                                                        @foreach (@$package_product->seller_product_sku->product_variations as $key => $combination)
                                                                            @if ($combination->attribute->name == 'Color')
                                                                                <div class="box_grid ">
                                                                                    <span>{{ $combination->attribute->name }}:</span><span class='box variant_color' style="background-color:{{ $combination->attribute_value->value }}"></span>
                                                                                </div>
                                                                            @else
                                                                                {{ $combination->attribute->name }}:
                                                                                {{ $combination->attribute_value->value }}
                                                                            @endif
                                                                            @if ($countCombinatiion > $key + 1)
                                                                                <br>
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                @else
                                                                    <td>Qty: {{ $package_product->qty }}</td>
                                                                @endif
                                                            @endif

                                                            <td>{{ single_price($package_product->price) }}</td>
                                                            <td>{{ single_price($package_product->tax_amount) }}</td>
                                                            <td>{{ single_price($package_product->price * $package_product->qty + $package_product->tax_amount) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('order.order_info')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('order.is_paid')}}</td>
                                        <td>: {{ $order->is_paid == 1 ? __('common.yes') : __('common.no') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('order.is_cancelled')}}</td>
                                        <td>: {{ $order->is_cancelled == 1 ? __('common.yes') : __('common.no') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{__('common.order_summary')}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('order.subtotal')}}</td>
                                        <td>: {{single_price($order_packages->products->sum('total_price'))}}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('common.shipping_charge')}}</td>
                                        <td>: {{single_price($order_packages->shipping_cost)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="info_tbl">{{__('common.tax')}}</td>
                                        <td>: {{single_price($order_packages->tax_amount)}}</td>
                                    </tr>
                                    @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                        @php
                                            $total_gst = 0;
                                        @endphp
                                        @foreach ($order_packages->gst_taxes as $key => $gst_tax)
                                            @php
                                                $total_gst += $gst_tax->amount;
                                            @endphp
                                            <tr>
                                                <td class="info_tbl">{{ $gst_tax->gst->name }}</td>
                                                <td>: {{single_price($gst_tax->amount)}}</td>
                                            </tr>

                                        @endforeach
                                    @endif
                                    <tr>
                                        <td class="info_tbl">{{__('order.grand_total')}}</td>
                                        @if (file_exists(base_path().'/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax"))
                                            <td>: {{single_price($order_packages->products->sum('total_price') + $order_packages->shipping_cost + $order_packages->tax_amount + $total_gst)}}</td>
                                        @else
                                            <td>: {{single_price($order_packages->products->sum('total_price') + $order_packages->shipping_cost + $order_packages->tax_amount)}}</td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 student-details">

                    @if ($order->is_cancelled != 1 && $order_packages->is_cancelled != 1)
                        @if (permissionCheck('order_manage.update_delivery_status'))
                            <form action="{{ route('order_manage.update_delivery_status', $order_packages->id) }}" method="post">
                                @csrf
                                <div class="row white_box p-25 box_shadow_white mr-0 ml-0">
                                    @if($order_packages->order->is_confirmed == 0)
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_selectlabel alert alert-warning">
                                                Status is changable after confirmed the order.

                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-12 p-0">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for=""> <strong>{{ __('order.delivery_status') }}</strong></label>
                                            <select class="primary_select mb-25" name="delivery_status" id="delivery_status" {{$order_packages->order->is_confirmed == 0?'disabled':''}}>
                                                @foreach ($processes as $key => $process)
                                                    <option value="{{ $process->id }}" @if ($order_packages->delivery_status == $process->id) selected @endif>{{ $process->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 p-0">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for=""> <strong>{{ __('order.note') }}</strong> </label>
                                            <textarea class="primary_textarea height_112 address" placeholder="{{ __('order.note') }}" name="note" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 p-0 text-center">
                                        <button class="primary_btn_2"><i class="ti-check"></i>{{ __('common.update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        <div class="row mt-2 mr-0 ml-0 white_box p-25 box_shadow_white">
                            <div class="col-lg-12 p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th scope="col">{{ __('common.state') }}</th>
                                            <th scope="col">{{ __('common.date') }}</th>
                                            <th scope="col">{{ __('common.note') }}</th>
                                            <th scope="col">{{ __('common.updated_by') }}</th>
                                        </tr>
                                        @foreach ($order_packages->delivery_states as $key => $delivery_state)
                                            <tr>
                                                <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$delivery_state->delivery_process->created_at)) }}</td>
                                                <td>{{$delivery_state->created_at}}</td>
                                                <td>{{ @$delivery_state->note }}</td>
                                                <td>{{ @$delivery_state->creator->first_name }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                    @endif

                    @if($order->note != null)
                        <div class="row white_box p-25 ml-0 mr-0 box_shadow_white mt-20">
                            <div class="description_box">
                                <h4 class="f_s_14 f_w_500 mb_10">{{__('common.order')}} {{__('common.note')}}:</h4>
                                <p class="f_w_400">
                                    {{$order->note}}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script type="text/javascript">

        (function($){
            "use strict";
            $(document).ready(function(){

                $(document).on('click', '.is_digital_div', function(){
                    var customer_id = $(this).attr("data-customer-id");
                    var seller_id = $(this).attr("data-seller-id");
                    var order_id = $(this).attr("data-order-id");
                    var package_id = $(this).attr("data-package-id");
                    var seller_product_sku_id = $(this).attr("data-seller-sku-id");
                    var product_sku_id = $(this).attr("data-product-sku-id");
                    var mail = $(this).attr("data-customer-mail");
                    var qty = $(this).attr("data-qty");

                    console.log(customer_id+'-'+seller_id+'-'+order_id+'-'+package_id+'-'+seller_product_sku_id+'-'+product_sku_id+'-'+mail+'-'+qty)
                    $(this).text('Sending.....');
                    var _this = this;
                    $.post('{{ route('send_digital_file_access_to_customer') }}', {_token:'{{ csrf_token() }}', customer_id:customer_id, seller_id:seller_id, order_id:order_id, package_id:package_id, seller_product_sku_id:seller_product_sku_id, product_sku_id:product_sku_id, mail:mail, qty:qty}, function(data){
                        console.log(data)
                        if (data == "true" || data == 1) {
                            toastr.success("{{__('common.mail_has_been_sent_successful')}}","{{__('common.success')}}")
                            $(_this).text('Sent')
                        }else {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                            $(_this).text('Send Code Now')
                        }
                    });
                });
                $(document).on('click','.gift_card_div', function(){
                    console.log(this);
                    var gift_card_id = $(this).attr("data-gift-card-id");
                    var order_id = $(this).attr("data-order-id");
                    var mail = $(this).attr("data-customer-mail");
                    var qty = $(this).attr("data-qty");
                    $(this).text('Sending.....');
                    var _this = this;
                    $.post('{{ route('send_gift_card_code_to_customer') }}', {_token:'{{ csrf_token() }}', order_id:order_id, mail:mail, gift_card_id:gift_card_id, qty:qty}, function(data){
                        console.log(data)
                        if (data == "true" || data == 1) {

                            toastr.success("{{__('common.mail_has_been_sent_successful')}}","{{__('common.success')}}")
                            $(_this).text('Sent')
                        }else {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $(_this).text('Send Code Now')
                        }

                    });
                });

                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    setTimeout(function () {
                        window.location.reload();
                    }, 15000);
                }
            });
        })(jQuery);


    </script>
@endpush
