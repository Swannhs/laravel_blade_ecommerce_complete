@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('common.dashboard') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')


            <div class="col-xl-9 col-md-7">
                <div class="dashboard_item">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('frontend.my_purchase_order_list') }}">
                                <div class="single_dashboard_item order">
                                    <i class="ti-shopping-cart-full"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_order_count }}</h4>
                                        <p>{{ __('order.all_order') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('frontend.my_purchase_order_list') }}">
                                <div class="single_dashboard_item order">
                                    <i class="ti-thumb-up"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_confirmed_order_count }}</h4>
                                        <p>{{ __('order.confirmed_orders') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('frontend.my_purchase_order_list') }}">
                                <div class="single_dashboard_item coupons">
                                    <i class="ti-reload"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_processing_order_count }}</h4>
                                        <p>{{ __('order.processing_order') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('frontend.my_purchase_order_list') }}">
                                <div class="single_dashboard_item disputes">
                                    <i class="ti-check"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_completed_order_count }}</h4>
                                        <p>{{ __('order.complete_order') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('frontend.my-wishlist') }}">
                                <div class="single_dashboard_item wishlist">
                                    <i class="ti-heart"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_wishlist_count }}</h4>
                                        <p>{{ __('customer_panel.my_wishlist') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="single_dashboard_item disputes">
                                <i class="ti-shopping-cart"></i>
                                <div class="single_dashboard_text">
                                    <h4>{{ $total_item_in_carts }}</h4>
                                    <p>{{ __('common.cart') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('refund.frontend.index') }}">
                                <div class="single_dashboard_item wishlist">
                                    <i class="ti-shift-left"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_success_refund }}</h4>
                                        <p>{{ __('refund.refund_success') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{url('/profile/coupons')}}">
                                <div class="single_dashboard_item disputes">
                                    <i class="ti-receipt"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_coupon_used }}</h4>
                                        <p>{{ __('common.total_coupon_used') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
