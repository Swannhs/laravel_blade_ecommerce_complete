@extends('frontend.default.layouts.app')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/order.css'))}}" />

@section('breadcrumb')
    {{ __('common.orders') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="account_details">
                     <ul class="nav nav-tabs" id="myTab" role="tablist">
                         <li class="nav-item">
                             <a class="nav-link @if (Request::get('myPurchaseOrderList') != null || (Request::get('myPurchaseOrderListNotPaid') == null && Request::get('toShipped') == null && Request::get('toRecievedList') == null)) active @endif" id="Basic-tab" data-toggle="tab" href="#AllList" role="tab" aria-controls="Basic" aria-selected="true">{{__('common.all')}}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link @if (Request::get('myPurchaseOrderListNotPaid') != null) active @endif" id="Password-tab" data-toggle="tab" href="#toPayList" role="tab" aria-controls="Password" aria-selected="false">{{__('defaultTheme.to_pay')}}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link @if (Request::get('toShipped') != null) active @endif" id="toShip-tab" data-toggle="tab" href="#toShip" role="tab" aria-controls="Addresses" aria-selected="false">{{__('defaultTheme.to_ship')}}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link @if (Request::get('toRecievedList') != null) active @endif" id="toRecieve-tab" data-toggle="tab" href="#toRecieve" role="tab" aria-controls="Addresses" aria-selected="false">{{__('defaultTheme.to_recieve')}}</a>
                         </li>
                     </ul>
                     <div class="tab-content" id="myTabContent">
                         <div class="tab-pane fade @if (Request::get('myPurchaseOrderList') != null || (Request::get('myPurchaseOrderListNotPaid') == null && Request::get('toShipped') == null && Request::get('toRecievedList') == null)) show active @endif" id="AllList" role="tabpanel" aria-labelledby="Basic-tab">
                            @if(count($orders) > 0)
                            <form class="p-0" action="{{ route('frontend.my_purchase_order_list') }}" method="get" id="rnForm">
                                 <div class="row mt-3">
                                     <div class="col-md-3">
                                         <select class="nc_select form-control" id="rn" name="rn">
                                             @isset($rn)
                                                 <option value="5" @if ($rn == 5) selected @endif>5</option>
                                                 <option value="10" @if ($rn == 10) selected @endif>10</option>
                                                 <option value="20" @if ($rn == 20) selected @endif>20</option>
                                                 <option value="40" @if ($rn == 40) selected @endif>40</option>
                                             @else
                                                 <option value="5">5</option>
                                                 <option value="10">10</option>
                                                 <option value="20">20</option>
                                                 <option value="40">40</option>
                                             @endisset
                                         </select>
                                     </div>
                                 </div>
                            </form>
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
                                                 </li>
                                                 <li>
                                                     <p><span>{{__('defaultTheme.order_amount')}}:</span>: {{ single_price($order->grand_total) }}</p>
                                                 </li>
                                             </ul>
                                             <a href="{{ route('frontend.my_purchase_order_pdf', encrypt($order->id)) }}" class="btn_1 nowrap">{{__('defaultTheme.download_invoice')}}</a>
                                         </div>
                                         <div class="order_details_iner">
                                             <div class="order_item">
                                                 @foreach ($order->packages as $key => $package)
                                                     @foreach ($package->products as $key => $package_product)
                                                         @if ($package_product->type == "gift_card")
                                                             <div class="single_order_item">
                                                                 <div class="order_item_name">
                                                                    <div class="item_img_div">
                                                                        <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                                    </div>
                                                                     <p>{{substr(@$package_product->giftCard->name,0,22)}} @if(strlen(@$package_product->giftCard->name) > 22)... @endif</p>
                                                                 </div>
                                                                 <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                                             </div>
                                                         @else
                                                             <div class="single_order_item">
                                                                 <div class="order_item_name">
                                                                     <div class="item_img_div">
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                        @else

                                                                            <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                        @endif
                                                                     </div>

                                                                     <p>@if (@$package_product->seller_product_sku->product->product_name) {{ substr(@$package_product->seller_product_sku->product->product_name,0,22) }} @if(strlen(@$package_product->seller_product_sku->product->product_name) > 22)... @endif @else {{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif @endif</p>

                                                                     @if(@$package_product->seller_product_sku->sku->product->product_type == 2)
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
                                                 <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order->id)) }}" class="btn_2">{{__('defaultTheme.order_details')}}</a>

                                                 @if (\Carbon\Carbon::now() <= $order->updated_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $order->is_cancelled == 0 && $order->is_completed == 1)
                                                     <a href="{{ route('refund.make_request', encrypt($order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                 @endif
                                                 @if ($order->is_confirmed == 0)
                                                     @if ($order->is_cancelled == 0)
                                                         <a data-id={{ $order->id }} class="btn_2 order_cancel_by_id">{{__('defaultTheme.cancel_order')}}</a>
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
                            @else
                                <div class="row">
                                    <div class="col-lg-12 empty_list">
                                        <span class="text-canter">{{ __('order.no_order_found') }}</span>
                                    </div>
                                </div>
                            @endif
                         </div>
                         <div class="tab-pane fade @if (Request::get('myPurchaseOrderListNotPaid') != null) show active @endif" id="toPayList" role="tabpanel" aria-labelledby="Password-tab">
                            @if(count($no_paid_orders) > 0)
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
                                                    @if($no_paid_order->is_cancelled == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.cancelled')}}</p>
                                                    @elseif($no_paid_order->is_completed == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.completed')}}</p>
                                                    @else
                                                        @if ($no_paid_order->is_confirmed == 1)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                        @elseif ($no_paid_order->is_confirmed == 2)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                        @else
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                        @endif
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
                                                        @if ($package_product->type == "gift_card")
                                                        <div class="single_order_item">
                                                            <div class="order_item_name">
                                                                <div class="item_img_div">
                                                                    <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                                </div>
                                                                <p>{{ @$package_product->giftCard->name }}</p>
                                                            </div>
                                                            <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                                        </div>
                                                        @else
                                                            <div class="single_order_item">
                                                                <div class="order_item_name">
                                                                    <div class="item_img_div">
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                        @else

                                                                            <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                        @endif
                                                                    </div>
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
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                 @endforeach
                                             </div>
                                             <div class="order_details_btn">
                                                 <a href="{{ route('frontend.my_purchase_order_detail', encrypt($no_paid_order->id)) }}" class="btn_2">{{__('defaultTheme.order_details')}}</a>

                                                 @if (\Carbon\Carbon::now() <= $no_paid_order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $order->is_cancelled == 0 && $order->is_completed == 1)
                                                     <a href="{{ route('refund.make_request', encrypt($no_paid_order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                 @endif

                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                                 @include(theme('pages.profile.partials.paginations'), ['orders' => $no_paid_orders, 'request_type' => request()->myPurchaseOrderListNotPaid])
                            </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12 empty_list">
                                        <span class="text-canter">{{ __('order.no_order_found') }}</span>
                                    </div>
                                </div>
                            @endif
                         </div>
                         <div class="tab-pane fade @if (Request::get('toShipped') != null) show active @endif" id="toShip" role="tabpanel" aria-labelledby="Addresses-tab">
                            @if(count($to_shippeds) > 0)
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
                                                    @if($order_package->order->is_cancelled == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.cancelled')}}</p>
                                                    @elseif($order_package->order->is_completed == 1)
                                                        <p><span>{{__('common.status')}}</span>: {{__('common.completed')}}</p>
                                                    @else
                                                        @if ($order_package->order->is_confirmed == 1)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                        @elseif ($order_package->order->is_confirmed == 2)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                        @else
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                        @endif
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

                                                    @if ($package_product->type == "gift_card")
                                                        <div class="single_order_item">
                                                            <div class="order_item_name">
                                                                <div class="item_img_div">
                                                                    <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                                </div>
                                                                <p>{{ @$package_product->giftCard->name }}</p>
                                                            </div>
                                                            <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                                        </div>
                                                    @else
                                                        <div class="single_order_item">
                                                            <div class="order_item_name">
                                                                <div class="item_img_div">
                                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                    <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                    @else

                                                                        <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                                    @endif
                                                                </div>
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

                                                        </div>

                                                    @endif
                                                @endforeach
                                             </div>
                                             <div class="order_details_btn">
                                                 <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.order_details')}}</a>

                                                 <a data-package_id="{{ $order_package->id }}" class="btn_2 change_delivery_state_status">{{__('defaultTheme.confirm_receive_items')}}</a>
                                                 @if (\Carbon\Carbon::now() <= $order_package->order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $order->is_cancelled == 0 && $order->is_completed == 1)
                                                     <a href="{{ route('refund.make_request', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                 @endif
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                                 @include(theme('pages.profile.partials.paginations'), ['orders' => $to_shippeds, 'request_type' => request()->toShipped])
                            </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12 empty_list">
                                        <span class="text-canter">{{ __('order.no_order_found') }}</span>
                                    </div>
                                </div>
                            @endif
                         </div>
                         <div class="tab-pane fade @if (Request::get('toRecievedList') != null) show active @endif" id="toRecieve" role="tabpanel" aria-labelledby="Addresses-tab">
                            @if(count($to_recieves) > 0)
                            <div class="order_details">
                                 @foreach ($to_recieves as $key => $order_package)
                                    @if ($package_product->type == "gift_card")
                                    <div class="single_order_item">
                                        <div class="order_item_name">
                                            <div class="item_img_div">
                                                <img src="{{asset(asset_path(@$package_product->giftCard->thumbnail_image))}}" alt="#">
                                            </div>
                                            <p>{{ @$package_product->giftCard->name }}</p>
                                        </div>
                                        <p>{{ $package_product->qty }} X {{ single_price($package_product->price) }}</p>
                                    </div>
                                    @else
                                        <div class="single_order_part">
                                            <div class="order_details_status">
                                                <ul class="w-100">
                                                    <li>
                                                        <p><span>{{__('common.order_id')}}</span>: {{ $order_package->order->order_number }}</p>
                                                        <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $order_package->order->created_at }}</p>
                                                    </li>
                                                    <li>
                                                        @if($order_package->order->is_cancelled == 1)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.cancelled')}}</p>
                                                        @elseif($order_package->order->is_completed == 1)
                                                            <p><span>{{__('common.status')}}</span>: {{__('common.completed')}}</p>
                                                        @else
                                                            @if ($order_package->order->is_confirmed == 1)
                                                                <p><span>{{__('common.status')}}</span>: {{__('common.confirmed')}}</p>
                                                            @elseif ($order_package->order->is_confirmed == 2)
                                                                <p><span>{{__('common.status')}}</span>: {{__('common.declined')}}</p>
                                                            @else
                                                                <p><span>{{__('common.status')}}</span>: {{__('common.pending')}}</p>
                                                            @endif
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
                                                                <div class="item_img_div">
                                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                    <img src="{{asset(asset_path(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source))}}" alt="#">
                                                                    @else

                                                                        <img src="{{asset(asset_path((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source))}}" alt="#">
                                                                    @endif
                                                                </div>
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
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="order_details_btn">
                                                    <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.order_details')}}</a>

                                                    @if (\Carbon\Carbon::now() <= $order_package->order->created_at->addDays(app('business_settings')->where('type', 'refund_times')->first()->status) && $order->is_cancelled == 0 && $order->is_completed == 1)
                                                        <a href="{{ route('refund.make_request', encrypt($order_package->order->id)) }}" class="btn_2">{{__('defaultTheme.open_dispute')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                 @endforeach
                                 @include(theme('pages.profile.partials.paginations'), ['orders' => $to_recieves, 'request_type' => request()->toRecievedList])
                            </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12 empty_list">
                                        <span class="text-canter">{{ __('order.no_order_found') }}</span>
                                    </div>
                                </div>
                            @endif
                         </div>
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
                    <form id="contactForm" action="{{route('frontend.order_cancel_by_customer')}}" method="post" class="send_query_form">
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

        (function($){
            "use strict";

            $(document).ready(function(){
                $(document).on('click', '.change_delivery_state_status', function(event){
                    event.preventDefault();
                    let package_id = $(this).data('package_id');
                    change_delivery_state_status(package_id);
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

                $(document).on('change', '#rn', function(){    // 2nd (A)
                    $("#rnForm").submit();
                });

                $(document).on('click','.order_cancel_by_id', function(){
                    $('#orderCancelReasonModal').modal('show');
                    $('.order_id').val($(this).attr('data-id'));
                });
            });
        })(jQuery);

    </script>
@endpush
