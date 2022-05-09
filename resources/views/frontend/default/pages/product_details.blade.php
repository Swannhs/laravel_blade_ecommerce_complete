@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/product_details.css'))}}" />


@endsection

@section('title')
{{$product->product_name}}
@endsection
@section('share_meta')
    <meta property="og:title" content="{{$product->product_name}}" />
    <meta property="og:description" content="{{$product->product->meta_description}}" />
    @if($product->product->meta_description == null)
        <meta property="og:description" content="{{$product->product->description}}" />
    @endif

    @if($product->product->meta_image != null && getimagesize(showImage($product->product->meta_image))[0] > 200)
        
        <meta property="og:image" content="{{showImage($product->product->meta_image)}}" />
    @elseif($product->product->thumbnail_image_source != null && getimagesize(showImage($product->product->thumbnail_image_source))[0] > 200)
    
        <meta property="og:image" content="{{showImage($product->product->thumbnail_image_source)}}" />
    @elseif(count($product->product->gallary_images) > 0 && getimagesize(showImage($product->product->gallary_images[0]->images_source))[0] > 200)
        <meta property="og:image" content="{{showImage($product->product->gallary_images[0]->images_source)}}" />
        
    @endif
    <meta property="og:url" content="{{route('frontend.item.show',$product->slug)}}" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:type" content="{{$product->product->meta_description}}" />
@endsection

@section('content')
<!-- product details here -->
<section class="product_details_part section_padding">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-xl-6">
                <div class="product_details_img">
                    <div class="tab-content tab_content" id="myTabContent">
                        @if(count($product->product->gallary_images) > 0)
                        @foreach($product->product->gallary_images as $image)
                        <div class="gallary_img tab-pane fade {{$product->product->gallary_images->first()->id == $image->id?'show active':''}}" id="thumb_{{$image->id}}" role="tabpanel">
                            <div class="img_div">
                                <img data-zoom-image="{{showImage($image->images_source)}}" src="{{showImage($image->images_source)}}" alt="#" class="img-fluid var_img_show zoom_01" />
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="tab-pane fadeshow active" id="thumb_{{$product->id}}" role="tabpanel">
                            <div class="img_div">
                                <img @if ($product->thum_img != null) data-zoom-image="{{showImage($product->thum_img)}}" @else data-zoom-image="{{showImage($product->product->thumbnail_image_source)}}" @endif @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="" class="img-fluid var_img_show zoom_01" />
                            </div>
                        </div>
                        @endif

                    </div>
                    <ul class="nav tab_thumb" id="myTab" role="tablist">
                        @if(count($product->product->gallary_images) > 0)
                        @foreach($product->product->gallary_images as $image)
                        <li class="nav-item thumb_small_m">
                            <a class="nav-link" id="thumb_{{$image->id}}_tab" data-toggle="tab" href="#thumb_{{$image->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">
                                    <img src="{{showImage($image->images_source)}}" alt="#" class="img-fluid"/>
                                </div>
                            </a>
                        </li>
                        @endforeach

                        @else
                        <li class="nav-item">
                            <a class="nav-link" id="thumb_{{$product->id}}_tab" data-toggle="tab" href="#thumb_{{$product->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">
                                    <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="#" class="img-fluid"/>
                                </div>
                            </a>
                        </li>

                        @endif
                        <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="maximum_order_qty" value="{{@$product->product->max_order_qty}}">
                        <input type="hidden" id="minimum_order_qty" value="{{@$product->product->minimum_order_qty}}">

                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="product_details">
                    @foreach($product->product->categories->where('status', 1) as $key => $category)
                        <a href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}" class="product_details_btn_iner">{{$category->name}}</a>
                    @endforeach
                    <div class="tittle">
                        <h2>{{$product->product_name}}</h2>
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
                        <h2 id="main_price">
                            @if($product->hasDeal)
                                @if ($product->product->product_type == 1)
                                    {{single_price(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                                @else
                                    @if (selling_price($product->skus->min('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount) === selling_price($product->skus->max('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount))
                                        {{single_price(selling_price($product->skus->min('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                                    @else
                                        {{single_price(selling_price($product->skus->min('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount))}} - {{single_price(selling_price($product->skus->max('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                                    @endif
                                @endif
                            @else

                                @if ($product->product->product_type == 1)
                                    @if($product->hasDiscount == 'yes')
                                        {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}

                                    @else
                                        {{single_price(@$product->skus->first()->selling_price)}}
                                    @endif
                                @else
                                    @if (selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount) == selling_price($product->skus->max('selling_price'),$product->discount_type,$product->discount))
                                        {{single_price(selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount))}}
                                        
                                    @else
                                        @if($product->hasDiscount == 'yes')
                                        {{single_price(selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount))}}

                                        @else
                                            {{single_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount)}}
                                        @endif -

                                        @if($product->hasDiscount == 'yes')
                                        {{single_price(selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))}}

                                        @else
                                            {{single_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount)}}
                                        @endif

                                    @endif
                                @endif
                            @endif
                        </h2>
                        @if($product->hasDeal || $product->hasDiscount == 'yes')
                            <span>{{single_price($product->skus->max('selling_price'))}}</span>
                        @endif

                        <input type="hidden" name="product_sku_id" id="product_sku_id" value="{{$product->product->product_type == 1?$product->skus->first()->id : $product->skus->first()->id}}">
                        <input type="hidden" name="seller_id" id="seller_id" value="{{$product->user_id}}">
                        <input type="hidden" name="stock_manage_status" id="stock_manage_status" value="{{$product->stock_manage}}">

                    </div>
                    @if ($product->stock_manage == 0)
                        <p id="availability" class="d-none">{{__('defaultTheme.unlimited')}}</p>
                    @endif
                    @if(isModuleActive('MultiVendor'))
                        <div class="single_details_content d-flex mb-2">
                            <h5 class="mb-0">{{__('defaultTheme.sold_by')}}:</h5>

                            @if ($product->seller->slug)
                            <a href="{{route('frontend.seller',$product->seller->slug)}}" class="product_details_btn_iner">
                                @if($product->seller->role->type == 'seller')
                                    @if (@$product->seller->SellerAccount->seller_shop_display_name)
                                        {{ @$product->seller->SellerAccount->seller_shop_display_name }}
                                    @else
                                        {{$product->seller->first_name .' '.$product->seller->last_name}}
                                    @endif
                                @else
                                    {{ app('general_setting')->company_name }}
                                @endif
                            </a>
                            @else
                            <a href="{{route('frontend.seller',base64_encode($product->seller->id))}}" class="product_details_btn_iner">
                                @if($product->seller->role->type == 'seller')
                                    @if (@$product->seller->SellerAccount->seller_shop_display_name)
                                        {{ @$product->seller->SellerAccount->seller_shop_display_name }}
                                    @else
                                        {{$product->seller->first_name .' '.$product->seller->last_name}}
                                    @endif
                                @else
                                    {{ app('general_setting')->company_name }}
                                @endif
                            </a>
                            @endif

                        </div>
                    @endif
                    <div class="product_details_content">
                        <ul>
                            @php
                                $stock = 0;
                            @endphp
                            @if ($product->stock_manage == 1)
                                <li>{{__('defaultTheme.availability')}} : <span id="availability">{{ $product->skus->first()->product_stock }}</span></li>
                            @endif

                        </ul>
                        <ul>
                            <li>{{__('defaultTheme.sku')}}: <span id="sku_id_li">{{$product->skus->first()->sku->sku}}</span></li>


                            <li>{{__('common.category')}} :
                                @php
                                    $cates = count($product->product->categories);
                                @endphp
                                @foreach($product->product->categories as $key => $category)
                                    <span>{{$category->name}}</span>
                                    @if($key + 1 < $cates), @endif
                                @endforeach
                            </li>

                            <li>{{__('common.tag')}} : <span>
                                @php
                                    $total_tag = count($product->product->tags);
                                @endphp
                                @foreach($product->product->tags as $key => $tag)
                                    <a class="tag_link" target="_blank" href="{{route('frontend.category-product',['slug' => $tag->name, 'item' =>'tag'])}}">{{$tag->name}}</a>
                                    @if($key + 1 < $total_tag), @endif
                                @endforeach
                            </span></li>
                        </ul>
                    </div>
                    @if($product->product->product_type == 2)
                        @foreach (session()->get('item_details') as $key => $item)

                            @if ($item['name'] != "Color")
                                <div class="single_details_content d-md-flex">
                                    <h5>{{$item['name']}}:</h5>
                                    <input type="hidden" class="attr_value_name" name="attr_val_name[]" value="{{$item['value'][0]}}">
                                    <input type="hidden" class="attr_value_id" name="attr_val_id[]" value="{{$item['id'][0]}}-{{$item['attr_id']}}">
                                    <div class="size_btn">
                                        @foreach ($item['value'] as $m => $value_name)
                                            <a class="attr_val_name not_111 @if ($m === 0) selected_btn @endif" color="not" data-value-key="{{$item['attr_id']}}" data-value="{{ $item['id'][$m] }}">{{ $value_name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @if ($product->product->product_type == 2)
                        <div class="single_details_content variant_image d-md-flex">
                            <h5>{{__('common.image')}}:</h5>
                            <div class="img_div_width">
                                @foreach($product->skus as $sku)
                                    @if ($sku->sku->variant_image)
                                        <div class="sku_img_div">
                                            <img src="{{showImage($sku->sku->variant_image)}}" alt="#" class="img-fluid p-1 var_img_source" title="{{ $sku->sku->sku }}"/>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="single_details_content d-md-flex">
                        <div class="details_text d-flex">
                            <h5 class="mb-0">{{__('common.quantity')}}:</h5>
                            <div class="product_count">
                                <input type="text" name="qty" class="qty" id="qty" readonly value="{{@$product->product->minimum_order_qty}}"/>
                                <div class="button-container">
                                    <button class="cart-qty-plus qtyChange" data-value="+" type="button" value="+">
                                        <i class="ti-plus"></i>
                                    </button>
                                    <button class="cart-qty-minus qtyChange" data-value="-" type="button" value="-">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_type" class="product_type" value="{{ $product->product->product_type }}">
                        @if($product->product->product_type == 2)
                            @foreach (session()->get('item_details') as $key => $item)

                                @if ($item['name'] === "Color")

                                    <div class="cs_color_btn">
                                        <h4>{{ $item['name'] }}:</h4>
                                        <div class="cs_radio_btn">
                                            <input type="hidden" class="attr_value_name" name="attr_val_name[]" value="{{$item['value'][0]}}">
                                            <input type="hidden" class="attr_value_id" name="attr_val_id[]" value="{{$item['id'][0]}}-{{$item['attr_id']}}">
                                            @foreach ($item['value'] as $k => $value_name)
                                                <div class="radio colors_{{$k}} class_color_{{ $item['code'][$k] }}">
                                                    <input id="radio-{{$k}}" name="radio" id="radio" type="radio" color="color" class="attr_val_name attr_clr @if ($k === 0) selected_btn @endif" data-value="{{ $item['id'][$k] }}" data-value-key="{{$item['attr_id']}}" value="{{ $value_name }}"/>
                                                    <label for="radio-{{$k}}" class="radio-label"></label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    @if(isModuleActive('MultiVendor'))
                        <div class="single_details_content mt_30 d-md-flex">
                            <h5>{{__('defaultTheme.shipping')}}:</h5>
                            <div class="details_content_iner">
                                <select name="shipping_type" id="shipping_type" class="select_address default_select">
                                    @foreach(@$product->product->shippingMethods as $key => $method)

                                    <option value="{{@$method->shippingMethod->id}}">
                                        {{@$method->shippingMethod->method_name}} - {{single_price(@$method->shippingMethod->cost)}} ({{@$method->shippingMethod->shipment_time}})
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="shipping_type" id="shipping_type" value="{{@$product->product->shippingMethods[0]->shippingMethod->id}}">
                    @endif
                    <div class="single_details_content d-flex">
                        <input type="hidden" name="base_sku_price" id="base_sku_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        ">
                        <input type="hidden" name="final_price" id="final_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        ">
                        <h5 class="mb-0">{{__('common.total')}}:</h5>
                        <h2 id="total_price">
                            @if(@$product->hasDeal)
                                {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) * $product->product->minimum_order_qty)}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                    {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) * $product->product->minimum_order_qty)}}

                                @else
                                    {{single_price(@$product->skus->first()->selling_price * $product->product->minimum_order_qty)}}
                                @endif

                            @endif


                        </h2>
                    </div>
                    <div class="product_details_btn">
                        <span id="add_to_cart_div">
                        @if ($product->stock_manage == 1 && $product->skus->first()->product_stock >= $product->product->minimum_order_qty)
                            <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                        @elseif($product->stock_manage == 0)
                            <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                        @else
                            <button type="button" disabled class="btn_1">{{__('defaultTheme.out_of_stock')}}</button>
                        @endif
                        </span>

                        <a class="btn_2 btn_2_padding" id="wishlist_btn" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}">{{__('defaultTheme.add_to_wishlist')}}</a>
                        <a class="btn_2 btn_2_padding" id="add_to_compare_btn" data-product_sku_id="#product_sku_id" data-product_type="{{$product->product->product_type}}">{{__('defaultTheme.add_to_compare')}}</a>
                    </div>
                    <div class="single_details_content social_icon d-flex">
                        <h5 class="mb-0">{{__('defaultTheme.share_on')}}:</h5>
                        <div class="social_icon_iner">
                            <a target="_blank" href="{{ Share::currentPage()->facebook()->getRawLinks() }}"><i class="ti-facebook"></i></a>
                            <a target="_blank" href="{{ Share::currentPage()->twitter()->getRawLinks() }}"><i class="ti-twitter-alt"></i></a>
                            <a target="_blank" href="{{ Share::currentPage()->linkedin()->getRawLinks() }}"><i class="ti-linkedin"></i></a>
                            <a target="_blank" href="{{ Share::currentPage()->whatsapp()->getRawLinks() }}"><i class="fab fa-whatsapp"></i></a>
                            <a target="_blank" href="{{ Share::currentPage()->telegram()->getRawLinks() }}"><i class="fab fa-telegram-plane"></i></a>
                            <a target="_blank" href="{{ Share::currentPage()->reddit()->getRawLinks() }}"><i class="ti-reddit"></i></a>
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
                                {{__('common.description')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Specifications-tab" data-toggle="tab" href="#specifications" role="tab" aria-controls="Specifications" aria-selected="false">
                                {{__('product.specifications')}}
                            </a>
                        </li>
                        @if(isModuleActive('MultiVendor') && $product->seller->role->type == 'seller')
                        <li class="nav-item">
                            <a class="nav-link" id="Seller-tab" data-toggle="tab" href="#Seller" role="tab" aria-controls="Seller" aria-selected="false">
                                {{__('defaultTheme.seller_info')}}
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">
                                {{__('defaultTheme.reviews')}}
                            </a>
                        </li>
                        @if ($product->product->video_link)

                        <li class="nav-item">
                            <a class="nav-link" id="Video-tab" data-toggle="tab" href="#Video" role="tab" aria-controls="Video" aria-selected="false">
                                {{__('defaultTheme.video')}}
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">

                            <div class="item_description">
                                <h4>{{__('defaultTheme.product_description')}}</h4>
                                @php
                                    echo $product->product->description;
                                @endphp
                            </div>

                        </div>
                        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="Specifications-tab">
                            <div class="product_details">
                                <h4>{{__('defaultTheme.product_specifications')}}</h4>
                                <br>
                                <div class="">

                                    <table class="table table-striped">
                                        <tr>
                                            <td>{{ __('common.brand') }}</td>
                                            <td>{{$product->product->brand->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.model_number') }}</td>
                                            <td>{{$product->product->model_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.availability') }}</td>
                                            <td>  @if ($product->stock_manage == 1 && $product->skus->first()->product_stock >= $product->product->minimum_order_qty)
                                               {{ __('common.in_stock') }}
                                            @elseif($product->stock_manage == 0)
                                               {{ __('common.in_stock') }}
                                            @else
                                                <button type="button" disabled class="btn_1">{{__('defaultTheme.out_of_stock')}}</button>
                                            @endif</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.product') }} {{ __('product.sku') }}</td>
                                            <td>
                                                @foreach ($product->product->skus as $sku)
                                                {{$sku->sku}} &nbsp; &nbsp;
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.minimum_order_quantity') }}</td>
                                            <td>{{$product->product->minimum_order_qty}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.maximum_order_quantity') }}</td>
                                            <td>{{$product->product->max_order_qty}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.listed_date') }}</td>
                                            <td>{{date(app('general_setting')->dateFormat->format, strtotime($product->product->created_at))}}</td>
                                        </tr>
                                    </table>
                                </div>
                                @php
                                    echo $product->product->specification;
                                @endphp
                            </div>

                        </div>
                        @if(isModuleActive('MultiVendor') && $product->seller->role->type == 'seller')
                        <div class="tab-pane fade" id="Seller" role="tabpanel" aria-labelledby="Seller-tab">
                            <div class="product_details">
                                @php echo $product->seller->sellerAccount->about_seller; @endphp

                            </div>
                        </div>
                        @endif
                        <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                            @include(theme('partials._product_review_with_paginate'),['reviews' => @$product->ActiveReviewsWithPaginate])

                        </div>
                        @if ($product->product->video_link)
                        <div class="tab-pane fade" id="Video" role="tabpanel" aria-labelledby="Video-tab">
                            <div class="product_details">
                                @if ($product->product->video_provider == 'youtube')
                                @php
                                    $link = str_replace('watch?v=','embed/',$product->product->video_link);
                                @endphp
                                <iframe width="560" height="315" src="{{ $link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                              @endif
                              @if ($product->product->video_provider == 'daily_motion')
                              @php
                                    $link = str_replace('https://dai.ly/','https://www.dailymotion.com/embed/video/',$product->product->video_link);
                                @endphp

                              <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html"
                                src="{{$link}}" width="100%" height="100%" allowfullscreen allow="autoplay"> </iframe> </div>

                              @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @php
                $i = 0;
            @endphp
            @if ($product->product->display_in_details == 1)
                <div class="col-lg-4">
                    <div class="product_details_weiget">
                    <h3>{{ app('general_setting')->up_sale_product_display_title }}</h3>
                        <div class="single_product_details_weiget">
                            @if ($i <= 4)
                                @foreach ($product->up_sales as $key => $up_sale)
                                    @if ($i <= 4)
                                        @foreach ($up_sale->up_seller_products->take(2) as $key => $up_seller_product)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="single_related_product media_style">
                                                <div class="single_product_img">
                                                    <img src="
                                                    @if($up_seller_product->thum_img)
                                                        {{showImage(@$up_seller_product->thum_img)}}
                                                    @else
                                                        {{showImage(@$up_seller_product->product->thumbnail_image_source)}}
                                                    @endif
                                                    " alt="#" class="img-fluid var_img_show" />
                                                    <a href="{{route('frontend.item.show',$up_seller_product->slug)}}" target="_blank"><i class="ti-bag"></i></a>
                                                </div>
                                                <div class="single_product_text align-self-center related_product_width">
                                                    <a href="{{route('frontend.item.show',$up_seller_product->slug)}}" target="_blank">{{ @$up_seller_product->product_name?@$up_seller_product->product_name:@$up_seller_product->product->product_name }}</a>
                                                    <div class="category_product_price">
                                                        <h4>
                                                            @if($up_seller_product->hasDeal)
                                                                @if ($up_seller_product->product->product_type == 1)
                                                                    {{single_price(selling_price($up_seller_product->skus->first()->selling_price,$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount))}}
                                                                @else
                                                                    @if (selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount) === selling_price($up_seller_product->skus->max('selling_price'),$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount))
                                                                        {{single_price(selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount))}}
                                                                    @else
                                                                        {{single_price(selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount))}} - {{single_price(selling_price($up_seller_product->skus->max('selling_price'),$up_seller_product->hasDeal->discount_type,$up_seller_product->hasDeal->discount))}}
                                                                    @endif
                                                                @endif
                                                            @else

                                                                @if ($up_seller_product->product->product_type == 1)
                                                                    @if(@$up_seller_product->hasDiscount == 'yes')
                                                                        {{single_price(selling_price(@$up_seller_product->skus->first()->selling_price,@$up_seller_product->discount_type,@$up_seller_product->discount))}}
                                                                    @else
                                                                        {{single_price(@$up_seller_product->skus->first()->selling_price)}}
                                                                    @endif
                                                                @else
                                                                    @if(@$up_seller_product->hasDiscount == 'yes')
                                                                        @if (selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount) === selling_price($up_seller_product->skus->max('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))
                                                                            {{single_price(selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))}}
                                                                        @else
                                                                            {{single_price(selling_price($up_seller_product->skus->min('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))}} - {{single_price(selling_price($up_seller_product->skus->max('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))}}
                                                                        @endif
                                                                    @else
                                                                        @if(@$up_seller_product->skus->min('selling_price') === @$up_seller_product->skus->max('selling_price'))
                                                                            {{single_price($up_seller_product->skus->min('selling_price'))}}
                                                                        @else
                                                                            {{single_price($up_seller_product->skus->min('selling_price'))}} - {{single_price($up_seller_product->skus->max('selling_price'))}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </h4>
                                                        <a href="" class="wishlist_btn_for_site add_to_wishlist {{@$up_seller_product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$up_seller_product->id}}" data-product_id="{{$up_seller_product->id}}" data-seller_id="{{$up_seller_product->user_id}}"><i class="ti-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($i > 3)
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if ($product->product->display_in_details == 2)
                <div class="col-lg-4">
                    <div class="product_details_weiget">
                    <h3>{{ app('general_setting')->cross_sale_product_display_title }}</h3>
                        <div class="single_product_details_weiget">
                            @if ($i <= 4)
                                @foreach ($product->cross_sales as $key => $cross_sale)
                                    @if ($i <= 4)
                                        @foreach ($cross_sale->cross_seller_products->take(2) as $key => $cross_seller_product)
                                            @php
                                                $i++ ;
                                            @endphp
                                            <div class="single_related_product media_style">
                                                <div class="single_product_img">
                                                    <img src="
                                                        @if($cross_seller_product->thum_img)
                                                            {{showImage(@$cross_seller_product->thum_img)}}
                                                        @else
                                                            {{asset(asset_path(@$cross_seller_product->product->thumbnail_image_source))}}
                                                        @endif
                                                    " alt="#" class="img-fluid var_img_show" />
                                                    <a href="{{route('frontend.item.show',$cross_seller_product->slug)}}" target="_blank"><i class="ti-bag"></i></a>
                                                </div>
                                                <div class="single_product_text align-self-center related_product_width">
                                                    <a href="{{route('frontend.item.show',$cross_seller_product->slug)}}" target="_blank">{{ @$cross_seller_product->product_name?@$cross_seller_product->product_name:@$cross_seller_product->product->product_name }}</a>
                                                    <div class="category_product_price">
                                                        <h4>
                                                            @if(@$cross_seller_product->hasDeal)
                                                                @if (@$cross_seller_product->product->product_type == 1)
                                                                    {{single_price(selling_price(@$cross_seller_product->skus->first()->selling_price,@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount))}}
                                                                @else
                                                                    @if (selling_price(@$cross_seller_product->skus->min('selling_price'),@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount) === selling_price(@$cross_seller_product->skus->max('selling_price'),@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount))
                                                                        {{single_price(selling_price(@$cross_seller_product->skus->min('selling_price'),@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount))}}
                                                                    @else
                                                                        {{single_price(selling_price(@$cross_seller_product->skus->min('selling_price'),@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount))}} - {{single_price(selling_price(@$cross_seller_product->skus->max('selling_price'),@$cross_seller_product->hasDeal->discount_type,@$cross_seller_product->hasDeal->discount))}}
                                                                    @endif
                                                                @endif
                                                            @else

                                                                @if ($cross_seller_product->product->product_type == 1)
                                                                    @if(@$cross_seller_product->hasDiscount == 'yes')
                                                                        {{single_price(selling_price(@$cross_seller_product->skus->first()->selling_price,@$cross_seller_product->discount_type,@$cross_seller_product->discount))}}
                                                                    @else
                                                                        {{single_price(@$cross_seller_product->skus->first()->selling_price)}}
                                                                    @endif
                                                                @else
                                                                    @if(@$cross_seller_product->hasDiscount == 'yes')
                                                                        @if (selling_price(@$cross_seller_product->skus->min('selling_price'),$cross_seller_product->discount_type,$cross_seller_product->discount) === selling_price(@$cross_seller_product->skus->max('selling_price'),$cross_seller_product->discount_type,$cross_seller_product->discount))
                                                                            {{single_price(selling_price(@$cross_seller_product->skus->min('selling_price'),$cross_seller_product->discount_type,$cross_seller_product->discount))}}
                                                                        @else
                                                                            {{single_price(selling_price(@$cross_seller_product->skus->min('selling_price'),$cross_seller_product->discount_type,$cross_seller_product->discount))}} - {{single_price(selling_price(@$cross_seller_product->skus->max('selling_price'),$cross_seller_product->discount_type,$cross_seller_product->discount))}}
                                                                        @endif
                                                                    @else
                                                                        @if(@$cross_seller_product->skus->min('selling_price') === @$cross_seller_product->skus->max('selling_price'))
                                                                            {{single_price(@$cross_seller_product->skus->min('selling_price'))}}
                                                                        @else
                                                                            {{single_price(@$cross_seller_product->skus->min('selling_price'))}} - {{single_price(@$cross_seller_product->skus->max('selling_price'))}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </h4>
                                                        <a href="" class="wishlist_btn_for_site add_to_wishlist {{@$cross_seller_product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$cross_seller_product->id}}" data-product_id="{{$cross_seller_product->id}}" data-seller_id="{{$cross_seller_product->user_id}}"><i class="ti-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($i > 3)
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
</section>
<!-- product description end-->
@if ($product->related_sales->count() > 0)
    <!-- related product here -->
    <section class="related_product padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_tittle">
                        <h4>{{__('defaultTheme.related_products')}}</h4>
                    </div>
                </div>
                @foreach ($product->related_sales as $key => $related_sale)
                    @foreach ($related_sale->related_seller_products->take(2) as $key => $related_seller_product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single_related_product media_style">
                                <div class="single_product_img">
                                    <img src="
                                        @if($related_seller_product->thum_img)
                                            {{showImage(@$related_seller_product->thum_img)}}
                                        @else
                                            {{showImage(@$related_seller_product->product->thumbnail_image_source)}}
                                        @endif
                                    " alt="#" class="img-fluid var_img_show" />
                                    <a href="{{route('frontend.item.show',$related_seller_product->slug)}}" target="_blank"><i class="ti-bag"></i></a>
                                </div>
                                <div class="single_product_text align-self-center related_product_width">
                                    <a href="{{route('frontend.item.show',$related_seller_product->slug)}}" target="_blank">{{ @$related_seller_product->product_name?@$related_seller_product->product_name:@$related_seller_product->product->product_name }}</a>
                                    <div class="category_product_price">
                                        <h4>
                                            @if(@$related_seller_product->hasDeal)
                                                @if (@$related_seller_product->product->product_type == 1)
                                                    {{single_price(selling_price(@$related_seller_product->skus->first()->selling_price,@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                @else
                                                    @if (selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount) === selling_price(@$related_seller_product->skus->max('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))
                                                        {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                    @else
                                                        {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}} - {{single_price(selling_price(@$related_seller_product->skus->max('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                    @endif
                                                @endif
                                            @else

                                                @if ($related_seller_product->product->product_type == 1)
                                                    @if(@$related_seller_product->hasDiscount == 'yes')
                                                        {{single_price(selling_price(@$related_seller_product->skus->first()->selling_price,@$related_seller_product->discount_type,@$related_seller_product->discount))}}
                                                    @else
                                                        {{single_price(@$related_seller_product->skus->first()->selling_price)}}
                                                    @endif
                                                @else
                                                    @if(@$related_seller_product->hasDiscount == 'yes')
                                                        @if (selling_price(@$related_seller_product->skus->min('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount) === selling_price(@$related_seller_product->skus->max('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))
                                                            {{single_price(selling_price(@$up_seller_product->skus->min('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))}}
                                                        @else
                                                            {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))}} - {{single_price(selling_price(@$related_seller_product->skus->max('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))}}
                                                        @endif
                                                    @else
                                                        @if(@$related_seller_product->skus->min('selling_price') === @$related_seller_product->skus->max('selling_price'))
                                                            {{single_price(@$related_seller_product->skus->min('selling_price'))}}
                                                        @else
                                                            {{single_price(@$related_seller_product->skus->min('selling_price'))}} - {{single_price(@$related_seller_product->skus->max('selling_price'))}}
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </h4>

                                        <a href="" class="wishlist_btn_for_site add_to_wishlist {{@$related_seller_product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$related_seller_product->id}}" data-product_id="{{$related_seller_product->id}}" data-seller_id="{{$related_seller_product->user_id}}"><i class="ti-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
        </div>


    </section>
    <!-- related product end -->
@endif


@if(@$product->hasDeal)
    <input type="hidden" id="discount_type" value="{{@$product->hasDeal->discount_type}}">
    <input type="hidden" id="discount" value="{{@$product->hasDeal->discount}}">
@else
    @if(@$product->hasDiscount == 'yes')
    <input type="hidden" id="discount_type" value="{{$product->discount_type}}">
    <input type="hidden" id="discount" value="{{$product->discount}}">
    @else
    <input type="hidden" id="discount_type" value="{{$product->discount_type}}">
    <input type="hidden" id="discount" value="0">
    @endif
@endif


@endsection

@push('scripts')
    <script src="{{ asset(asset_path('frontend/default/js/zoom.js')) }}"></script>
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                if($(".zoom_01").length > 0){
                    $(".zoom_01").elevateZoom({
                        scrollZoom : true
                    });
                }

                $(document).on('click', '.page-item a', function(event){
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];

                    fetch_data(page);

                });

                function fetch_data(page){
                    $('#pre-loader').show();

                    var url = "{{route('frontend.product.reviews.get-data')}}" + '?product_id='+ "{{$product->id}}" +'&page=' + page;


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
                        toastr.warning('this is undefined');
                    }

                }


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


                $(document).on('click', '.attr_val_name', function(){

                    $(this).parent().parent().find('.attr_value_name').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));
                    $(this).parent().parent().find('.attr_value_id').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));

                    if ($(this).attr('color') == "color") {
                        $('.attr_clr').removeClass('selected_btn');
                    }
                    if ($(this).attr('color') == "not") {
                        $('.not_111').removeClass('selected_btn');
                    }
                    $(this).addClass('selected_btn');
                    get_price_accordint_to_sku();

                });

                var old_html = $("#myTabContent").html();
                $('.var_img_source').hover(function() {
                    
                    var logo = $(this).attr("src"); // get logo from data-icon parameter
                    $('.var_img_show').attr("src", logo); // change logo
                }, function() {
                    $("#myTabContent").html(old_html); // remove logo
                    if($(".zoom_01").length > 0){
                        $(".zoom_01").elevateZoom({
                            scrollZoom : true
                        });
                    }
                });

                $(document).on('click', '#add_to_cart_btn', function(event){
                    event.preventDefault();
                    addToCart($('#product_sku_id').val(),$('#seller_id').val(),$('#qty').val(),$('#base_sku_price').val(),$('#shipping_type').val(),'product');

                });

                $(document).on('click', '#wishlist_btn', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let type = "product";
                    let is_login = $('#login_check').val();
                    if(is_login == 1){
                        addToWishlist(product_id, seller_id, type);
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }

                });


                $(document).on('click', '#add_to_compare_btn', function(event){
                    event.preventDefault();
                    let product_sku_class = $(this).data('product_sku_id');
                    let product_sku_id = $(product_sku_class).val();
                    let product_type = $(this).data('product_type');
                    addToCompare(product_sku_id, product_type, 'product');
                });

                $(document).on('click', '.qtyChange', function(event){
                    event.preventDefault();
                    let value = $(this).data('value');
                    qtyChange(value);
                });

                function qtyChange(val){
                    $('.cart-qty-minus').prop('disabled',false);
                    let available_stock = $('#availability').html();
                    let stock_manage_status = $('#stock_manage_status').val();
                    let maximum_order_qty = $('#maximum_order_qty').val();
                    let minimum_order_qty = $('#minimum_order_qty').val();
                    let qty = $('#qty').val();
                    if (stock_manage_status != 0) {
                        if (parseInt(qty) < parseInt(available_stock)) {
                            if(val == '+'){
                                if(maximum_order_qty != ''){
                                    if(parseInt(qty) < parseInt(maximum_order_qty)){
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                    }else{
                                        toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}');
                                    }
                                }else{
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                }


                            }
                            if(val == '-'){
                                if(minimum_order_qty != ''){
                                    if(parseInt(qty) > parseInt(minimum_order_qty)){
                                        if(qty>1){
                                            let qty1 = parseInt(--qty)
                                            $('#qty').val(qty1)
                                            totalValue(qty1, '#base_price','#total_price')
                                            $('.cart-qty-minus').prop('disabled',false);
                                        }else{
                                            $('.cart-qty-minus').prop('disabled',true);
                                        }
                                    }else{
                                        toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                    }
                                }else{
                                    if(parseInt(qty)>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_more_stock')}}", "{{__('common.error')}}");
                        }
                    }
                    else {
                        if(val == '+'){
                            if(maximum_order_qty != ''){
                                if(parseInt(qty) < parseInt(maximum_order_qty)){
                                let qty1 = parseInt(++qty);
                                $('#qty').val(qty1)
                                totalValue(qty1, '#base_price','#total_price');
                                }else{
                                    toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                let qty1 = parseInt(++qty);
                                $('#qty').val(qty1)
                                totalValue(qty1, '#base_price','#total_price');
                            }


                        }
                        if(val == '-'){
                            if(minimum_order_qty != ''){
                                if(parseInt(qty) > parseInt(minimum_order_qty)){
                                    if(qty>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }else{
                                    toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                if(parseInt(qty)>1){
                                    let qty1 = parseInt(--qty)
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price')
                                    $('.cart-qty-minus').prop('disabled',false);
                                }else{
                                    $('.cart-qty-minus').prop('disabled',true);
                                }
                            }
                        }
                    }

                }

                function totalValue(qty, main_price, total_price){


                    let base_sku_price = $('#base_sku_price').val();
                    let value = parseInt(qty) * parseFloat(base_sku_price);
                    $(total_price).html(currency_format(value));
                    $('#final_price').val(value);

                }

                function get_price_accordint_to_sku(){
                    var value = $("input[name='attr_val_name[]']").map(function(){return $(this).val();}).get();
                    var id = $("input[name='attr_val_id[]']").map(function(){return $(this).val();}).get();
                    var product_id = $("#product_id").val();
                    var user_id = $('#seller_id').val();
                    $.post('{{ route('seller.get_seller_product_sku_wise_price') }}', {_token:'{{ csrf_token() }}', id:id, product_id:product_id, user_id:user_id}, function(response){
                        if (response != 0) {
                            let discount_type = $('#discount_type').val();
                            let discount = $('#discount').val();
                            let qty = $('.qty').val();

                            calculatePrice(response.data.selling_price, discount, discount_type, qty);
                            $('#sku_id_li').text(response.data.sku.sku);
                            $('#product_sku_id').val(response.data.id);

                            $('#availability').html(response.data.product_stock);
                            if(parseInt(response.data.product_stock) >= parseInt(response.data.product.product.minimum_order_qty)){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }
                            else if(response.data.product.stock_manage == 0){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }

                            else{
                                $('#add_to_cart_div').html(`
                                    <button type="button" disabled class="btn_1">{{__('defaultTheme.out_of_stock')}}</button>
                                `);
                                toastr.warning("{{__('defaultTheme.out_of_stock')}}");
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_stock_found_for_this_seller')}}", "{{__('common.error')}}");
                        }
                    });
                }

                function calculatePrice(main_price, discount, discount_type, qty){
                    var main_price = main_price;
                    var discount = discount;
                    var discount_type = discount_type;
                    var total_price = 0;
                    if (discount_type == 0) {
                        discount = (main_price * discount) / 100;
                    }
                    total_price = (main_price - discount);

                    $('#total_price').html(currency_format((total_price * qty)));
                    
                    $('#base_sku_price').val(total_price);
                    $('#final_price').val(total_price);
                }


                $(document).on('click', '.add_to_wishlist', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    let type = 'product';
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                        $(this).addClass('is_wishlist');
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });

            });
        })(jQuery);


    </script>

@endpush



