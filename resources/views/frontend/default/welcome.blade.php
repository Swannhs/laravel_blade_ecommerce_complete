@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/welcome.css'))}}" />


@endsection
@section('content')


 <!-- banner paer here -->
 @include('frontend.default.partials._mega_menu')
  <!-- banner paer end -->

  <!-- best product list here -->
  <section class="best_product_list mt_40">
    @php
        $best_deal = $widgets->where('section_name','best_deals')->first();

    @endphp
    <div class="container">
      <div class="row">
        <div id="best_deals" class="{{$best_deal->column_size}} {{$best_deal->status == 0?'d-none':''}}">
          <div class="best_product_list_iner p_30 bg-white">
            <div class="product_list_tittle">
              <h5 id="best_deals_title">{{$best_deal->title}}</h5>
              <a href="{{route('frontend.category-product',['slug' =>  ($best_deal->section_name), 'item' =>'product'])}}" class="product_btn">{{ __('common.view_all') }}</a>

            </div>
            <div class="best_product_slider product_slider_1 owl-carousel">
              @foreach($best_deal->getProductByQuery() as $key => $product)
              <div class="single_best_product_list product_tricker">
                <a href="{{route('frontend.item.show',$product->slug)}}"  class="product_img">
                  <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="#" class="img-fluid" />
                </a>
                <div class="product_text d-flex justify-content-between">
                  <div class="product_text_iner">
                    <a href="{{route('frontend.item.show',$product->slug)}}"><h5>@if($product->product_name != null) {{ substr($product->product_name,0,15) }} @if(strlen($product->product_name) > 15)... @endif @else {{substr(@$product->product->product_name,0,15)}} @if(strlen(@$product->product->product_name) > 15)... @endif @endif</h5></a>
                    <p>
                      @if($product->hasDeal)
                        {{single_price(selling_price(@$product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                      @else
                        @if($product->hasDiscount == 'yes')
                        {{single_price(selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                        @else
                        {{single_price(@$product->skus->first()->selling_price)}}
                        @endif

                      @endif
                    </p>

                  </div>
                  @if($product->hasDeal)
                    @if($product->hasDeal->discount >0)
                      <span class="product_btn">

                        @if($product->hasDeal->discount_type ==0)
                          {{$product->hasDeal->discount}} % off
                        @else
                        {{single_price($product->hasDeal->discount)}} off
                        @endif


                      </span>
                    @endif
                  @else

                    @if($product->hasDiscount == 'yes')

                      @if($product->discount >0)
                        <span class="product_btn">

                          @if($product->discount_type ==0)
                            {{$product->discount}} % off
                          @else
                          {{single_price($product->discount)}} off
                          @endif


                        </span>
                      @endif
                    @endif
                  @endif
                </div>
              </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- best product list end -->

  <!-- feature category start -->
  <section class="feature_product mt_40">
    <div class="container">
      @php
        $feature_categories = $widgets->where('section_name','feature_categories')->first();
      @endphp
      <div class="row">
        <div id="feature_categories" class="{{$feature_categories->column_size}} {{$feature_categories->status == 0?'d-none':''}}">
          <div class="product_list_tittle">
            <h5 id="feature_categories_title">{{$feature_categories->title}}</h5>
          </div>
          <div class="feature_slide owl-carousel">
            @foreach($feature_categories->getCategoryByQuery() as $key => $category)

            @php
              $category_products = @$category->sellerProducts();
            @endphp

            @if($key % 2 == 0)
            <div class="single_feature_slide bg-white p_15">
              <div class="product_list_tittle">
                <h5>{{$category->name}}</h5>
                <a href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}" class="product_btn">{{ __('common.view_all') }}</a>
              </div>
              <div class="feature_slide_img colum6">

                @foreach($category_products as $key => $product)

                <a href="{{route('frontend.item.show',$product->slug)}}" class="single_feature_slide_img">
                  <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="{{$product->product->product_name}}" class="img-fluid" />
                </a>

                @endforeach

              </div>
            </div>
            @else
            <div class="single_feature_slide bg-white p_20">
              <div class="product_list_tittle">
                <h5>{{$category->name}}</h5>
                <a href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}" class="product_btn">{{ __('common.view_all') }}</a>
              </div>
              <div class="feature_slide_img colum3">

                <div class="single_img">
                  @if(isset($category_products[0]))
                  <a href="{{route('frontend.item.show',@$category_products[0]->slug)}}" class="single_feature_slide_img">
                    <img src="{{showImage(@$category_products[0]->product->thumbnail_image_source)}}" alt="#" />
                  </a>
                  @endif
                  @if(isset($category_products[1]))
                  <a href="{{route('frontend.item.show',$category_products[1]->slug)}}" class="single_feature_slide_img">
                    <img src="{{showImage($category_products[1]->product->thumbnail_image_source)}}" alt="#" />
                  </a>
                  @endif
                </div>
                @if(isset($category_products[2]))
                <div class="big_img">
                  <a href="{{route('frontend.item.show',$category_products[2]->slug)}}" class="single_feature_slide_img">
                    <img src="{{showImage($category_products[2]->product->thumbnail_image_source)}}" alt="#" />
                  </a>
                </div>
                @endif

              </div>
            </div>
            @endif

            @endforeach

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- feature product end -->

  <!--feature brands start-->
  <section class="feature_brands mt_40">
    <div class="container">
      @php
        $top_brands = $widgets->where('section_name','top_brands')->first();
      @endphp
      <div class="row">
        <div id="top_brands" class="{{$top_brands->column_size}} {{$top_brands->status == 0?'d-none':''}}">
          <div class="best_product_list_iner p_20 bg-white">
            <div class="product_list_tittle">
              <h5 id="top_brands_title">{{$top_brands->title}}</h5>

            </div>
            <div class="best_product_slider product_slider_2 owl-carousel pb-15">
              @foreach($top_brands->getBrandByQuery() as $key => $brand)
              <div class="single_best_product_list product_tricker">
                <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}" class="product_img">
                  <img
                    src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}"
                    alt="#"
                    class="img-fluid"
                  />
                </a>
                <div class="product_text d-flex justify-content-between">
                  <div class="product_text_iner top_brand_product_text">
                    <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}"><h5 class="brand_name">{{$brand->name}}</h5></a>

                  </div>
                </div>
              </div>
              @endforeach


            </div>
          </div>
        </div>

        @php
        $top_picks = $widgets->where('section_name','top_picks')->first();
        @endphp
        <div id="top_picks" class="{{$top_picks->column_size}} {{$top_picks->status == 0?'d-none':''}}">
          <div class="best_product_list_iner p_20 bg-white">
            <div class="product_list_tittle">
              <h5 id="top_picks_title">{{$top_picks->title}}</h5>
              <a href="{{route('frontend.category-product',['slug' => ($top_picks->section_name), 'item' =>'product'])}}" class="product_btn">{{ __('common.view_all') }}</a>
            </div>
            <div class="best_product_slider product_slider_2 owl-carousel">

              @foreach($top_picks->getProductByQuery() as $key => $product)
                  @if($key % 2 == 0)
                  <div class="single_best_product_list product_tricker">
                    <a href="{{route('frontend.item.show',$product->slug)}}" class="product_img">
                      <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage(@$product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product_name}}" class="img-fluid" />
                    </a>
                    <div class="product_text d-flex justify-content-between">
                      <div class="product_text_iner">
                        <a href="{{route('frontend.item.show',$product->slug)}}"><h5>@if ($product->product_name) {{ substr($product->product_name,0,12) }} @if(strlen($product->product_name) > 12)... @endif @else {{substr(@$product->product->product_name,0,12)}} @if(strlen(@$product->product->product_name) > 12)... @endif @endif</h5></a>
                        <p>
                          @if($product->hasDeal)
                            {{single_price(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                          @else
                            @if($product->hasDiscount == 'yes')
                            {{single_price(selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                            @else
                            {{single_price($product->skus->first()->selling_price)}}
                            @endif
                          @endif
                        </p>
                      </div>

                      @if($product->hasDeal)
                        @if($product->hasDeal->discount >0)
                          <span class="product_btn">

                            @if($product->hasDeal->discount_type ==0)
                              {{$product->hasDeal->discount}} % off
                            @else
                            {{single_price($product->hasDeal->discount)}} off
                            @endif


                          </span>
                        @endif
                      @else
                        @if($product->hasDiscount == 'yes')
                          @if($product->discount >0)
                            <span class="product_btn">

                              @if($product->discount_type ==0)
                                {{$product->discount}} % off
                              @else
                              {{single_price($product->discount)}} off
                              @endif


                            </span>
                          @endif
                        @endif
                      @endif


                    </div>
                  </div>
                  @else
                  <div class="single_best_product_list product_tricker">
                    <div class="feature_slide_img colum3">
                      <div class="single_img">
                        <a href="{{route('frontend.item.show',$product->slug)}}" class="single_feature_slide_img">
                          <img src="
                            @if($product->thum_img)
                            {{showImage(@$product->thum_img)}}
                            @else
                            {{showImage(@$product->product->thumbnail_image_source)}}
                            @endif
                          " alt="#" />
                        </a>
                        <a href="{{route('frontend.item.show',$product->slug)}}" class="single_feature_slide_img">
                          <img src="
                            @if(@$product->product->gallary_images[0]->images_source)
                            {{showImage(@$product->product->gallary_images[0]->images_source)}}
                            @elseif(@$product->thum_img)
                            {{showImage(@$product->thum_img)}}
                            @else
                            {{showImage(@$product->product->thumbnail_image_source)}}
                            @endif
                          " alt="#" />
                        </a>
                      </div>
                      <div class="big_img">
                        <a href="{{route('frontend.item.show',$product->slug)}}" class="single_feature_slide_img">
                          <img src="
                          @if(@$product->product->gallary_images[1]->images_source)
                          {{showImage(@$product->product->gallary_images[1]->images_source)}}
                          @elseif(@$product->thum_img)
                          {{showImage(@$product->thum_img)}}
                          @else
                          {{showImage(@$product->product->thumbnail_image_source)}}
                          @endif
                          " alt="#" />
                        </a>
                      </div>
                    </div>
                    <div class="product_text d-flex justify-content-between">
                      <div class="product_text_iner">
                        <a href="{{route('frontend.item.show',$product->slug)}}"><h5>@if ($product->product_name) {{ substr($product->product_name,0,12) }} @if(strlen($product->product_name) > 12)... @endif @else {{substr(@$product->product->product_name,0,12)}} @if(strlen(@$product->product->product_name) > 12)... @endif @endif</h5></a>
                        <p>
                          @if($product->hasDeal)
                            {{single_price(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                          @else
                            @if($product->hasDiscount == 'yes')
                            {{single_price(selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                            @else
                            {{single_price($product->skus->first()->selling_price)}}
                            @endif
                          @endif
                        </p>
                      </div>

                      @if($product->hasDeal)
                        @if($product->hasDeal->discount >0)
                          <span class="product_btn">

                            @if($product->hasDeal->discount_type ==0)
                              {{$product->hasDeal->discount}} % off
                            @else
                            {{single_price($product->hasDeal->discount)}} off
                            @endif


                          </span>
                        @endif
                      @else
                        @if($product->hasDiscount == 'yes')
                          @if($product->discount >0)
                            <span class="product_btn">

                              @if($product->discount_type ==0)
                                {{$product->discount}} % off
                              @else
                              {{single_price($product->discount)}} off
                              @endif


                            </span>
                          @endif
                        @endif
                      @endif



                    </div>
                  </div>
                  @endif
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--feature brands end-->

  <!-- all product -->
  <section class="all_product mt_40">
    @php
        $more_products = $widgets->where('section_name','more_products')->first();
    @endphp
    <div class="container">
      <div class="row dataApp">
        <div id="more_products" class="{{$more_products->column_size}} {{$more_products->status == 0?'d-none':''}}">
          <div class="row mb_32">
            <div class="col-lg-12">
              <div class="product_list_tittle">
                <h5 id="more_products_title">{{$more_products->title}}</h5>
              </div>
            </div>
            @foreach($more_products->getHomePageProductByQuery() as $key => $product)
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
                                @if($product->hasDiscount == 'yes')
                                    {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}

                                @else
                                    {{single_price(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif
                        </p>
                            <div class="review_star_icon">
                                @php
                                    $reviews = $product->reviews->where('status',1)->pluck('rating');

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
                    @if($product->hasDeal)
                        @if($product->hasDeal->discount >0)
                            <span class="new_price">
                                @if($product->hasDeal->discount >0)
                                    @if($product->hasDeal->discount_type ==0)
                                        {{$product->hasDeal->discount}} % off
                                    @else
                                        {{single_price($product->hasDeal->discount)}} off
                                    @endif

                                @endif
                            </span>
                        @endif
                    @else
                        @if($product->hasDiscount == 'yes')
                          @if($product->discount > 0)
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
                    @endif
                    </div>
                </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <a id="loadmore" class="load_more_btn_homepage mt-2"> <i class="ti-reload"></i> {{ __('defaultTheme.load_more') }}</a>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">

    <div class="add-product-to-cart-using-modal">

    </div>
  </section>
  @include(theme('partials._subscription_modal'))

@endsection

@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))



