@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{__('common.refund')}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/refund_details.css'))}}" />
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

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
                @foreach ($refund_request->refund_details as $key => $refund_detail)
                    <div class="refund_disputes_content">
                        <div class="disputes_content_progress">
                            @foreach ($processes as $key => $process)
                                <div class="disputes_content_item @if ($refund_detail->processing_state >= $process->id) step_complect @endif">
                                    <div class="process_count">
                                        <a href="#">{{ $key+1 }}</a>
                                    </div>
                                    <p>{{ $process->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="refund_disputes_text">
                             <div class="order_details_status">
                                 <ul class="w-100">
                                     <li>
                                         <p><span>{{__('common.order_id')}}</span>: {{ $refund_request->order->order_number }}</p>
                                         <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $refund_request->order->created_at }}</p>
                                     </li>
                                     <li>
                                         <p><span>{{__('common.status')}}</span>: {{ $refund_request->CheckConfirmed }}</p>
                                         <p><span>{{__('defaultTheme.request_sent_date')}}</span>: {{ $refund_request->created_at }}</p>
                                     </li>
                                     <li>
                                         <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price( $refund_request->total_return_amount) }}</p>
                                     </li>
                                 </ul>
                             </div>
                             <div class="refund_disputes_text_iner">
                                 @foreach ($refund_detail->refund_products as $key => $refund_product)
                                     <div class="d-flex justify-content-between mb-2">
                                         <div class="d-flex align-items-center">
                                             @if (@$refund_product->seller_product_sku->sku->product->product_type == 1)
                                                 <img src="{{asset(asset_path(@$refund_product->seller_product_sku->sku->product->thumbnail_image_source))}}" alt="#" class="refund_img mr-2">
                                             @else
                                                 <img src="{{asset(asset_path(@$refund_product->seller_product_sku->sku->variant_image))}}" alt="#" class="refund_img mr-2">
                                             @endif
                                             <p>{{ @$refund_product->seller_product_sku->sku->product->product_name }}</p>
                                         </div>
                                         <p>{{ $refund_product->return_qty }} X {{ single_price($refund_product->return_amount / $refund_product->return_qty) }}</p>
                                     </div>

                                 @endforeach
                             </div>
                        </div>
                    </div>
                @endforeach
                <div class="order_details_status">
                    <ul class="w-100">
                        <li>
                            <p><span>{{__('common.order_id')}}</span>: {{ $refund_request->order->order_number }}</p>
                            <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $refund_request->order->created_at }}</p>
                            <p><span>{{__('defaultTheme.refund_method')}}</span>: {{ strtoupper(str_replace("_"," ",$refund_request->refund_method)) }}</p>
                        </li>
                        <li>
                            <p><span>{{__('common.status')}}</span>: {{ $refund_request->CheckConfirmed }}</p>
                            <p><span>{{__('defaultTheme.request_sent_date')}}</span>: {{ $refund_request->created_at }}</p>
                            <p><span>{{__('defaultTheme.shipping_method')}}</span>: {{ strtoupper(str_replace("_"," ",$refund_request->shipping_method)) }}</p>
                        </li>
                        <li>
                            <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price( $refund_request->total_return_amount) }}</p>
                        </li>
                    </ul>
                </div>
                @if ($refund_request->shipping_method == "courier")
                    <div class="order_details_status">
                        <ul class="w-100">
                            <li>
                                <h6>{{__('defaultTheme.pick_up_info')}}</h6>
                                <p><span>{{__('defaultTheme.shipping_gateway')}}</span>: {{ @$refund_request->shipping_gateway->method_name }}</p>
                                <p><span>{{__('common.name')}}</span>: {{ @$refund_request->pick_up_address_customer->name }}</p>
                                <p><span>{{__('common.email')}}</span>: {{ @$refund_request->pick_up_address_customer->email }}</p>
                                <p><span>{{__('common.phone_number')}}</span>: {{ @$refund_request->pick_up_address_customer->phone }}</p>
                                <p><span>{{__('common.address')}}</span>: {{ @$refund_request->pick_up_address_customer->address }}</p>
                                <p><span>{{__('common.city')}}</span>: {{ @$refund_request->pick_up_address_customer->getCity->name }}</p>
                                <p><span>{{__('common.state')}}</span>: {{ @$refund_request->pick_up_address_customer->getState->name }}</p>
                                <p><span>{{__('common.postcode')}}</span>: {{ @$refund_request->pick_up_address_customer->postal_code }}</p>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="order_details_status">
                        <ul class="w-100">
                            <li>
                                <h6>{{__('defaultTheme.drop_off_info')}}</h6>
                                <p><span>{{__('defaultTheme.shipping_gateway')}}</span>: {{ @$refund_request->shipping_gateway->method_name }}</p>
                                <p><span>{{__('common.address')}}</span>: {{ $refund_request->drop_off_address }}</p>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
