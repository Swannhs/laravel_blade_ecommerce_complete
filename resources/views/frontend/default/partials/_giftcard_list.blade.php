<div class="category_product_page">

    @php
          $total_number_of_item_per_page = $cards->perPage();
          $total_number_of_items = ($cards->total() > 0) ? $cards->total() : 0;
          $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
          $reminder = $total_number_of_items % $total_number_of_item_per_page;
          if ($reminder > 0) {
              $total_number_of_pages += 1;
          }
          $current_page = $cards->currentPage();
          $previous_page = $cards->currentPage() - 1;
          if($current_page == $cards->lastPage()){
            $show_end = $total_number_of_items;
          }else{
            $show_end = $total_number_of_item_per_page * $current_page;
          }


          $show_start = 0;
          if($total_number_of_items > 0){
            $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
          }


      @endphp

    <div class="product_page_tittle d-flex justify-content-between">
        <p>Showing @if($show_start == $show_end) {{$show_end}} @else {{$show_start}} - {{$show_end}} @endif out of total {{$total_number_of_items}} products</p>
        <div class="short_by">
            <select name="paginate_by"  id="paginate_by" class="filterDataChange">
                <option value="12" @if (isset($paginate) && $paginate == "12") selected @endif>12</option>
                <option value="16" @if (isset($paginate) && $paginate == "16") selected @endif>16</option>
                <option value="25" @if (isset($paginate) && $paginate == "25") selected @endif>25</option>
                <option value="30" @if (isset($paginate) && $paginate == "30") selected @endif>30</option>
            </select>
        </div>
        <div class="short_by">
            <select name="sort_by" id="product_short_list" class="filterDataChange">
                <option value="new" @if (isset($sort_by) && $sort_by == "new") selected @endif>NEW</option>
                <option value="old" @if (isset($sort_by) && $sort_by == "old") selected @endif>Old</option>
                <option value="alpha_asc" @if (isset($sort_by) && $sort_by == "alpha_asc") selected @endif>Name (A to Z)</option>
                <option value="alpha_desc" @if (isset($sort_by) && $sort_by == "alpha_desc") selected @endif>Name (Z to A)</option>
                <option value="low_to_high" @if (isset($sort_by) && $sort_by == "low_to_high") selected @endif>Price (Low to High)</option>
                <option value="high_to_low" @if (isset($sort_by) && $sort_by == "high_to_low") selected @endif>Price (High to Low)</option>
            </select>
        </div>
    </div>
    <div class="row">
        @if(count($cards)>0)
        @foreach($cards as $key => $card)
        <div class="col-lg-4 col-sm-6 col-md-6 single_product_item">
            <div class="single_product_list product_tricker">
                <div class="product_img">
                    <a href="{{route('frontend.gift-card.show',$card->sku)}}" class="product_img_iner">
                        <img src="{{asset(asset_path($card->thumbnail_image))}}" alt="#" class="img-fluid">
                    </a>
                    <div class="socal_icon">
                        <a href="" class="add_to_wishlist {{$card->IsWishlist == 1?'is_wishlist':''}}" id="wishlistbtn_{{$card->id}}" data-product_id="{{$card->id}}" data-seller_id="{{ App\Models\User::where('role_id', 1)->first()->id }}"> <i class="ti-heart"></i> </a>
                        <a class="add_to_cart_gift_thumnail" data-gift-card-id="{{ $card->id }}" data-seller="{{ App\Models\User::where('role_id', 1)->first()->id }}" data-base-price="@if($card->hasDiscount()) {{selling_price($card->selling_price, $card->discount_type, $card->discount)}} @else {{$card->selling_price}} @endif"> <i class="ti-bag"></i> </a>
                    </div>
                </div>
                <div class="product_text">
                    <h5>
                        <a href="{{route('frontend.gift-card.show',$card->sku)}}">{{$card->name}}</a>
                    </h5>
                    <div class="product_review_star d-flex justify-content-between align-items-center">
                        @if($card->hasDiscount())
                            <p>{{single_price(selling_price($card->selling_price, $card->discount_type, $card->discount))}}</p>
                        @else
                            <p>{{single_price($card->selling_price)}}</p>
                        @endif


                        <div class="review_star_icon">

                            @php
                                $reviews = $card->reviews->where('status',1)->pluck('rating');
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
                            @if($card->hasDiscount())
                                @if($card->discount > 0)
                                {{single_price($card->selling_price)}}
                                @endif
                            @endif
                        </span>
                        <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} Review)</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @else
            <div class="no_card_text text-center">
                <p>{{ __('defaultTheme.no_gift_card_found') }}</p>
            </div>
        @endif
    </div>
    <input type="hidden" name="filterCatCol" class="filterCatCol" value="0">

    @if(count($cards)>0)
    <div class="col-lg-12">

        <div class="pagination_part">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{ $cards->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                    @for ($i=1; $i <= $total_number_of_pages; $i++)
                        @if (($cards->currentPage() + 2) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $cards->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($cards->currentPage() + 1) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $cards->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if ($cards->currentPage() == $i)
                            <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $cards->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($cards->currentPage() - 1) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $cards->url($i) }}">{{ $i }}</a></li>
                        @endif
                        @if (($cards->currentPage() - 2) == $i)
                            <li class="page-item"><a class="page-link" href="{{ $cards->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{ $cards->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
                </ul>
            </nav>
        </div>
    </div>
    @endif
</div>
