@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{__('defaultTheme.refunds')}}
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/refund.css'))}}" />

@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')


            <div class="col-xl-9 col-md-7">
                <div class="order_details">
                    @foreach ($my_refund_items as $key => $my_refund_item)
                        <div class="single_order_part">
                            <div class="order_details_status">
                                <ul class="w-100">
                                    <li>
                                        <p><span>{{__('common.order_id')}}</span>: {{ $my_refund_item->order->order_number }}</p>
                                        <p><span>{{__('defaultTheme.order_date')}}</span>: {{ $my_refund_item->order->created_at }}</p>
                                    </li>
                                    <li>
                                        <p><span>{{__('common.status')}}</span>: {{ $my_refund_item->CheckConfirmed }}</p>
                                        <p><span>{{__('defaultTheme.request_sent_date')}}</span>: {{ $my_refund_item->created_at }}</p>
                                    </li>
                                    <li>
                                        <p><span>{{__('defaultTheme.order_amount')}}</span>: {{ single_price( $my_refund_item->total_return_amount) }}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="order_details_iner">
                                <div class="order_item">
                                    @foreach ($my_refund_item->refund_details as $key => $refund_detail)
                                        @foreach ($refund_detail->refund_products as $key => $refund_product)
                                            <div class="single_order_item">
                                                <div class="order_item_name">
                                                    <div class="item_img_div">
                                                        @if (@$refund_product->seller_product_sku->sku->product->product_type == 1)
                                                            <img src="{{showImage(@$refund_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                        @else
                                                            @if (@$refund_product->seller_product_sku->sku->variant_image)
                                                            <img src="{{showImage(@$refund_product->seller_product_sku->sku->variant_image)}}" alt="#">
                                                            @else
                                                            <img src="{{showImage(@$refund_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                            @endif

                                                        @endif
                                                    </div>
                                                    <p>{{ @$refund_product->seller_product_sku->sku->product->product_name }}</p>
                                                </div>

                                                <p>{{ $refund_product->return_qty }} X {{ single_price($refund_product->return_amount / $refund_product->return_qty) }}</p>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                                <div class="order_details_btn">
                                    <a href="#" class="btn_2">{{ ($my_refund_item->is_completed == 1) ? "Completed" : "Waiting" }}</a>
                                    <a href="{{ route('refund.frontend.my_refund_order_detail', encrypt($my_refund_item->id)) }}" class="btn_2">{{__('defaultTheme.view_details')}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @include(theme('pages.profile.partials.paginations'), ['orders' => $my_refund_items, 'request_type' => request()->page])
                </div>
             </div>

        </div>
    </div>
</section>

@endsection
