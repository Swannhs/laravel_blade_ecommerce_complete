@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/order.css'))}}" />
@endsection
@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">

            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#purchase_list_data" role="tab"
                                    data-toggle="tab" aria-selected="true">{{ __('customer_panel.purchase_list') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#toPayData" role="tab" data-toggle="tab"
                                    aria-selected="true">{{ __('customer_panel.to_pay') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#toShipData" role="tab" data-toggle="tab"
                                    aria-selected="true">{{ __('customer_panel.to_ship') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#toRecieveData" role="tab" data-toggle="tab"
                                    aria-selected="true">{{ __('customer_panel.to_recieve') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="white_box_30px p-15 mb_30">
                    <form class="p-0" action="{{ route('frontend.my_purchase_order_list') }}" method="get" id="rnForm">
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <select class="primary_select mb-25 form-control" id="rn" name="rn">
                                    @isset($rn)
                                        <option value="1" @if ($rn == 8) selected @endif>8</option>
                                        <option value="2" @if ($rn == 15) selected @endif>15</option>
                                        <option value="20" @if ($rn == 20) selected @endif>20</option>
                                        <option value="40" @if ($rn == 40) selected @endif>40</option>
                                    @else
                                        <option value="8">8</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="40">40</option>
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active show" id="purchase_list_data">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('customer_panel.purchase_list') }}</h3>
                                </div>
                            </div>
                            <div class="order_details">
                                @foreach ($orders as $key => $order)
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
                                                </li>
                                                <li>
                                                    <p><span>{{__('defaultTheme.order_amount')}}:</span>: {{ single_price($order->grand_total) }}</p>
                                                </li>
                                            </ul>
                                            <a href="{{ route('frontend.my_purchase_order_pdf', encrypt($order->id)) }}" class="primary-btn radius_30px mr-10 fix-gr-bg text-white">{{__('defaultTheme.download_invoice')}} &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                        </div>
                                        <div class="order_details_iner">
                                            <div class="order_item">
                                                @foreach ($order->packages as $key => $package)
                                                    @foreach ($package->products as $key => $package_product)
                                                        @if ($package_product->type == "gift_card")
                                                            <div class="single_order_item">
                                                                <div class="order_item_name">
                                                                    <div class="product_img_div">
                                                                        <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                                    </div>

                                                                    <p>{{substr(@$package_product->giftCard->name,0,22)}} @if(strlen(@$package_product->giftCard->name) > 22)... @endif</p>
                                                                </div>
                                                                <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                                            </div>
                                                        @else
                                                            <div class="single_order_item">
                                                                <div class="order_item_name">
                                                                    <div class="product_img_div">
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                        @else

                                                                            <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                        @endif
                                                                    </div>

                                                                    <p>@if (@$package_product->seller_product_sku->product->product_name) {{ substr(@$package_product->seller_product_sku->product->product_name,0,22) }} @if(strlen(@$package_product->seller_product_sku->product->product_name) > 22)... @endif @else {{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif @endif</p>


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
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                            <div class="order_details_btn">
                                                <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order->id)) }}" target="_blank" class="btn_2">{{__('defaultTheme.order_details')}}</a>
                                                <a href="#" class="btn_2">{{__('defaultTheme.contact_seller')}}</a>
                                                @if (\Carbon\Carbon::now() <= $order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $order->is_cancelled == 0)
                                                    <a href="{{ route('refund.make_request', encrypt($order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                @endif
                                                @if ($order->is_confirmed == 0)
                                                    @if ($order->is_cancelled == 0)
                                                        <a data-order-id="{{ $order->id }}" class="btn_2 order_cancel">{{__('defaultTheme.cancel_order')}}</a>
                                                    @else
                                                        <a class="btn_2">{{__('defaultTheme.order_cancelled')}}</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if (strpos($_SERVER['REQUEST_URI'], 'rn'))
                                    @include(theme('pages.profile.partials.paginations'), ['orders' => $orders->appends('rn',$rn), 'request_type' => request()->myPurchaseOrderList])
                                @else
                                    @include(theme('pages.profile.partials.paginations'), ['orders' => $orders, 'request_type' => request()->myPurchaseOrderList])
                                @endif
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="toPayData">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('customer_panel.to_pay') }}</h3>
                                </div>
                            </div>
                            <div class="order_details">
                                @foreach ($no_paid_orders as $key => $no_paid_order)
                                    <div class="single_order_part">
                                        <div class="order_details_status">
                                            <ul class="w-100">
                                                <li>
                                                    <p><span>{{__('common.order_id')}}</span>: {{ $no_paid_order->order_number }}</p>
                                                    <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $no_paid_order->created_at }}</p>
                                                </li>
                                                <li>
                                                    @if ($no_paid_order->is_confirmed == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                    @elseif ($no_paid_order->is_confirmed == 2)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                    @else
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                    @endif
                                                </li>
                                                <li>
                                                    <p><span>{{__('defaultTheme.order_amount')}}:</span>: {{ single_price($no_paid_order->grand_total) }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order_details_iner">
                                            <div class="order_item">
                                                @foreach ($no_paid_order->packages as $key => $package)
                                                    @foreach ($package->products as $key => $package_product)
                                                        <div class="single_order_item">
                                                            <div class="order_item_name">
                                                                <div class="product_img_div">
                                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                        <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                    @else

                                                                        <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                    @endif
                                                                </div>

                                                                <p>@if (@$package_product->seller_product_sku->product->product_name) {{ substr(@$package_product->seller_product_sku->product->product_name,0,22) }} @if(strlen(@$package_product->seller_product_sku->product->product_name) > 22)... @endif @else {{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif @endif</p>

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
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                            <div class="order_details_btn">
                                                <a href="{{ route('frontend.my_purchase_order_detail', encrypt($no_paid_order->id)) }}" target="_blank" class="btn_2">{{__('defaultTheme.order_details')}}</a>
                                                <a href="#" class="btn_2">{{__('defaultTheme.contact_seller')}}</a>
                                                @if (\Carbon\Carbon::now() <= $no_paid_order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status))
                                                    <a href="{{ route('refund.make_request', encrypt($no_paid_order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @include(theme('pages.profile.partials.paginations'), ['orders' => $no_paid_orders, 'request_type' => request()->myPurchaseOrderListNotPaid])
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="toShipData">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('customer_panel.to_ship') }}</h3>
                                </div>
                            </div>
                            <div class="order_details">
                                @foreach ($to_shippeds as $key => $order_package)
                                    <div class="single_order_part">
                                        <div class="order_details_status">
                                            <ul class="w-100">
                                                <li>
                                                    <p><span>{{__('common.order_id')}}</span>: {{ $order_package->order->order_number }}</p>
                                                    <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $order_package->order->created_at }}</p>
                                                </li>
                                                <li>
                                                    @if ($order_package->order->is_confirmed == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                    @elseif ($no_paid_order->is_confirmed == 2)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                    @else
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                    @endif
                                                </li>
                                                <li>
                                                    <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price($order_package->order->grand_total) }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order_details_iner">
                                            <div class="order_item">
                                                @foreach ($order_package->products as $key => $package_product)
                                                    <div class="single_order_item">
                                                        <div class="order_item_name">
                                                            <div class="product_img_div">
                                                                @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                @else

                                                                    <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                @endif
                                                            </div>

                                                           <p>@if (@$package_product->seller_product_sku->product->product_name) {{ substr(@$package_product->seller_product_sku->product->product_name,0,22) }} @if(strlen(@$package_product->seller_product_sku->product->product_name) > 22)... @endif @else {{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif @endif</p>

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

                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="order_details_btn">
                                                <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order_package->order->id)) }}" target="_blank" class="btn_2">{{__('defaultTheme.order_details')}}</a>
                                                <a href="#" class="btn_2">{{__('defaultTheme.contact_seller')}}</a>
                                                <a class="btn_2 change_delivery_state_status pointer" data-package-id="{{ $order_package->id }}">{{__('defaultTheme.confirm_receive_items')}}</a>
                                                @if (\Carbon\Carbon::now() <= $order_package->order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status))
                                                    <a href="{{ route('refund.make_request', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @include(theme('pages.profile.partials.paginations'), ['orders' => $to_shippeds, 'request_type' => request()->toShipped])
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="toRecieveData">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('customer_panel.to_recieve') }}</h3>
                                </div>
                            </div>
                            <div class="order_details">
                                @foreach ($to_recieves as $key => $order_package)
                                    <div class="single_order_part">
                                        <div class="order_details_status">
                                            <ul class="w-100">
                                                <li>
                                                    <p><span>{{__('common.order_id')}}</span>: {{ $order_package->order->order_number }}</p>
                                                    <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $order_package->order->created_at }}</p>
                                                </li>
                                                <li>
                                                    @if ($order_package->order->is_confirmed == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                    @elseif ($no_paid_order->is_confirmed == 2)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                    @else
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                    @endif
                                                </li>
                                                <li>
                                                    <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price($order_package->order->grand_total) }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order_details_iner">
                                            <div class="order_item">
                                                @foreach ($order_package->products as $key => $package_product)
                                                    <div class="single_order_item">
                                                        <div class="order_item_name">
                                                            <div class="product_img_div">
                                                                @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                    <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                @else

                                                                    <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                @endif
                                                            </div>

                                                           <p>@if (@$package_product->seller_product_sku->product->product_name) {{ substr(@$package_product->seller_product_sku->product->product_name,0,22) }} @if(strlen(@$package_product->seller_product_sku->product->product_name) > 22)... @endif @else {{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif @endif</p>

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
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="order_details_btn">
                                                <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.order_details')}}</a>
                                                <a href="#" class="btn_2">{{__('defaultTheme.contact_seller')}}</a>
                                                <a class="btn_2 change_delivery_state_status pointer" data-package-id="{{ $order_package->id }}">{{__('defaultTheme.confirm_receive_items')}}</a>
                                                @if (\Carbon\Carbon::now() <= $order_package->order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status))
                                                    <a href="{{ route('refund.make_request', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @include(theme('pages.profile.partials.paginations'), ['orders' => $to_recieves, 'request_type' => request()->toRecievedList])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click','.change_delivery_state_status', function(){
            change_delivery_state_status($(this).attr('data-package-id'));
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
        $(document).on('click','.order_cancel',function(){
            orderCancelById($(this).attr('data-order-id'));
        });
        $(document).on('change','#rn',function(){
            $("#rnForm").submit();
        });

        function orderCancelById(el)
        {
            $("#pre-loader").show();
            var status = 1;
            $.post('{{ route('frontend.order_cancel_by_customer') }}', {_token:'{{ csrf_token() }}', id:el, status:status}, function(data){
                if (data == 1) {
                    toastr.success("{{__('defaultTheme.order_has_been_cancelled')}}", "{{__('common.success')}}");
                }else {
                    toastr.error("{{__('defaultTheme.order_cancellation_has_failed')}} {{__('common.error_message')}}", "{{__('common.error_message')}}");
                }
                $("#pre-loader").hide();
            });
        }
    </script>
@endpush
