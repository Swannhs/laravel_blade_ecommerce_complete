<div class="category_product_page">
  <div class="row">
      @foreach($allCategoryProducts as $key => $product)

      <div class="col-lg-4 col-xl-3 col-sm-6 col-md-6 single_product_item">
          <div class="single_product_list product_tricker">
            <div class="product_img">
              <a target="_blank" href="{{route('frontend.item.show',$product->slug)}}" class="product_img_iner">
                <img src="{{asset(asset_path(@$product->product->thumbnail_image_source))}}" alt="#" class="img-fluid">
              </a>
              <div class="socal_icon">
                <a href="" class="add_to_wishlist {{$product->is_wishlist() == 1?'is_wishlist':''}}" id="category_all_product_wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="ti-heart"></i> </a>
                <a href="" class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }} data-product-id={{ @$product->id }}> <i class="ti-exchange-vertical"></i> </a>
                <a class="addToCartFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ @$product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                  @if(@$product->hasDeal)
                  data-base-price={{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                  @else
                    @if($product->hasDiscount == 'yes')
                      data-base-price={{ selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount) }}
                    @else
                      data-base-price={{ $product->skus->first()->selling_price }}
                    @endif
                  @endif
                  data-shipping-method={{ @$product->product->shippingMethods->first()->shipping_method_id }}
                  data-product-id={{ $product->id }}
                  data-stock_manage="{{$product->stock_manage}}"
                  data-stock="{{@$product->skus->first()->product_stock}}"
                  data-min_qty="{{$product->product->minimum_order_qty}}"
                  > <i class="ti-bag"></i> </a>
              </div>
            </div>
            <div class="product_text">
              <h5>
                <a target="_blank" href="{{route('frontend.item.show',$product->slug)}}">@if(@$product->product_name) {{substr(@$product->product_name,0,28)}} @if(strlen(@$product->product_name) > 28)... @endif @else {{substr(@$product->product->product_name,0,28)}} @if(strlen(@$product->product->product_name) > 28)... @endif @endif</a>
              </h5>
              <div class="product_review_star d-flex justify-content-between align-items-center">
                <p>
                  @if(@$product->hasDeal)
                    @if (@$product->product->product_type == 1)
                      {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount))}}
                    @else
                        @if (selling_price(@$product->skus->min('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount) === selling_price(@$product->skus->max('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))
                            {{single_price(selling_price(@$product->skus->min('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))}}
                        @else
                            {{single_price(selling_price(@$product->skus->min('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))}} - {{single_price(selling_price(@$product->skus->max('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))}}
                        @endif
                    @endif
                  @else
                    @if (@$product->product->product_type == 1)
                      @if($product->hasDiscount == 'yes')
                        {{single_price(selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                      @else
                        {{single_price(@$product->skus->first()->selling_price)}}
                      @endif
                    @else
                      @if($product->hasDiscount == 'yes')
                        @if (selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount) === selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))
                            {{single_price(selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount))}}


                        @else
                            {{single_price(selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount))}} - {{single_price(selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))}}
                        @endif
                      @else
                        @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                            {{single_price(@$product->skus->min('selling_price'))}}

                        @else
                            {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                        @endif
                      @endif
                    @endif
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
              <div class="product_review_count d-flex justify-content-between align-items-center">

                <span>


                  @if(@$product->hasDeal)
                    @if(@$product->hasDeal->discount > 0)
                      @if (@$product->product->product_type == 1)
                        {{single_price(@$product->skus->first()->selling_price)}}
                      @else
                        @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                          {{single_price(@$product->skus->min('selling_price'))}}
                        @else
                          {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                        @endif
                      @endif
                    @endif
                  @else
                    @if($product->hasDiscount == 'yes')
                      @if (@$product->product->product_type == 1)
                        {{single_price(@$product->skus->first()->selling_price)}}
                      @else
                        @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                          {{single_price(@$product->skus->min('selling_price'))}}
                        @else
                          {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                        @endif
                      @endif
                    @endif
                  @endif

                </span>

                <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} {{__('defaultTheme.review')}})</p>
              </div>

              @if($product->hasDeal)
                @if($product->hasDeal->discount > 0)
                  <span class="price_off">

                    @if(@$product->hasDeal->discount_type == 0)
                      {{@$product->hasDeal->discount}} % {{__('common.off')}}
                    @else
                    {{single_price(@$product->hasDeal->discount)}} {{__('common.off')}}
                    @endif


                  </span>
                @endif
              @else
                @if(@$product->hasDiscount == 'yes')
                  @if(@$product->discount > 0)

                    <span class="price_off">

                      @if(@$product->discount_type == 0)
                        {{@$product->discount}} % {{__('common.off')}}
                      @else
                      {{single_price(@$product->discount)}} {{__('common.off')}}
                      @endif


                    </span>
                  @endif
                @endif
              @endif


            </div>

          </div>
      </div>
      @endforeach
  </div>

  @php
      $products = $allCategoryProducts;
      $total_number_of_item_per_page = $products->perPage();
      $total_number_of_items = ($products->total() > 0) ? $products->total() : 1;
      $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
      $reminder = $total_number_of_items % $total_number_of_item_per_page;
      if ($reminder > 0) {
          $total_number_of_pages += 1;
      }

  @endphp

  <div class="col-lg-12">

      <div class="pagination_part">
        <div class="mt-10"></div>
          <nav aria-label="Page navigation example">
              <ul class="pagination">
                  <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                  @for ($i=1; $i <= $total_number_of_pages; $i++)
                      @if (($products->currentPage() + 2) == $i)
                          <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() + 1) == $i)
                          <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if ($products->currentPage() == $i)
                          <li class="page-item allcategory_page_item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() - 1) == $i)
                          <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() - 2) == $i)
                          <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                  @endfor
                  <li class="page-item allcategory_page_item"><a class="page-link" href="{{ $products->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
              </ul>
          </nav>
          <br>
      </div>
  </div>
</div>
