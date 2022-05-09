<div class="col-12">
    @if(count($products) > 0)
    <div class="reset_compare_btn text-right mb-3 ">
        <a href="#" class="reset_compare">{{ __('defaultTheme.reset_compare') }}</a>
    </div>
    @endif
</div>
<div class="col-xl-12">
    @if(count($products) > 0)
        <div class="comparing_box_area">
            <div class="compare_product_descList">
                <div class="mb-0 single_product_list product_tricker compare_product">

                    <ul class="comparison_lists">
                        <li>
                            {{__('common.name')}}
                        </li>
                        @if(isModuleActive('MultiVendor'))
                        <li>
                            {{__('common.seller')}}
                        </li>
                        @endif

                        @php


                            $data = $products[0];
                            $total_key = 2;
                            $attribute_list = [];
                        @endphp

                        @if(@$data->product->product->product_type == 2)

                            @foreach(@$data->product_variations as $key => $combination)
                            @php
                                $total_key += 1;
                                $attribute_list[] = @$combination->attribute->name;
                            @endphp

                                <li>{{@$combination->attribute->name}}</li>

                            @endforeach

                        @endif
                    </ul>
                </div>
            </div>
            <div class="compare_product_carousel">
            <div class="compare_product_active owl-carousel">

                @foreach($products as $key => $sellerProductSKU)
                <!-- single_product   -->
                <div class="mb-0 single_product_list product_tricker compare_product">
                    <div class="compare_product_inner">
                        <div class="product_img">
                            <a href="{{route('frontend.item.show',@$sellerProductSKU->product->slug)}}" class="product_img_iner">
                                <img
                                    src="
                                    @if(@$sellerProductSKU->product->product->product_type == 1)
                                        {{showImage(@$sellerProductSKU->product->product->thumbnail_image_source)}}
                                    @else
                                        {{showImage(@$sellerProductSKU->sku->variant_image?@$sellerProductSKU->sku->variant_image:@$sellerProductSKU->product->product->thumbnail_image_source)}}
                                    @endif
                                    " alt="#" class="img-fluid"
                                />
                            </a>
                            <div class="socal_icon">

                            <a href="" class="add_to_wishlist {{$sellerProductSKU->product->is_wishlist() == 1?'is_wishlist':''}}" data-product_id="{{$sellerProductSKU->product->id}}" data-seller_id="{{$sellerProductSKU->product->user_id}}"> <i class="ti-heart"></i> </a>
                            <a href="" class="remove_from_compare" data-id="{{$sellerProductSKU->id}}"> <i class="ti-trash"></i> </a>
                            </div>
                        </div>
                        <div class="product_text">
                            <h5>
                            <a href="{{route('frontend.item.show',$sellerProductSKU->product->slug)}}">@if(@$sellerProductSKU->product->product_name) {{substr(@$sellerProductSKU->product->product_name,0,35)}} @if(strlen(@$sellerProductSKU->product->product_name) > 35)... @endif @else {{substr(@$sellerProductSKU->product->product->product_name,0,28)}} @if(strlen(@$sellerProductSKU->product->product->product_name) > 28)... @endif @endif</a>
                            </h5>
                            <div
                            class="product_review_star d-flex justify-content-between align-items-center"
                            >
                            <p>
                            @if(@$sellerProductSKU->product->hasDeal)
                                {{single_price(selling_price(@$sellerProductSKU->selling_price,@$sellerProductSKU->product->hasDeal->discount_type,@$sellerProductSKU->product->hasDeal->discount))}}

                            @else
                                @if(@$sellerProductSKU->product->hasDiscount == 'yes')
                                    {{single_price(selling_price(@$sellerProductSKU->selling_price,@$sellerProductSKU->product->discount_type,@$sellerProductSKU->product->discount))}}
                                @else
                                    {{single_price(@$sellerProductSKU->selling_price)}}
                                @endif
                            @endif

                            </p>
                            <div class="review_star_icon">
                                @php
                                $reviews = @$sellerProductSKU->product->reviews->where('status',1)->pluck('rating');

                                if(count($reviews)>0){
                                    $value = 0;
                                    $rating = 0;
                                    foreach($reviews as $review){
                                        $value += $review;
                                    }
                                    $rating = $value/count($reviews);
                                    $total_review = count($reviews);
                                }else{
                                    $rating = 0;
                                    $total_review = 0;
                                }
                            @endphp
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
                            </div>

                            <div class="product_review_count d-flex justify-content-between align-items-center">
                                <span>

                                  @if($sellerProductSKU->product->hasDeal)
                                    @if($sellerProductSKU->product->hasDeal->discount > 0)
                                      {{single_price($sellerProductSKU->selling_price)}}
                                    @endif
                                  @else
                                    @if($sellerProductSKU->product->hasDiscount == 'yes')

                                      {{single_price($sellerProductSKU->selling_price)}}

                                    @endif
                                  @endif

                                </span>

                                <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} Review)</p>
                            </div>

                            @php
                                $price = 0;
                                $shipping_method = $sellerProductSKU->product->product->shippingMethods[0]->shipping_method_id;

                                if(@$sellerProductSKU->product->hasDeal){
                                    $price = selling_price(@$sellerProductSKU->selling_price,@$sellerProductSKU->product->hasDeal->discount_type,@$sellerProductSKU->product->hasDeal->discount);
                                }
                                else{
                                    if($sellerProductSKU->product->hasDiscount == 'yes'){
                                        $price = selling_price(@$sellerProductSKU->selling_price,@$sellerProductSKU->product->discount_type,@$sellerProductSKU->product->discount);
                                    }else{
                                        $price = @$sellerProductSKU->selling_price;
                                    }
                                }

                            @endphp
                            <a href="" class="btn_1 addToCart" data-product_sku_id="{{$sellerProductSKU->id}}" data-seller_id="{{@$sellerProductSKU->product->user_id}}" data-shipping_method="{{$shipping_method}}" data-price="{{$price}}">Add to Cart</a>
                        </div>
                    </div>
                    <ul class="comparison_lists">
                        <li>
                            {{$sellerProductSKU->product->product_name}}
                        </li>
                        @if(isModuleActive('MultiVendor'))
                            <li>
                                @if($sellerProductSKU->product->seller->role->type == 'seller')
                                    @if (@$sellerProductSKU->product->seller->SellerAccount->seller_shop_display_name)
                                        {{ @$sellerProductSKU->product->seller->SellerAccount->seller_shop_display_name }}
                                    @else
                                        {{$sellerProductSKU->product->seller->first_name .' '.$sellerProductSKU->product->seller->last_name}}
                                    @endif
                                @else
                                    {{ app('general_setting')->company_name }}
                                @endif
                            </li>
                        @endif
                        @php
                            $key_count = 2;
                        @endphp
                        @if(@$sellerProductSKU->product->product->product_type == 2)

                            @foreach(@$sellerProductSKU->product_variations as $key => $combination)
                                @php
                                    $key_count += 1;
                                @endphp
                                @if($attribute_list[$key] == @$combination->attribute->name)
                                    @if(@$combination->attribute->name == 'Color')
                                        <li>{{@$combination->attribute_value->color->name}}</li>
                                    @else
                                        <li>{{@$combination->attribute_value->value}}</li>
                                    @endif
                                @else
                                    <li>-</li>
                                @endif

                            @endforeach

                        @endif

                        @if($total_key > $key_count)
                            @for($key_count; $key_count < $total_key; $key_count++)
                                <li>-</li>
                            @endfor
                        @endif


                    </ul>
                </div>
                @endforeach

            </div>
            </div>

        </div>

    @else
        <h4 class="test-center compare_empty">{{ __('defaultTheme.compare_list_is_empty') }}</h4>
    @endif
    </div>
