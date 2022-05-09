@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('defaultTheme.product_compare') }}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/compare.css'))}}" />

@show

@section('content')

@include('frontend.default.partials._breadcrumb')



<!--  dashboard part css here -->
<section class="dashboard_part padding_top bg-white">
    <div class="container">
        <div class="row" id="compare_list_div">
            @include(theme('partials._compare_list'))
        </div>
    </div>
</section>
<!-- dashboard part css here -->
<input type="hidden" id="auth_check" value="@if(auth()->check()) 1 @else 0 @endif">

@endsection

@push('scripts')
<script>
    (function($){
            "use strict";
            $(document).ready(function(){
                carouselReactice();

                $(document).on('click', '.remove_from_compare', function(event){
                    event.preventDefault();
                    let product_sku_id = $(this).data('id');

                    if(product_sku_id){
                        $('#pre-loader').show();
                        let data = {
                            '_token' : '{{ csrf_token() }}',
                            'product_sku_id' : product_sku_id
                        }
                        $.post("{{route('frontend.compare.remove')}}", data, function(response){
                            $('#pre-loader').hide();
                            $('#compare_list_div').html(response.page);
                            $('.compare_count').text(response.totalItems);
                            carouselReactice();
                             toastr.success("{{__('defaultTheme.product_removed_from_compare_list_successfully')}}","{{__('common.success')}}");
                        });
                    }
                });

                $(document).on('click', '.reset_compare', function(event){
                    event.preventDefault();
                    $('#pre-loader').show();
                    let data = {
                        '_token' : '{{ csrf_token() }}'
                    }
                    $.post("{{route('frontend.compare.reset')}}", data, function(response){
                            $('#pre-loader').hide();
                            $('#compare_list_div').html(response.page);
                            $('.compare_count').text(response.totalItems);
                            carouselReactice();
                             toastr.success("{{__('defaultTheme.compare_reset_successfully')}}","{{__('common.success')}}");
                    });
                });

                $(document).on('click', '.addToCart', function(event){
                    event.preventDefault();
                    let product_sku_id = $(this).data('product_sku_id');
                    let seller_id = $(this).data('seller_id');
                    let shipping_method = $(this).data('shipping_method');
                    let price = $(this).data('price');
                    console.log(shipping_method);
                    addToCart(product_sku_id, seller_id, 1, price, shipping_method);

                });

                $(document).on('click', '.add_to_wishlist', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#auth_check').val();

                    if(is_login == 1){
                        addToWishlist(product_id, seller_id);
                        $(this).addClass('is_wishlist');
                    }else{
                         toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }

                });

                function carouselReactice(){
                    if(('.compare_product_active').length > 0){
                        $('.compare_product_active').owlCarousel({
                        loop:false,
                        margin:-1,
                        items:1,
                        autoplay:false,
                        navText:['<i class="ti-arrow-left"></i>','<i class="ti-arrow-right"></i>'],
                        nav:true,
                        dots:false,
                        autoplayHoverPause: true,
                        autoplaySpeed: 800,
                        responsive:{
                            0:{
                                items:1,
                                nav:false,
                            },
                            767:{
                                items:2,
                                nav:false,
                            },
                            992:{
                                items:3
                            },
                            1400:{
                                items:3
                            }
                        }
                        });
                    }
                }

            });
        })(jQuery);
</script>
@endpush
