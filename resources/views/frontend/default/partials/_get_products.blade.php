
@foreach($products as $key => $product)
    <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 single_product_item">
        <div class="single_product_list product_tricker">
            <div class="product_img">
                <a href="{{route('frontend.item.show',$product->slug)}}" class="product_img_iner">
                    <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage(@$product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product_name}}" class="img-fluid" />
                </a>
                <div class="socal_icon">
                    <a href="" class="add_to_wishlist {{$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="ti-heart"></i> </a>
                    <a href="" class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }} data-product-id={{ $product->id }}> <i class="ti-exchange-vertical"></i> </a>
                    <a class="addToCartFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                        @if(@$product->hasDeal)
                        data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                        @else
                          @if($product->hasDiscount == 'yes')
                          data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) }}
                          @else
                          data-base-price={{ @$product->skus->first()->selling_price }}
                          @endif

                        @endif
                        data-shipping-method={{ @$product->product->shippingMethods[0]->shipping_method_id }}
                        data-product-id={{ $product->id }}
                        data-stock_manage="{{$product->stock_manage}}"
                        data-stock="{{@$product->skus->first()->product_stock}}"
                        data-min_qty="{{$product->product->minimum_order_qty}}"> <i class="ti-bag"></i> </a>
                </div>
            </div>
        <div class="product_text">
        <h5>
        <a href="{{route('frontend.item.show',$product->slug)}}">@if ($product->product_name) {{ substr($product->product_name,0,22) }} @if(strlen($product->product_name) > 22)... @endif @else {{substr(@$product->product->product_name,0,22)}} @if(strlen(@$product->product->product_name) > 22)... @endif @endif</a>
        </h5>
            <div class="product_review_star d-flex justify-content-between align-items-center flex-wrap">
            <p>
                @if($product->hasDeal)
                    {{single_price(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                @else
                    {{single_price(selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                @endif
            </p>
                <div class="review_star_icon">
                    @php
                        $reviews = @$product->reviews->where('status',1)->pluck('rating');

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
        </div>
        @if(@$product->hasDeal)
            @if(@$product->hasDeal->discount >0)
                <span class="new_price">
                    @if(@$product->hasDeal->discount >0)
                        @if(@$product->hasDeal->discount_type ==0)
                            {{@$product->hasDeal->discount}} % off
                        @else
                            {{single_price(@$product->hasDeal->discount)}} off
                        @endif

                    @endif
                </span>
            @endif
        @else
            @if($product->discount >0)
                <span class="new_price">
                    @if($product->discount >0)
                        @if($product->discount_type ==0)
                            {{$product->discount}} % off
                        @else
                            {{single_price($product->discount)}} off
                        @endif
                    @endif
                </span>
            @endif
        @endif
        </div>
    </div>
@endforeach
