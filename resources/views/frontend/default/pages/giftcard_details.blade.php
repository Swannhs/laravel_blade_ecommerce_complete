@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/giftcard_details.css'))}}" />


@endsection

@section('content')

<!-- product details here -->
<section class="product_details_part section_padding">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-xl-6">
                <div class="product_details_img">
                    <div class="tab-content tab_content" id="myTabContent">
                        @foreach($card->galaryImages as $image)

                        <div class="tab-pane fade {{$card->galaryImages->first()->id == $image->id?'show active':''}}" id="thumb_{{$image->id}}" role="tabpanel">
                            <div class="img_div">
                                    <img src="{{showImage($image->image_name)}}" alt="#" class="img-fluid var_img_show" />
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <ul class="nav tab_thumb justify-content-between" id="myTab" role="tablist">
                        @foreach($card->galaryImages as $image)
                        <li class="nav-item">
                            <a class="nav-link" id="thumb_{{$image->id}}_tab" data-toggle="tab" href="#thumb_{{$image->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">

                                    <img src="{{showImage($image->image_name)}}" alt="#" class="img-fluid"/>

                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="product_details">
                    <a href="{{url('/gift-cards')}}" class="product_details_btn_iner">{{ __('common.gift_cards') }}</a>
                    <div class="tittle">
                        <h2>{{$card->name}}</h2>
                    </div>
                    <div class="product_details_review d-flex">
                        <div class="review_star_icon">
                            @if($rating == 0)
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating < 1 && $rating > 0)
                            <i class="fas fa-star-half-alt"></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating <= 1 && $rating > 0)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating < 2 && $rating > 1)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating <= 2 && $rating > 1)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating < 3 && $rating > 2)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating <= 3 && $rating > 2)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star non_rated "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating < 4 && $rating > 3)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating <= 4 && $rating > 3)
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star non_rated "></i>
                            @elseif($rating < 5 && $rating > 4)
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
                        <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} {{__('defaultTheme.review')}})</p>
                    </div>
                    <div class="details_product_price d-flex">

                        @if($card->hasDiscount())
                            <h2>{{single_price(selling_price($card->selling_price, $card->discount_type, $card->discount))}}</h2>

                        @else
                            <h2>{{single_price($card->selling_price)}}</h2>
                        @endif
                        <span>
                            @if($card->hasDiscount())
                                @if($card->discount > 0)
                                {{single_price($card->selling_price)}}
                                @endif
                            @endif
                        </span>
                    </div>
                    <div class="single_details_content d-flex mb-2">
                        <h5 class="mb-0">{{ __('common.sold_by') }}</h5>
                        <a href="{{url('/gift-cards')}}" class="product_details_btn_iner">{{app('general_setting')->company_name}}</a>
                    </div>
                    <div class="product_details_content">
                        <ul>
                            <li>
                                {{ __('product.sku') }}
                                <span>{{$card->sku}}</span></li>
                        </ul>
                    </div>

                    <div class="single_details_content d-md-flex">
                        <div class="details_text d-flex">
                            <h5 class="mb-0">{{__('common.quantity')}}:</h5>
                            <div class="product_count">
                                <input type="text" name="qty" class="qty" id="qty" readonly value="1"/>
                                <div class="button-container">
                                    <button class="cart-qty-plus qtyChange" type="button" value="+">
                                        <i class="ti-plus"></i>
                                    </button>
                                    <button class="cart-qty-minus qtyChange" type="button" value="-">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="single_details_content mt_30 d-md-flex">
                        <h5>{{ __('defaultTheme.shipping') }}</h5>
                        <div class="details_content_iner">
                            <select name="#" class="select_address" disabled>
                                <option value="">
                                    {{ $shipping_method_id->method_name }}
                                </option>

                            </select>
                        </div>
                    </div>
                    <div class="single_details_content d-flex">
                        <h5 class="mb-0">{{ __('common.total') }}</h5>

                        @if($card->hasDiscount())
                            <h2 id="total_price">{{single_price(selling_price($card->selling_price, $card->discount_type, $card->discount))}}</h2>

                        @else
                            <h2 id="total_price">{{single_price($card->selling_price)}}</h2>
                        @endif

                        <input type="hidden" name="unit_price" id="unit_price" value="@if($card->hasDiscount()) {{selling_price($card->selling_price, $card->discount_type, $card->discount)}} @else {{$card->selling_price}} @endif">

                    </div>
                    <div class="product_details_btn">
                        <button type="button" class="btn_1 add_gift_card_to_cart" data-gift-card-id="{{ $card->id }}" data-seller="{{ App\Models\User::where('role_id', 1)->first()->id }}" data-base-price="@if($card->hasDiscount()) {{selling_price($card->selling_price, $card->discount_type, $card->discount)}} @else {{$card->selling_price}} @endif" data-shipping-method="{{ $shipping_method_id->id }}">Add to Cart</button>
                        <a href="" class="btn_2 add_to_wishlist" data-product_id="{{$card->id}}" data-seller_id="{{App\Models\User::where('role_id', 1)->first()->id }}">Add to wishlist</a>
                    </div>
                    <div class="single_details_content social_icon d-flex">
                        <h5 class="mb-0">{{__('defaultTheme.share_on')}}:</h5>
                        <div class="social_icon_iner">
                            <a href="{{ Share::currentPage()->facebook()->getRawLinks() }}"><i class="ti-facebook"></i></a>
                            <a href="{{ Share::currentPage()->twitter()->getRawLinks() }}"><i class="ti-twitter-alt"></i></a>
                            <a href="{{ Share::currentPage()->linkedin()->getRawLinks() }}"><i class="ti-linkedin"></i></a>
                            <a href="{{ Share::currentPage()->whatsapp()->getRawLinks() }}"><i class="fab fa-whatsapp"></i></a>
                            <a href="{{ Share::currentPage()->telegram()->getRawLinks() }}"><i class="fab fa-telegram-plane"></i></a>
                            <a href="{{ Share::currentPage()->reddit()->getRawLinks() }}"><i class="ti-reddit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product details end -->

<!-- product description here-->
<section class="product_description padding_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="product_description_info">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">
                                {{ __('common.description') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">
                                {{ __('defaultTheme.reviews') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">

                            <div class="item_description">
                                @php echo $card->description; @endphp
                            </div>

                        </div>

                        <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                            <div class="item_description">
                                @include(theme('partials._giftcard_review_with_paginate'),['reviews' => @$card->activeReviews])
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product_details_weiget">
                <h3>{{ __('defaultTheme.from_the_same_store') }}</h3>
                    <div class="single_product_details_weiget">
                        @foreach($cards as $key => $item)
                        <div class="single_product_weiget media_style">
                            <div class="single_product_img">
                                <img src="{{showImage($item->thumbnail_image)}}" alt="#" />
                                <a href="" class="add_gift_card_to_cart" data-gift-card-id="{{ $item->id }}" data-seller="{{ App\Models\User::where('role_id', 1)->first()->id }}" data-base-price="@if($item->hasDiscount()) {{selling_price($item->selling_price, $item->discount_type, $item->discount)}} @else {{$item->selling_price}} @endif" data-shipping-method="{{ $shipping_method_id->id }}"><i class="ti-bag"></i></a>
                            </div>
                            <div class="single_product_text">
                                <a href="product_details.php">{{$item->name}}</a>
                                <div class="category_product_price">
                                    <h4>
                                        @if($item->hasDiscount())
                                        {{single_price(selling_price($item->selling_price, $item->discount_type, $item->discount))}}

                                        @else
                                        {{single_price($item->selling_price)}}
                                        @endif

                                    </h4>
                                    <span>
                                        @if($item->hasDiscount())
                                            @if($item->discount > 0)
                                            {{single_price($item->selling_price)}}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
    <input type="hidden" id="currency_symbol" value="@if(session()->get('currency')) {{session()->get('currency')}} @else {{app('general_setting')->currency_symbol}} @endif">
    <input type="hidden" id="currency_rate" value="@if(session()->get('currency')) {{session()->get('convert_rate')}} @else 1 @endif">
</section>
<!-- product description end-->



@endsection

@push('scripts')
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){

                var productType = $('.product_type').val();
                if (productType == 2) {
                    '@if (session()->has('item_details'))'+
                        '@foreach (session()->get('item_details') as $key => $item)'+
                            '@if ($item['name'] === "Color")'+
                                '@foreach ($item['value'] as $k => $value_name)'+
                                    $(".colors_{{$k}}").css("background-color", "{{ $item['code'][$k]}}");
                                '@endforeach'+
                            '@endif'+
                        '@endforeach'+
                    '@endif'
                }


                $(document).on('click', ".add_gift_card_to_cart", function(event) {
                    event.preventDefault();
                    addToCart($(this).attr('data-gift-card-id'),$(this).attr('data-seller'),$('#qty').val(),$(this).attr('data-base-price'),$(this).attr('data-shipping-method'),'gift_card')
                });

                $(document).on('click', '.qtyChange' , function(){
                    qtyChange($(this).val());
                });

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

                $(document).on('change', '#qty', function(){
                    totalValue($(this).val(),'#main_price','#total_price');
                });

                $(document).on('click', '.page-item a', function(event){
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];

                    fetch_data(page);

                });

                function fetch_data(page){
                    $('#pre-loader').show();

                    var url = "{{route('frontend.giftcard.reviews.get-data')}}" + '?giftcard_id='+ "{{$card->id}}" +'&page=' + page;

                    if(page != 'undefined'){
                        $.ajax({
                            url: url,
                            success:function(data)
                            {
                                $('#Reviews').html(data);
                                $('#pre-loader').hide();
                            }
                        });
                    }else{

                        toastr.warning("{{__('defaultTheme.this_is_undefined')}}","{{__('common.warning')}}");
                    }

                }

                function calculatePrice(main_price, discount, discount_type)
                {
                    var main_price = main_price;
                    var discount = discount;
                    var discount_type = discount_type;
                    var total_price = 0;
                    if (discount_type == 0) {
                        discount = (main_price * discount) / 100;
                    }
                    total_price = (main_price - discount);
                    let currency_symbol = $('#currency_symbol').val();
                    let currency_rate = $('#currency_rate').val();

                    $('#total_price').html(currency_symbol + formatMoney((total_price * qty) * currency_rate));
                    $('#base_sku_price').val(total_price);
                    $('#final_price').val(total_price);
                }
                function qtyChange(val){
                    $('.cart-qty-minus').prop('disabled',false);

                    let qty = $('#qty').val();
                    if(val == '+'){
                        let qty1 = parseInt(++qty);
                        $('#qty').val(qty1)
                        totalValue(qty1);
                    }
                    if(val == '-'){
                        if(qty>1){
                            let qty1 = parseInt(--qty)
                            $('#qty').val(qty1)
                            totalValue(qty1)
                            $('.cart-qty-minus').prop('disabled',false);
                        }else{
                            $('.cart-qty-minus').prop('disabled',true);
                        }
                    }

                }
                function totalValue(qty){


                    let unit_price = $('#unit_price').val();
                    let value = parseInt(qty) * parseFloat(unit_price);

                    let currency_symbol = $('#currency_symbol').val();
                    let currency_rate = $('#currency_rate').val();

                    $('#total_price').html(currency_symbol + formatMoney(value * currency_rate));
                    $('#final_price').val(value);

                }

                function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                    try {
                        decimalCount = Math.abs(decimalCount);
                        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                        const negativeSign = amount < 0 ? "-" : "";

                        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                        let j = (i.length > 3) ? i.length % 3 : 0;

                        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                    } catch (e) {
                        console.log(e)
                    }
                };

            });
        })(jQuery);


    </script>
@endpush
