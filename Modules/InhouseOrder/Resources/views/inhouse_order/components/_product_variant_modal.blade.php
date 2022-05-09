

<div class="modal fade theme_modal" id="theme_modal" tabindex="-1" role="dialog" aria-labelledby="theme_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="product_quick_view ">
                    <button type="button" class="close_modal_icon" data-dismiss="modal">
                        <i class="ti-close"></i>
                    </button>
                    <div class="product_details_img">
                        <div class="tab-content tab_content" id="myTabContent">
                            @if($product->product->gallary_images->count())
                                @foreach($product->product->gallary_images as $image)
                                    <div class="tab-pane fade {{$product->product->gallary_images->first()->id == $image->id?'show active':''}}" id="thumb_{{$image->id}}" role="tabpanel">
                                        <div class="product_img_div">
                                            <img src="{{showImage($image->images_source)}}" alt="#" class="img-fluid var_img_show" />
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="tab-pane fade show active"
                                    id="thumb_{{$product->id}}" role="tabpanel">
                                    <div class="product_img_div">
                                    <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="#"
                                        class="img-fluid var_img_show" />
                                    </div>

                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="product_details_wrapper">
                    <div class="product_details">
                        @foreach($product->product->categories as $key => $category)
                        <a href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}" class="product_details_btn_iner">{{$category->name}}</a>
                        @endforeach
                    <div class="tittle">
                        <h2>{{$product->product->product_name}}</h2>
                    </div>
                    <div class="product_details_review d-flex">
                        <div class="review_icon">
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
                                        {{single_price(selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                                    @else
                                        {{single_price($product->skus->first()->selling_price)}}
                                    @endif
                                @else
                                    @if($product->hasDiscount == 'yes')
                                        @if (selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount) === selling_price($product->skus->max('selling_price'),$product->discount_type,$product->discount))
                                            {{single_price(selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount))}}
                                        @else
                                            {{single_price(selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount))}} - {{single_price(selling_price($product->skus->max('selling_price'),$product->discount_type,$product->discount))}}
                                        @endif
                                    @else
                                        @if ($product->skus->min('selling_price') === $product->skus->max('selling_price'))
                                            {{single_price($product->skus->min('selling_price'))}}
                                        @else
                                            {{single_price($product->skus->min('selling_price'))}} - {{single_price($product->skus->max('selling_price'))}}
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </h2>
                        <span>{{$product->discount>0?single_price($product->skus->max('selling_price')):''}}</span>

                        <input type="hidden" name="product_sku_id" id="product_sku_id" value="{{$product->product->product_type == 1?$product->skus->first()->id : $product->skus->first()->id}}">
                        <input type="hidden" name="seller_id" id="seller_id" value="{{$product->user_id}}">
                        <input type="hidden" name="stock_manage_status" id="stock_manage_status" value="{{$product->stock_manage}}">
                        <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="maximum_order_qty" value="{{@$product->product->max_order_qty}}">
                        <input type="hidden" id="minimum_order_qty" value="{{@$product->product->minimum_order_qty}}">
                    </div>
                    @if ($product->stock_manage == 0)
                        <p id="availability" class="d-none">{{__('defaultTheme.unlimited')}}</p>
                    @endif
                    @if(isModuleActive('MultiVendor'))
                    <div class="single_details_content d-flex mb-2">
                        <h5 class="mb-0">{{__('defaultTheme.sold_by')}}:</h5>
                        @if ($product->seller->slug)
                        <a href="{{route('frontend.seller',$product->seller->slug)}}" class="product_details_btn_iner">
                            @if (@$product->seller->SellerAccount->seller_shop_display_name)
                                {{ @$product->seller->SellerAccount->seller_shop_display_name }}
                            @else
                                {{$product->seller->first_name .' '.$product->seller->last_name}}
                            @endif
                        </a>
                        @else
                        <a href="{{route('frontend.seller',base64_encode($product->seller->id))}}" class="product_details_btn_iner">
                            @if (@$product->seller->SellerAccount->seller_shop_display_name)
                                {{ @$product->seller->SellerAccount->seller_shop_display_name }}
                            @else
                                {{$product->seller->first_name .' '.$product->seller->last_name}}
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
                            <li>{{__('defaultTheme.condition')}} : <span>{{__('common.new')}}</span></li>
                        </ul>
                        <ul>
                            <li>{{__('defaultTheme.sku')}}: <span id="sku_id_li">{{$product->skus->first()->sku->sku}}</span></li>
                            <li>{{__('common.category')}} :
                                @php
                                    $cates = count($product->product->categories);
                                @endphp
                                @foreach($product->product->categories as $key => $category)
                                <span>{{$category->name}}</span></li>
                                @if($key + 1 < $cates), @endif
                                @endforeach
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
                                            <a class="attr_val_name @if ($m === 0) selected_btn @endif" color="not" data-value-key="{{$item['attr_id']}}" data-value="{{ $item['id'][$m] }}">{{ $value_name }}</a>
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
                                        <div class="variant_img_div">
                                            <img src="{{showImage($sku->sku->variant_image)}}" alt="#" class="p-1 var_img_source" title="{{ $sku->sku->sku }}"/>
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
                                    <button class="cart-qty-plus qtyChangePlus" type="button" value="+">
                                        <i class="ti-plus"></i>
                                    </button>
                                    <button class="cart-qty-minus qtyChangeMinus" type="button" value="-">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_type" class="product_type" value="{{ $product->product->product_type }}">


                        @if($product->product->product_type == 2)
                            @foreach (session()->get('item_details') as $key => $item)

                                @if ($item['name'] == "Color")
                                <div class="single_details_content d-md-flex pl-0">
                                <div class="details_text d-flex">
                                    <h4>{{ $item['name'] }}:</h4>
                                    <div class="cs_color_btn">

                                        <div class="cs_radio_btn">
                                            <input type="hidden" class="attr_value_name" name="attr_val_name[]" value="{{$item['value'][0]}}">
                                            <input type="hidden" class="attr_value_id" name="attr_val_id[]" value="{{$item['id'][0]}}-{{$item['attr_id']}}">
                                            @foreach ($item['value'] as $k => $value_name)
                                                <div class="radio modal_colors_{{$k}} class_color_{{ $item['code'][$k] }}">
                                                    <input id="radio-{{$k}}_modal" name="radio" type="radio" color="color" class="attr_val_name attr_clr @if ($k === 0) selected_btn @endif" data-value="{{ $item['id'][$k] }}" data-value-key="{{$item['attr_id']}}" value="{{ $value_name }}"/>
                                                    <label for="radio-{{$k}}_modal" class="radio-label"></label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                </div>
                                @endif

                            @endforeach
                        @endif

                    <div class="single_details_content mt_30 d-md-flex">
                        <h5>{{__('defaultTheme.shipping')}}:</h5>
                        <div class="details_content_iner">
                            <select name="shipping_type" id="shipping_type" class="select_address">
                                @foreach(@$product->product->shippingMethods as $key => $method)

                                <option value="{{@$method->shippingMethod->id}}">
                                    {{@$method->shippingMethod->method_name}} - {{single_price(@$method->shippingMethod->cost)}} ({{@$method->shippingMethod->shipment_time}})
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="single_details_content d-flex">
                        <input type="hidden" name="base_sku_price" id="base_sku_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                                {{ selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount) }}
                            @else
                                {{ $product->skus->first()->selling_price }}
                            @endif
                        @endif
                        ">
                        <input type="hidden" name="final_price" id="final_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                                {{ selling_price($product->skus->first()->selling_price,$product->discount_type,$product->discount) }}
                            @else
                                {{ $product->skus->first()->selling_price }}
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
                            <p class="out_of_stock">{{__('defaultTheme.out_of_stock')}}</p>
                        @endif
                        </span>

                    </div>
                    <div class="single_details_content social_icon d-flex">
                        <h5 class="mb-0">{{__('defaultTheme.share_on')}}:</h5>
                        <div class="social_icon_iner">
                            <a href="{{ Share::currentPage()->facebook()->getRawLinks() }}" target="_blank"><i class="ti-facebook"></i></a>
                            <a href="{{ Share::currentPage()->twitter()->getRawLinks() }}" target="_blank"><i class="ti-twitter-alt"></i></a>
                            <a href="{{ Share::currentPage()->linkedin()->getRawLinks() }}" target="_blank"><i class="ti-linkedin"></i></a>
                            <a href="{{ Share::currentPage()->whatsapp()->getRawLinks() }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="{{ Share::currentPage()->telegram()->getRawLinks() }}" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                            <a href="{{ Share::currentPage()->reddit()->getRawLinks() }}" target="_blank"><i class="ti-reddit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<input type="hidden" id="currency_symbol" value="@if(session()->get('currency')) {{session()->get('currency')}} @else {{app('general_setting')->currency_symbol}} @endif">
<input type="hidden" id="currency_rate" value="@if(session()->get('currency')) {{session()->get('convert_rate')}} @else 1 @endif">

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
                                $(".modal_colors_{{$k}}").css("background-color", "{{ $item['code'][$k]}}");
                            '@endforeach'+
                        '@endif'+
                    '@endforeach'+
                '@endif'
            }
        });
    })(jQuery);
</script>

