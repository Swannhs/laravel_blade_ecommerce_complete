@extends('frontend.default.layouts.app')

@section('breadcrumb')

    {{ __('common.flash_deals') }}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/flash_deal.css'))}}" />
<style>
    .bradcam_bg_1 {
        background-image: url({{asset(asset_path($Flash_Deal->banner_image))}});
    }
</style>


@endsection
@section('content')

@php
    $start_date = date('Y/m/d',strtotime($Flash_Deal->start_date));
    $end_date = date('Y/m/d',strtotime($Flash_Deal->end_date));
    $current_date = date('Y/m/d');
    $deal_date = '1990/01/01';
    if($start_date<= $current_date && $end_date >= $current_date){
        $deal_date = $end_date;
    }
    elseif ($start_date >= $current_date && $end_date >= $current_date) {
        $deal_date = $start_date;
    }

@endphp


<div class="breadcrumb_area bradcam_bg_1">
    <div class="bradcam_text">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">

            </div>
        </div>
    </div>
</div>

    <section class="dashboard_part category_part bg-white padding_top bannerDiv">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  <div class="category_product_page">
                    <div class="product_page_tittle d-flex justify-content-between countdownDiv">
                    <h4 class="end_text font_14 f_w_600 theme_text text-uppercase">
                        @if($start_date <= $current_date && $end_date >= $current_date)
                        {{__('defaultTheme.deal_ends_in')}}
                        @elseif($start_date >= $current_date && $end_date >= $current_date)
                        {{__('defaultTheme.deal_starts_in')}}
                        @else
                        {{__('defaultTheme.deal_ends')}}
                        @endif
                    </h4>
                        <div id="count_down" class="deals_end_count">
                    </div>
                    </div>
                    <div id="productShow">
                        @include('frontend.default.partials.flash_deal_paginate_data')
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="add-product-to-cart-using-modal">

        </div>

        <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
    </section>


@endsection
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
@push('scripts')
<script src="{{asset(asset_path('frontend/default/vendors/countdown/countdown.min.js'))}}"></script>
<script>
    (function($){
        "use strict";

        $(document).ready(function(){
            $(document).on('click', '.page-item a', function(event){
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetch_data(page);

            });

            function fetch_data(page){
            $('#pre-loader').show();
            if(page != 'undefined'){
                $.ajax({
                url:"{{route('frontend.flash-deal.fetch-data',$Flash_Deal->slug)}}"+'?page='+page,
                success:function(data)
                {
                    $('#productShow').html(data);
                    $('#product_short_list').niceSelect();
                    $('#pre-loader').hide();
                }
                });
            }else{
                toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
            }

            }

            if($('#count_down').length> 0){
                $('#count_down').countdown('{{$deal_date}}', function(event) {
                $(this).html(event.strftime('<div class="single_count"><span>%D</span><span class="count_title">days</span></div><div class="single_count"><span><span>:</span>%H</span><span class="count_title">Hours</span></div><div class="single_count"><span><span>:</span>%M</span><span class="count_title">Minutes</span></div><div class="single_count"><span><span>:</span>%S</span><span class="count_title">SECONDS</span></div>'));
                });
            }
        });
    })(jQuery);

</script>
@endpush

