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

<div class="row">
    @foreach($products as $key => $product)

    <div class="col-lg-4 col-xl-3 col-sm-6 col-md-6 single_product_item">
        <div class="single_product_list product_tricker">
          <div class="product_img">
            <a href="{{route('frontend.item.show',$product->product->slug)}}" class="product_img_iner">
              <img src="{{asset(asset_path(@$product->product->product->thumbnail_image_source))}}" alt="#" class="img-fluid">
            </a>
            <div class="socal_icon">
              <a href="" class="add_to_wishlist {{$product->product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->product->id}}" data-seller_id="{{$product->product->user_id}}"> <i class="ti-heart"></i> </a>
              <a href="" class="addToCompareFromThumnail" data-producttype="{{ $product->product->product->product_type }}" data-seller={{ $product->product->user_id }} data-product-sku={{ $product->product->skus->first()->id }} data-product-id={{ $product->product->id }}> <i class="ti-exchange-vertical"></i> </a>
              <a href="" class="addToCartFromThumnail" data-producttype="{{ $product->product->product->product_type }}" data-seller={{ $product->product->user_id }} data-product-sku={{ $product->product->skus->first()->id }}

                @if(@$product->product->hasDeal)
                data-base-price={{ selling_price($product->product->skus->first()->selling_price,$product->product->hasDeal->discount_type,$product->product->hasDeal->discount) }}
                @else
                data-base-price={{ selling_price($product->product->skus->first()->selling_price,$product->product->discount_type,$product->product->discount) }}
                @endif
                data-shipping-method={{ @$product->product->product->shippingMethods->first()->shipping_method_id }}
                data-product-id={{ $product->product->id }}
                data-stock_manage="{{$product->product->stock_manage}}"
                data-stock="{{@$product->product->skus->first()->product_stock}}"
                data-min_qty="{{$product->product->product->minimum_order_qty}}"> <i class="ti-bag"></i> </a>
            </div>
          </div>
          <div class="product_text">
            <h5>
              <a href="{{route('frontend.item.show',$product->product->slug)}}">@if(@$product->product->product_name) {{substr(@$product->product->product_name,0,28)}} @if(strlen(@$product->product->product_name) > 28)... @endif @else {{substr(@$product->product->product->product_name,0,28)}} @if(strlen(@$product->product->product->product_name) > 28)... @endif @endif</a>
            </h5>
            <div class="product_review_star d-flex justify-content-between align-items-center">
              <p>
                  @if($product->product->hasDeal)

                    @if ($product->product->product->product_type == 1)
                        {{single_price(selling_price($product->product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                    @else
                        @if (selling_price($product->product->skus->min('selling_price'),$product->discount_type,$product->discount) === selling_price($product->product->skus->max('selling_price'),$product->discount_type,$product->discount))
                            {{single_price(selling_price($product->product->skus->min('selling_price'),$product->discount_type,$product->discount))}}
                        @else
                            {{single_price(selling_price($product->product->skus->min('selling_price'),$product->discount_type,$product->discount))}} - {{single_price(selling_price($product->product->skus->max('selling_price'),$product->discount_type,$product->discount))}}
                        @endif
                    @endif

                  @else
                    @if(@$product->product->product->product_type == 1)
                        @if(@$product->product->hasDiscount == 'yes')
                            {{single_price(selling_price(@$product->product->skus->first()->selling_price,@$product->product->discount_type,@$product->product->discount))}}
                        @else
                            {{single_price(@$product->product->skus->first()->selling_price)}}
                        @endif
                    @else
                        @if(@$product->product->hasDiscount == 'yes')
                            @if (selling_price($product->product->skus->min('selling_price'),$product->product->discount_type,$product->product->discount) === selling_price($product->product->skus->max('selling_price'),$product->product->discount_type,$product->product->discount))
                                {{single_price(selling_price($product->product->skus->min('selling_price'),$product->product->discount_type,$product->product->discount))}}
                            @else
                                {{single_price(selling_price($product->product->skus->min('selling_price'),$product->product->discount_type,$product->product->discount))}} - {{single_price(selling_price($product->product->skus->max('selling_price'),$product->product->discount_type,$product->product->discount))}}
                            @endif
                        @else
                            @if ($product->product->skus->min('selling_price') === $product->product->skus->max('selling_price'))
                                {{single_price($product->product->skus->min('selling_price'))}}
                            @else
                                {{single_price($product->product->skus->min('selling_price'))}} - {{single_price($product->product->skus->max('selling_price'))}}
                            @endif
                        @endif
                    @endif
                  @endif
              </p>
              <div class="review_star_icon">
                  @php
                  $reviews = $product->product->reviews->where('status',1)->pluck('rating');
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
                @if($product->product->hasDeal)
                    @if($product->discount > 0)

                        @if ($product->product->product->product_type == 1)
                            {{single_price($product->product->skus->first()->selling_price)}}
                        @else
                            @if ($product->product->skus->min('selling_price') === $product->product->skus->max('selling_price'))
                                {{single_price($product->product->skus->min('selling_price'))}}
                            @else
                                {{single_price($product->product->skus->min('selling_price'))}} - {{single_price($product->product->skus->max('selling_price'))}}
                            @endif
                        @endif
                    @endif
                @else
                    @if($product->product->hasDiscount == 'yes')
                        @if($product->product->discount > 0)

                            @if ($product->product->product->product_type == 1)
                                {{single_price($product->product->skus->first()->selling_price)}}
                            @else
                                @if ($product->product->skus->min('selling_price') === $product->product->skus->max('selling_price'))
                                    {{single_price($product->product->skus->min('selling_price'))}}
                                @else
                                    {{single_price($product->product->skus->min('selling_price'))}} - {{single_price($product->product->skus->max('selling_price'))}}
                                @endif
                            @endif
                        @endif
                    @endif

                @endif
              </span>

              <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} {{__('defaultTheme.review')}})</p>
            </div>
          </div>


          @if($product->product->hasDeal)
            @if($product->discount > 0)
            <span class="new_price">
                @if($product->discount_type ==0)
                {{$product->discount}} % {{__('common.off')}}
                @else
                {{single_price($product->discount)}} {{__('common.off')}}
                @endif

                </span>
            @endif
          @else
            @if($product->product->hasDiscount == 'yes')
                @if($product->product->discount > 0)
                    <span class="new_price">
                        @if($product->product->discount_type ==0)
                        {{$product->product->discount}} % {{__('common.off')}}
                        @else
                        {{single_price($product->product->discount)}} {{__('common.off')}}
                        @endif

                    </span>
                @endif

            @endif

          @endif

        </div>
    </div>
    @endforeach
</div>
<div class="row justify-content-center">

    <div class="col-lg-12">
        @php
            $total_number_of_item_per_page = $products->perPage();
            $total_number_of_items = ($products->total() > 0) ? $products->total() : 1;
            $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
            $reminder = $total_number_of_items % $total_number_of_item_per_page;
            if ($reminder > 0) {
                $total_number_of_pages += 1;
            }
        @endphp
        <div class="pagination_part">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                    @for ($i=1; $i <= $total_number_of_pages; $i++)
                        @if (($products->currentPage() + 2) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($products->currentPage() + 1) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if ($products->currentPage() == $i)
                            <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($products->currentPage() - 1) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($products->currentPage() - 2) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
