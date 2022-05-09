@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/marchant_page.css'))}}" />


@endsection
@section('content')


<!-- image breadcrumb part here -->
<section class="img_breadcrumb bg-white">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb_img_iner">
              @if ($seller->role->type == "superadmin")
              <img src="{{app('general_setting')->shop_link_banner?showImage(app('general_setting')->shop_link_banner):showImage('frontend/default/img/breadcrumb_bg.png')}}" alt="#" class="img-fluid">
              @else
              <img src="{{$seller->SellerAccount->banner?showImage($seller->SellerAccount->banner):showImage('frontend/default/img/breadcrumb_bg.png')}}" alt="#" class="img-fluid">
              @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- image breadcrumb part end -->
<input type="hidden" id="seller_id" name="seller_id" value="{{ $seller->id }}">
  <!-- member info here -->
  <section class="member_info bg-white">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-10">
                  <div class="member_info_iner d-md-flex align-items-center">
                      <div class="profile_img_div">
                        @if ($seller->role->type == "superadmin")
                        <img src="{{showImage(app('general_setting')->logo)}}" alt="#">
                        @else
                        <img src="{{$seller->photo?showImage($seller->photo):showImage('frontend/default/img/avatar.jpg')}}" alt="#">
                        @endif
                      </div>
                      <div class="member_info_text">
                          <div class="member_info_details d-sm-flex">
                               <h4>{{$seller->first_name}} {{$seller->last_name}} </h4> <span>|</span>
                               <p>{{__('defaultTheme.member_since')}} {{date('M, Y',strtotime($seller->created_at))}} </p>
                          </div>
                          <div class="member_info_details d-flex">
                               <div class="review_star_icon">
                                @if($seller_rating == 0)
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating < 1 && $seller_rating > 0)
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating <= 1 && $seller_rating > 0)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating < 2 && $seller_rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating <= 2 && $seller_rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating < 3 && $seller_rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating <= 3 && $seller_rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating < 4 && $seller_rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating <= 4 && $seller_rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($seller_rating < 5 && $seller_rating > 4)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                @endif
                               </div>
                                  <p>{{sprintf("%.2f",$seller_rating)}}/5 ({{$seller_total_review<10?'0':''}}{{$seller_total_review}} {{__('defaultTheme.review')}})</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- member info end -->

  <!-- catrgory part here -->
  <section class="category_part single_page_category">
      <div class="container">
          <div class="row">
              <div class="col-lg-3">
                  <div class="category_sidebar">
                      <div class="category_refress" id="refresh_btn">
                          <a href="">{{__('defaultTheme.refresh_filters')}}</a>
                          <i class="ti-reload"></i>
                      </div>
                      @if (count($CategoryList) > 0)
                          <div class="single_category">
                              <div class="category_tittle">
                                  <h4>{{__('defaultTheme.related_category')}}</h4>
                              </div>
                              <div class="single_category_option">
                                  <nav>
                                      <ul>
                                          @foreach($CategoryList as $key => $category)
                                          <li class='sub-menu'>
                                              <a class="getProductByChoice" data-id="cat" data-value="{{ $category->id }}">{{$category->name}}<div class='ti-plus right plus_btn_div'></div>
                                                </a>
                                              <ul>
                                                  @foreach($category->subCategories as $key => $subCategory)
                                                      <li>
                                                          <a class="getProductByChoice" data-id="cat" data-value="{{ $subCategory->id }}">{{$subCategory->name}}</a>
                                                          <label class="cs_checkbox">
                                                              <input type="checkbox" class="attr_checkbox" class="getProductByChoice" data-id="cat" data-value="{{ $subCategory->id }}">
                                                              <span class="checkmark"></span>
                                                          </label>
                                                      </li>
                                                  @endforeach

                                              </ul>
                                          </li>
                                          @endforeach

                                      </ul>
                                  </nav>
                              </div>
                          </div>
                      @endif
                      @isset ($brandList)
                          @if (count($brandList) > 0)
                              <div class="single_category">
                                  <div class="category_tittle">
                                      <h4>{{__('product.brand')}}</h4>
                                  </div>
                                  <div class="single_category_option">
                                      <nav>
                                          <ul>
                                              @foreach($brandList as $key => $brand)
                                              <li class='sub-menu'><a class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}">{{$brand->name}}<div class='ti-plus right plus_btn_div'></div></a></li>
                                              @endforeach

                                          </ul>
                                      </nav>
                                  </div>
                              </div>
                          @endif
                      @endisset
                      <div class="colorDiv">

                      </div>
                      <div class="attributeDiv">

                      </div>


                      <div class="single_category materials_content">
                        <div class="category_tittle">
                            <h4>{{ __('defaultTheme.rating') }}</h4>
                        </div>
                        <div class="single_category_option">
                            <nav>
                                <ul>

                                    <li>
                                        <a href='#Electronics'>
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
                                        <a href='#Electronics'>
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
                                        <a href='#Electronics'>
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
                                        <a href='#Electronics'>
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
                                        <a href='#Electronics'>
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
                              <h4>{{__('defaultTheme.price_range')}}</h4>
                          </div>
                          <div class="single_category_option">
                              <div class="wrapper">
                                  <div class="range-slider">
                                      <input type="text" class="js-range-slider-0" value=""/>
                                  </div>
                                  <div class="extra-controls form-inline">
                                      <div class="form-group">
                                          <div class="price_rangs">
                                              <input type="text" class="js-input-from form-control" id="min_price" value="{{ $min_price_lowest }}" readonly/>
                                              <p>{{__('common.min')}}</p>
                                          </div>
                                          <div class="price_rangs">
                                              <input type="text" class="js-input-to form-control" id="max_price" value="{{ $max_price_highest }}" readonly/>
                                              <p>{{__('common.max')}}</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div id="productShow" class="col-lg-9">
                @include('frontend.default.partials.merchant_page_paginate_data')
              </div>
          </div>
      </div>
      <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
  </section>
  <!-- catrgory part end -->


@endsection

@push('scripts')
    <script >

        (function($){
            "use strict";

            $(document).ready(function() {
                var filterType = [];
                $(document).on('click', '#refresh_btn', function(event){
                    event.preventDefault();
                    filterType = [];
                    fetch_data(1);

                    $('.attr_checkbox').prop('checked', false);
                    $('.color_checkbox').removeClass('selected_btn');
                    $('.category_checkbox').prop('checked', false);
                    $('.brandDiv').html('');
                    $('.colorDiv').html('');
                    $('.attributeDiv').html('');
                    $('.sub-menu').find('ul').css('display', 'none');
                    $('.plus_btn_div').removeClass('ti-minus');
                    $('.plus_btn_div').addClass('ti-plus');

                    $('#price_range_div').html(
                        `<div class="wrapper">
                        <div class="range-slider">
                            <input type="text" class="js-range-slider-0" value=""/>
                        </div>
                        <div class="extra-controls form-inline">
                            <div class="form-group">
                                <div class="price_rangs">
                                    <input type="text" class="js-input-from form-control" id="min_price" value="{{ $min_price_lowest }}" readonly/>
                                    <p>Min</p>
                                </div>
                                <div class="price_rangs">
                                    <input type="text" class="js-input-to form-control" id="max_price" value="{{ $max_price_highest }}" readonly/>
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
                $(document).on('click', '.attr_clr', function(event){
                    if ($(this).is(':checked')) {
                        $(this).addClass('selected_btn');
                    }else {
                        $(this).removeClass('selected_btn');
                    }
                });
                $(document).on('change', '.getFilterUpdateByIndex', function(event){
                    var paginate = $('#paginate_by').val();
                    var prev_stat = $('.filterCatCol').val();
                    var sort_by = $('#product_short_list').val();
                    var seller_id = $('#seller_id').val();
                    $('#pre-loader').show();
                    $.get('{{ route('frontend.seller.sort_product_filter_by_type') }}', {seller_id:seller_id, sort_by:sort_by, paginate:paginate}, function(data){
                        $('#productShow').html(data);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();
                        $('.filterCatCol').val(prev_stat);
                    });
                });

                $(document).on('click', '.page-item a', function(event) {
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

                function fetch_data(page) {
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.seller.fetch-data',base64_encode($seller->id))}}"+'?sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url ="{{route('frontend.seller.fetch-data',base64_encode($seller->id))}}"+'?paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.seller.fetch-data',base64_encode($seller->id))}}" + '?page=' + page;
                    }
                    if (page != 'undefined') {
                        $.ajax({
                            url: url,
                            success: function(data) {
                                $('#productShow').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('#pre-loader').hide();
                            }
                        });
                    } else {
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }

                }
                function fetch_filter_data(page){
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    var seller_id = $('#seller_id').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.seller.sort_product_filter_by_type')}}"+'?seller_id='+seller_id+'&sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url = "{{route('frontend.seller.sort_product_filter_by_type')}}"+'?seller_id='+seller_id+'&paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.seller.sort_product_filter_by_type')}}"+'?seller_id='+seller_id+'&page='+page;
                    }
                    if(page != 'undefined'){
                        $.ajax({
                            url:url,
                            success:function(data)
                            {
                                $('#productShow').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('.filterCatCol').val(1);
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }

                }

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



                function getProductByChoice(type,el)
                {
                    var objNew = {filterTypeId:type, filterTypeValue:[el]};

                    var objExistIndex = filterType.findIndex((objData) => objData.filterTypeId === type );

                    var seller_id = $('#seller_id').val();

                    if (type == "cat" || type =="brand") {
                        $.post('{{ route('frontend.seller.get_colors_by_type') }}', {_token:'{{ csrf_token() }}', id:el, type:type}, function(data){
                            $('.colorDiv').html(data);
                        });
                        $.post('{{ route('frontend.seller.get_attribute_by_type') }}', {_token:'{{ csrf_token() }}', id:el, type:type}, function(data){
                            $('.attributeDiv').html(data);
                        });
                    }
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
                    $.post('{{ route('frontend.seller.product_filter_by_type') }}', {_token:'{{ csrf_token() }}', filterType:filterType, seller_id:seller_id}, function(data){
                        $('#productShow').html(data);
                        $('.filterCatCol').val(1);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();

                    });
                }
            });
        })(jQuery);

    </script>
@endpush
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
