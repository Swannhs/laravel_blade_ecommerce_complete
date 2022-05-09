@php
    $items = 0;
    foreach($carts as $cart){
        if(auth()->check()){
            $items += $cart->qty;
        }else{
            $items += $cart['qty'];
        }
    }

    $base_url = url('/');
    $current_url = url()->current();
    $just_path = trim(str_replace($base_url,'',$current_url));

@endphp
<a href="javascript:void(0);" class="cart_menu_item">
    <i class="ti-bag"><span>{{$items}}</span></i> {{ __('common.cart') }}</a>
<div class="cart_iner cart_for_inner">
    <div class="all_product_cart_submenu">
    @php
    $subtotal = 0;
    @endphp

    @foreach ($carts as $key => $cart)
        @php
            $subtotal += $cart->price * $cart->qty;
        @endphp
        @if ($cart->product_type == "gift_card")
            <div class="single_product media">
                <div class="cart_data_img_div">
                    <img class="" src="{{asset(asset_path(@$cart->giftCard->thumbnail_image))}}" alt="#" />
                </div>
                <div class="media-body">
                    <a class="d-block" href="{{route('frontend.gift-card.show',$cart->giftCard->sku)}}">{{$cart->giftCard->name}}</a>

                    <span>{{single_price($cart->price)}} x {{$cart->qty}}</span>
                    <div class="close_icon">
                        @if($just_path != '/checkout')
                        <button type="button" class="transfarent-btn" id="submenu_cart_btn_{{$cart->id}}"><i class="ti-close text-white remove_from_submenu_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-btn="#submenu_cart_btn_{{$cart->id}}"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="single_product media">
                <div class="cart_data_img_div">
                    <img class="" src="
                        @if(@$cart->product->product->product->product_type == 1)
                            {{asset(asset_path(@$cart->product->product->product->thumbnail_image_source))}}
                        @else
                            {{asset(asset_path(@$cart->product->sku->variant_image?@$cart->product->sku->variant_image:@$cart->product->product->product->thumbnail_image_source))}}
                        @endif
                        " alt="#" />
                </div>
                <div class="media-body">
                    <a class="d-block" href="{{route('frontend.item.show',$cart->product->product->slug)}}">{{$cart->product->product->product->product_name}}</a>
                    @if($cart->product->product->product->product_type == 2)
                        <p>
                            @php
                                $countCombinatiion = count(@$cart->product->product_variations);
                            @endphp
                            @foreach($cart->product->product_variations as $key => $combination)
                                @if($combination->attribute->name == 'Color')
                                {{$combination->attribute->name}}: {{$combination->attribute_value->color->name}}
                                @else
                                {{$combination->attribute->name}}: {{$combination->attribute_value->value}}
                                @endif

                                @if($countCombinatiion > $key +1)
                                ,
                                @endif
                            @endforeach


                        </p>
                    @endif
                    <span>{{single_price($cart->price)}} x {{$cart->qty}}</span>
                    <div class="close_icon">
                        @if($just_path != '/checkout')
                        <button type="button" class="transfarent-btn" id="submenu_cart_btn_{{$cart->id}}"><i class="ti-close text-white remove_from_submenu_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-btn="#submenu_cart_btn_{{$cart->id}}"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>


    <div class="total_price d-flex align-items-center justify-content-between">
        <p>{{ __('common.subtotal') }}</p>
        <span>{{ single_price($subtotal) }}</span>
    </div>
    <a href="{{ route('frontend.shopping_from_recent_viewed') }}" class="btn_2">{{ __('defaultTheme.continue_shopping') }}</a>
    <a href="{{ route('frontend.cart') }}" class="btn_1">{{ __('defaultTheme.view_shopping_cart') }}</a>

</div>
