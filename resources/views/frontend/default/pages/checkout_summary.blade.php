@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/checkout_summary.css'))}}" />


@endsection
@section('content')

    @include('frontend.default.partials._breadcrumb')
    <section class="dashboard_part bg-white padding_top padding_bottom">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-8">
                    <div class="delivery_details_wrapper">
                        <div class="delivery_details_top text-center">
                            <h3>{{ __('defaultTheme.thank_you_for_your_purchase') }}!</h3>
                            <p>{{ __('defaultTheme.your_order_number_is') }} {{ $order->order_number }}</p>
                        </div>
                        <h4 class="delivery_title"> {{ __('defaultTheme.your_delivery_dates') }} </h4>
                        <div class="delivery_details_box">
                            @foreach ($order->packages as $key => $package)
                                <div class="single_delivery_box">
                                    <div class="delivery_box_left">
                                        @foreach ($package->products as $key => $package_product)
                                            @if ($package_product->type == "gift_card")
                                                <div class="product_img_div">
                                                    <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                </div>
                                            @else
                                                <div class="product_img_div">
                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                        <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                    @else
                                                        <img src="{{showImage((@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img)??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="#">
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <h5>{{ $package->shipping_date }}</h5>
                                </div>
                            @endforeach
                            <div class="order_texts">
                                <p>{{ __('defaultTheme.for_more_details_track_your_delivery_status_order') }} <span>{{ __('customer_panel.my_account') }} > {{ __('order.my_order') }}</span></p>
                                <a href="{{ route('frontend.my_purchase_order_detail', encrypt($order->id)) }}" target="_blank" class="btn_1 m-0">view Order</a>
                            </div>
                        </div>

                        <div class="email_confimation">
                            <i class="ti-email"></i>
                            <p>{{ __('defaultTheme.we_have_a_confirmation_email_to') }} {{ $order->customer_email }} {{ __('defaultTheme.with_the_order_details') }}</p>
                        </div>
                        <div class="order_summary">
                            <h4>{{ __('defaultTheme.order_summary') }}</h4>
                            <span>{{ single_price($order->grand_total) }}</span>
                        </div>

                        <div class="continue_shoping text-center">
                            <a class="btn_1 " href="{{ route('frontend.welcome') }}">{{ __('defaultTheme.continue_shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
