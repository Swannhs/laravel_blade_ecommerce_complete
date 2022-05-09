@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/giftcard.css'))}}" />

   
@endsection
@section('breadcrumb')
{{ __('common.gift_cards') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<section class="category_part single_page_category">
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <div class="category_sidebar">
                    <div class="category_refress">
                        <a href="" id="refresh_btn">{{ __('defaultTheme.refresh_filters') }}</a>
                        <i class="ti-reload"></i>
                    </div>

                    <div class="single_category materials_content">
                        <div class="category_tittle">
                            <h4>{{ __('defaultTheme.rating') }}</h4>
                        </div>
                        <div class="single_category_option">
                            <nav>
                                <ul>

                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="review_star_icon">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>


                                        </a>
                                        <label class="cs_checkbox">
                                            <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="5" id="attr_value">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="review_star_icon">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                            </div>
                                        </a>
                                        <label class="cs_checkbox">
                                            <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="4" id="attr_value">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="review_star_icon">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                            </div>
                                        </a>
                                        <label class="cs_checkbox">
                                            <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="3" id="attr_value">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>

                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="review_star_icon">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                            </div>
                                        </a>
                                        <label class="cs_checkbox">
                                            <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="2" id="attr_value">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>

                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="review_star_icon">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i>
                                                <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                            </div>
                                        </a>
                                        <label class="cs_checkbox">
                                            <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="1" id="attr_value">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="single_category price_rangs">
                        <div class="category_tittle">
                            <h4>{{ __('defaultTheme.price_range') }}</h4>
                        </div>
                        <div class="single_category_option" id="price_range_div">
                            <div class="wrapper">
                                <div class="range-slider">
                                    <input type="text" class="js-range-slider-0" value=""/>
                                </div>
                                <div class="extra-controls form-inline">
                                    <div class="form-group">
                                        <div class="price_rangs">
                                            <input type="text" class="js-input-from form-control" id="min_price" value="{{$min_price}}" readonly/>
                                            <p>{{ __('common.min') }}</p>
                                        </div>
                                        <div class="price_rangs">
                                            <input type="text" class="js-input-to form-control" id="max_price" value="{{$max_price}}" readonly/>
                                            <p>{{ __('common.max') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="dataWithPaginate" class="col-lg-9">
                @include('frontend.default.partials._giftcard_list')
            </div>
        </div>
    </div>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
</section>

@endsection

@push('scripts')
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){
                var filterType = [];
                $(document).on('click', '#refresh_btn', function(event){
                    event.preventDefault();
                    fetch_data(1);

                    $('.attr_checkbox').prop('checked', false);

                    $('#price_range_div').html(
                        `<div class="wrapper">
                        <div class="range-slider">
                            <input type="text" class="js-range-slider-0" value=""/>
                        </div>
                        <div class="extra-controls form-inline">
                            <div class="form-group">
                                <div class="price_rangs">
                                    <input type="text" class="js-input-from form-control" id="min_price" value="100" readonly/>
                                    <p>Min</p>
                                </div>
                                <div class="price_rangs">
                                    <input type="text" class="js-input-to form-control" id="max_price" value="1000" readonly/>
                                    <p>Max</p>
                                </div>
                            </div>
                        </div>
                    </div>`
                    );

                    $(".js-range-slider-0").ionRangeSlider({
                        type: "double",
                        min: $('#min_price').val(),
                        max: $('#max_price').val(),
                        from: $('#min_price').val(),
                        to: $('#max_price').val(),
                        drag_interval: true,
                        min_interval: null,
                        max_interval: null
                    });

                });

                $(document).on('click', '.getProductByChoice', function(event){
                    let type = $(this).data('id');
                    let el = $(this).data('value');
                    getProductByChoice(type, el);
                });


                let minimum_price = 0;
                let maximum_price = 0;
                let price_range_gloval = 0;
                $(document).on('change', '.js-range-slider-0', function(event){
                    var price_range = $(this).val().split(';');
                    minimum_price = price_range[0];
                    maximum_price = price_range[1];
                    price_range_gloval = price_range;
                    myEfficientFn();
                });
                var myEfficientFn = debounce(function() {
                    $('#min_price').val(minimum_price);
                    $('#max_price').val(maximum_price);
                    getProductByChoice("price_range",price_range_gloval);
                }, 500);
                function debounce(func, wait, immediate) {
                    var timeout;
                    return function() {
                        var context = this, args = arguments;
                        var later = function() {
                            timeout = null;
                            if (!immediate) func.apply(context, args);
                        };
                        var callNow = immediate && !timeout;
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                        if (callNow) func.apply(context, args);
                    };
                };


                $(".js-range-slider-0").ionRangeSlider({
                    type: "double",
                    min: $('#min_price').val(),
                    max: $('#max_price').val(),
                        from: $('#min_price').val(),
                    to: $('#max_price').val(),
                    drag_interval: true,
                    min_interval: null,
                    max_interval: null
                });

                $(document).on('click', ".add_to_cart_gift_thumnail", function() {
                    addToCart($(this).attr('data-gift-card-id'),$(this).attr('data-seller'),1,$(this).attr('data-base-price'),1,'gift_card');
                });
                $(document).on('change', '.filterDataChange', function(event){
                    var paginate = $('#paginate_by').val();
                    var prev_stat = $('.filterCatCol').val();
                    var sort_by = $('#product_short_list').val();
                    $('#pre-loader').show();
                    if (prev_stat == 0) {
                        var url = "{{route('frontend.gift-card.fetch-data')}}";
                    }else {
                        var url = "{{route('frontend.gift-card.filter_page_by_type')}}";
                    }
                    $.get(url, {sort_by:sort_by, paginate:paginate}, function(data){
                        $('#dataWithPaginate').html(data);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();
                        $('.filterCatCol').val(prev_stat);
                    });
                });

                $(document).on('click', '.page-item a', function(event){
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];

                var filterStatus = $('.filterCatCol').val();
                if (filterStatus == 0) {
                    fetch_data(page);
                }
                else {
                    fetch_filter_data(page);
                }

                });

                function getProductByChoice(type, el){

                    var objNew = {filterTypeId:type, filterTypeValue:[el]};

                    var objExistIndex = filterType.findIndex((objData) => objData.filterTypeId === type );
                    if (objExistIndex < 0) {
                        filterType.push(objNew);
                    }else {
                        var objExist = filterType[objExistIndex];
                        if (objExist && objExist.filterTypeId == "price_range") {
                            objExist.filterTypeValue.pop(el);
                        }
                        if (objExist && objExist.filterTypeId == "rating") {
                            objExist.filterTypeValue.pop(el);
                        }
                        if (objExist.filterTypeValue.includes(el)) {
                            objExist.filterTypeValue.pop(el);
                        }else {
                            objExist.filterTypeValue.push(el);
                        }
                    }

                    $('#pre-loader').show();
                    $.post('{{ route("frontend.gift-card.filter_by_type") }}', {_token:'{{ csrf_token() }}', filterType:filterType}, function(data){
                        $('#dataWithPaginate').html(data);
                        $('.filterCatCol').val(1);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();

                    });

                }

                function fetch_data(page){
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.gift-card.fetch-data')}}"+'?sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url ="{{route('frontend.gift-card.fetch-data')}}"+'?paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.gift-card.fetch-data')}}" + '?page=' + page;
                    }
                    if(page != 'undefined'){
                        $.ajax({
                            url: url,
                            success:function(data)
                            {
                                $('#dataWithPaginate').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning('this is undefined')
                    }

                }
                function fetch_filter_data(page){
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.gift-card.filter_page_by_type')}}"+'?sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url = "{{route('frontend.gift-card.filter_page_by_type')}}"+'?paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.gift-card.filter_page_by_type')}}"+'?page='+page;
                    }
                    if(page != 'undefined'){
                        $.ajax({
                            url:url,
                            success:function(data)
                            {
                                $('#dataWithPaginate').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('.filterCatCol').val(1);
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning("{{__('defaultTheme.this_is_undefined')}}","{{__('common.warning')}}");
                    }

                }

                $(document).on('click', '.add_to_wishlist', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    let type = 'gift_card';
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }

                });

            });
        })(jQuery);
    </script>
@endpush
