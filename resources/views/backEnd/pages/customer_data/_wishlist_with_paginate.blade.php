
@php
    $total_number_of_item_per_page = $products->perPage();
    $total_number_of_items = ($products->total() > 0) ? $products->total() : 0;
    $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
    $reminder = $total_number_of_items % $total_number_of_item_per_page;
    if ($reminder > 0) {
        $total_number_of_pages += 1;
    }

    $current_page = $products->currentPage();
    $previous_page = $products->currentPage() - 1;
    if($current_page == $products->lastPage()){
    $show_end = $total_number_of_items;
    }else{
    $show_end = $total_number_of_item_per_page * $current_page;
    }


    $show_start = 0;
    if($total_number_of_items > 0){
      $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
    }
@endphp

<div class="category_product_page">
    <div class="product_page_tittle">
        <div class="row">
          <div class="col-lg-4 mb-10 mt-15">
            <p class="text-lowercase">{{__('defaultTheme.showing')}} @if($show_start == $show_end) {{$show_end}} @else {{$show_start}} - {{$show_end}} @endif {{__('defaultTheme.out_of_total')}} {{$total_number_of_items}} {{__('common.products')}}</p>
          </div>
        <div class="col-lg-4 mb-10">
          <div class="short_by">
            <select name="paginate_by" class="primary_select paginate_no" id="paginate_by">
                <option value="12" @if (isset($paginate) && $paginate == "12") selected @endif>12</option>
                <option value="16" @if (isset($paginate) && $paginate == "16") selected @endif>16</option>
                <option value="30" @if (isset($paginate) && $paginate == "30") selected @endif>30</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="short_by">
            <select name="sort_by" onchange="getFilterUpdateByIndex()" class="primary_select sort_by" id="product_short_list">
                <option value="new" @if (isset($sort_by) && $sort_by == "new") selected @endif>{{__('common.new')}}</option>
                <option value="old" @if (isset($sort_by) && $sort_by == "old") selected @endif>{{__('common.old')}}</option>
                <option value="low_to_high" @if (isset($sort_by) && $sort_by == "low_to_high") selected @endif>{{__('common.price')}} ({{__('defaultTheme.low_to_high')}})</option>
                <option value="high_to_low" @if (isset($sort_by) && $sort_by == "high_to_low") selected @endif>{{__('common.price')}} ({{__('defaultTheme.high_to_low')}})</option>
            </select>
          </div>
        </div>
        </div>
    </div>
    <input type="hidden" name="filterCatCol" class="filterCatCol" value="0">
    @if(count($products) > 0)
      <div class="row mt-20">
        @foreach($products as $product)
            @if($product->type =='product')
              <div class="col-xl-3 col-lg-6 col-lg-3 col-sm-6 col-md-6 single_product_item">
            <div class="single_product_list product_tricker">
              <div class="product_img">
                <a href="{{route('frontend.item.show',$product->product->slug)}}" target="_blank" class="product_img_iner">
                  <img @if (@$product->product->thum_img != null) src="{{showImage(@$product->product->thum_img)}}" @else src="{{showImage(@$product->product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product->product_name}}" class="img-fluid" />
                </a>
                <div class="socal_icon">
                  <a href="" class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product->product_type }}" data-seller={{ @$product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }} data-product-id={{ @$product->product->id }}> <i class="ti-exchange-vertical"></i> </a>
                  <a href="" class="addToCartFromThumnail" data-producttype="{{ @$product->product->product->product_type }}" data-seller={{ @$product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }}
                    @if(@$product->product->hasDeal)
                        data-base-price={{ selling_price(@$product->product->skus->first()->selling_price,@$product->product->hasDeal->discount_type,$product->product->hasDeal->discount) }}
                    @else
                      @if(@$product->product->hasDiscount == 'yes')
                        data-base-price={{ selling_price(@$product->product->skus->first()->selling_price,@$product->product->discount_type,@$product->product->discount) }}
                      @else
                        data-base-price={{ @$product->product->skus->first()->selling_price }}
                      @endif
                    @endif
                    data-shipping-method={{ @$product->product->product->shippingMethods->first()->shipping_method_id }}
                    data-product-id={{ @$product->product->id }}
                    data-stock_manage="{{$product->product->stock_manage}}"
                    data-stock="{{@$product->product->skus->first()->product_stock}}"
                    data-min_qty="{{$product->product->product->minimum_order_qty}}"
                    > <i class="ti-bag"></i> </a>
                  <a href="" class="removeFromWhishlist" data-product-id='{{ $product->id }}'> <i class="ti-trash"></i> </a>
                </div>
              </div>
              <div class="product_text">
                <h5>
                  <a href="{{route('frontend.item.show',@$product->product->slug)}}" target="_blank">@if (@$product->product->product_name) {{substr(@$product->product->product_name,0,35)}} @if(strlen(@$product->product->product_name) > 35)... @endif @else {{substr(@$product->product->product->product_name,0,35)}} @if(strlen(@$product->product->product->product_name) > 35)... @endif @endif</a>
                </h5>
                <div class="product_review_star d-flex justify-content-between align-items-center flex-wrap">
                  <p class="text-nowrap">
                    @if(@$product->product->hasDeal)
                      @if (@$product->product->product->product_type == 1)
                        {{single_price(selling_price(@$product->product->skus->first()->selling_price,@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount))}}
                      @else
                          @if (selling_price(@$product->product->skus->min('selling_price'),@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount) === selling_price(@$product->product->skus->max('selling_price'),@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount))
                              {{single_price(selling_price(@$product->product->skus->min('selling_price'),@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount))}}
                          @else
                              {{single_price(selling_price(@$product->product->skus->min('selling_price'),@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount))}} - {{single_price(selling_price(@$product->product->skus->max('selling_price'),@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount))}}
                          @endif
                      @endif
                    @else
                      @if (@$product->product->product->product_type == 1)
                        @if(@$product->product->hasDiscount == 'yes')
                          {{single_price(selling_price(@$product->product->skus->first()->selling_price,@$product->product->discount_type,@$product->product->discount))}}
                        @else
                          {{single_price(@$product->product->skus->first()->selling_price)}}
                        @endif
                      @else
                        @if(@$product->product->hasDiscount == 'yes')
                          @if (selling_price(@$product->product->skus->min('selling_price'),@$product->product->discount_type,@$product->product->product->discount) === selling_price(@$product->product->product->skus->max('selling_price'),@$product->product->product->discount_type,@$product->product->product->discount))
                              {{single_price(selling_price($product->product->skus->min('selling_price'),$product->product->discount_type,$product->product->discount))}}
                          @else
                              {{single_price(selling_price(@$product->product->skus->min('selling_price'),@$product->product->discount_type,$product->product->discount))}} - {{single_price(selling_price(@$product->product->skus->max('selling_price'),@$product->product->discount_type,@$product->product->discount))}}
                          @endif
                        @else
                          @if (@$product->product->skus->min('selling_price') === @$product->product->skus->max('selling_price'))
                              {{single_price(@$product->product->skus->min('selling_price'))}}
                          @else
                              {{single_price(@$product->product->skus->min('selling_price'))}} - {{single_price(@$product->product->skus->max('selling_price'))}}
                          @endif
                        @endif
                      @endif
                    @endif
                  </p>

                  <div class="review_star_icon text-nowrap">
                    @php
                        $reviews = @$product->product->reviews->where('status',1)->pluck('rating');
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
                <div class="product_review_count d-flex justify-content-between align-items-center flex-wrap">

                  <span class="text-nowrap">

                    @if($product->product->hasDeal)
                      @if($product->product->hasDeal->discount > 0)
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

                      @if(@$product->product->hasDiscount == 'yes')
                        @if (@$product->product->product->product_type == 1)
                        {{single_price(@$product->product->skus->first()->selling_price)}}
                        @else
                          @if (@$product->product->skus->min('selling_price') === @$product->product->skus->max('selling_price'))
                            {{single_price(@$product->product->skus->min('selling_price'))}}
                          @else
                            {{single_price(@$product->product->skus->min('selling_price'))}} - {{single_price(@$product->product->skus->max('selling_price'))}}
                          @endif
                        @endif
                      @endif

                    @endif

                  </span>

                  <p class="text-nowrap">{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} {{__('defaultTheme.review')}})</p>
                </div>

                @if($product->product->hasDeal)
                  @if($product->product->hasDeal->discount > 0)
                    <span class="price_off">

                      @if($product->product->hasDeal->discount_type == 0)
                        {{$product->product->hasDeal->discount}} % {{__('common.off')}}
                      @else
                      {{single_price($product->product->hasDeal->discount)}} {{__('common.off')}}
                      @endif


                    </span>
                  @endif
                @else
                  @if(@$product->product->hasDiscount == 'yes')
                    <span class="price_off">

                      @if($product->product->discount_type == 0)
                        {{$product->product->discount}} % {{__('common.off')}}
                      @else
                      {{single_price($product->product->discount)}} {{__('common.off')}}
                      @endif


                    </span>
                  @endif
                @endif


              </div>

            </div>
        </div>
            @endif
        @endforeach

    </div>

      <div class="col-lg-12">

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
    @else
    <div class="row mt-20">
      <div class="col-lg-12 text-center">
        <p class="mt-200">{{__('defaultTheme.no_product_in_wishlist')}}</p>
      </div>
    </div>
    @endif

  </div>
