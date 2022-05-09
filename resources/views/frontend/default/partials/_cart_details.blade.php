    @php
        $all_select_count = 0;
        $subtotal = 0;
        $discount = 0;
        $actual_price = 0;
        $shipping_cost = 0;
        $sellect_seller = 0;
        $selected_product_check  = 0;

        foreach ($cartData as $key => $items) {
            $all_select_count += count($items);
            $sellect_seller  = $key;
            $p = 0;
            foreach ($items as $key => $data) {
                if ($data->is_select == 1) {
                    $all_select_count = $all_select_count - 1;
                    $selected_product_check ++;
                    $p = 1;
                }
            }
            if($p == 1){
                $shipping_cost += 20;

            }
        }
    @endphp
    
    <div class="checkout_v3_area">
        <form id="cart_form">
        <div class="checkout_v3_left d-flex justify-content-end">
            @if(count($cartData) > 0)
            
            <div class="checkout_v3_inner w-100">
                <div class="checout_head_title d-flex align-items-center ">
                    <span class="checout_head_title_text">{{__('common.products')}}</span>
                    <span>{{__('common.price')}}</span>
                    <span>{{__('common.quantity')}}</span>
                    <span>{{__('common.subtotal')}}</span>
                </div>
                @if(!isModuleActive('MultiVendor'))
                    <div class="checout_shiped_products p-0">
                        @foreach($cartData as $admin_id => $items)
                            @foreach($items as $key => $cart)
                                @if($cart->product_type == 'product')
                                    @if($cart->is_select == 1)
                                        @php
                                            $subtotal += $cart->product->selling_price * $cart->qty;
                                        @endphp
                                    @endif
                                    <div class="single_checkout_shiped_product d-flex align-items-center">
                                        
                                        <div class="product_information d-flex align-items-center">
                                            <div class="thumb">
                                                <img src="
                                                    @if(@$cart->product->product->product->product_type == 1)
                                                    {{asset(asset_path(@$cart->product->product->product->thumbnail_image_source))}}
                                                    @else
                                                    {{asset(asset_path(@$cart->product->sku->variant_image?@$cart->product->sku->variant_image:@$cart->product->product->product->thumbnail_image_source))}}
                                                    @endif
                                                " alt="">
                                            </div>
                                            <div class="product_content">
                                                <p><a href="{{route('frontend.item.show',@$cart->product->product->slug)}}">{{ \Illuminate\Support\Str::limit(@$cart->product->product->product_name, 30, $end='...') }}</a></p>
                                                <span>
                                                    @if(@$cart->product->product->product->product_type == 2)

                                                        @foreach(@$cart->product->product_variations as $key => $combination)
                                                            @if(@$combination->attribute->name == 'Color')
                                                                {{@$combination->attribute->name}}: {{@$combination->attribute_value->color->name}}
                                                            @else
                                                                {{@$combination->attribute->name}}: {{@$combination->attribute_value->value}}
                                                            @endif
                                                            @if($key < count(@$cart->product->product_variations)-1),@endif

                                                        @endforeach

                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="offer_prise">
                                            @if($cart->product->product->hasDeal)
                                                @if($cart->product->product->hasDeal->discount > 0)
                                                    @if($cart->product->product->hasDeal->discount_type == 0)
                                                        <span class="prise_offer">-{{$cart->product->product->hasDeal->discount}}%</span>
                                                        <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                    @else
                                                        <span class="prise_offer">-{{single_price($cart->product->product->hasDeal->discount)}}</span>
                                                        <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                    @endif
                                                @endif
                                            @else
                                                @if(@$cart->product->product->hasDiscount == 'yes')
                                                    @if($cart->product->product->discount_type == 0)
                                                        <span class="prise_offer">-{{$cart->product->product->discount}}%</span>
                                                        <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                    @else
                                                        <span class="prise_offer">-{{single_price($cart->product->product->discount)}}</span>
                                                        <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                    @endif
                                                @else
                                                    <span class="prise_main">{{single_price($cart->product->selling_price)}}</span>
                                                @endif

                                            @endif
                                        </div>
                                        
                                        <div class="product_count">
                                            <input type="text" name="qty[]" id="qty_{{$cart->id}}" class="qty" maxlength="12" value="{{$cart->qty}}" class="input-text qty" readonly/>
                                            <input type="hidden" value="{{$cart->id}}" name="cart_id[]">
                                            <input type="hidden" id="maximum_qty_{{$cart->id}}" value="{{$cart->product->product->product->max_order_qty}}">
                                            <input type="hidden" id="minimum_qty_{{$cart->id}}" value="{{$cart->product->product->product->minimum_order_qty}}">
                                            <div class="button-container">
                                                <button class="cart-qty-plus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                     data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="+"><i class="ti-plus"></i></button>
                                                <button class="cart-qty-minus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                     data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="-"><i class="ti-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="total_prise d-flex align-items-center">
                                            <span>{{single_price($cart->total_price)}}</span>
                                            <i class="ti-trash cart_item_delete_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-unique_id="#delete_item_{{$cart->id}}" id="delete_item_{{$cart->id}}"></i>
                                        </div>
                                    </div>
                                @else
                                    @if($cart->is_select == 1)
                                        @php
                                            $subtotal += $cart->giftCard->selling_price * $cart->qty;
                                        @endphp
                                    @endif
                                    <div class="single_checkout_shiped_product d-flex align-items-center">
                                        
                                        <div class="product_information d-flex align-items-center flex-fill">
                                            <div class="thumb">
                                                <img src="{{asset(asset_path(@$cart->giftCard->thumbnail_image))}}" alt="">
                                            </div>
                                            <div class="product_content">
                                                <p><a href="{{route('frontend.gift-card.show',$cart->giftCard->sku)}}">{{ \Illuminate\Support\Str::limit(@$cart->giftCard->name, 30, $end='...') }}</a></p>
                                            </div>
                                        </div>
                                        <div class="offer_prise">
                                            @if($cart->giftCard->hasDiscount())
                                                @if($cart->giftCard->discount_type == 0)
                                                    <span class="prise_offer">-{{$cart->giftCard->discount}}%</span>
                                                @else
                                                    <span class="prise_offer">-{{$cart->giftCard->discount}}</span>
                                                @endif
                                                <span class="prise_main">{{$cart->giftCard->selling_price}}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="product_count">
                                            <input type="text" name="qty[]" id="qty_{{$cart->id}}" class="qty" maxlength="12" value="{{$cart->qty}}" class="input-text qty" readonly/>
                                            <input type="hidden" value="{{$cart->id}}" name="cart_id[]">
                                            <input type="hidden" id="maximum_qty_{{$cart->id}}" value="">
                                            <input type="hidden" id="minimum_qty_{{$cart->id}}" value="1">
                                            <div class="button-container">
                                                <button class="cart-qty-plus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                     data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="0" data-stock_manage="0" type="button" value="+"><i class="ti-plus"></i></button>
                                                <button class="cart-qty-minus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                     data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="0" data-stock_manage="0" type="button" value="-"><i class="ti-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="total_prise d-flex align-items-center">
                                            <span>{{single_price($cart->total_price)}}</span>
                                            <i class="ti-trash cart_item_delete_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-unique_id="#delete_item_{{$cart->id}}" id="delete_item_{{$cart->id}}"></i>
                                        </div>
                                    </div>
                                @endif
                                @if($cart->is_select == 1)
                                    @php
                                        $actual_price += $cart->total_price;
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                @else
                    @foreach($cartData as $seller_id => $cartItems)
                        @php
                            $seller = App\Models\User::where('id',$seller_id)->first();
                            $select_count = count($cartItems);
                        @endphp
                        @foreach($cartItems as $m => $data)
                            @php
                                if($data->is_select == 1){
                                        $select_count = $select_count - 1;
                                    }else{
                                        $select_count = $select_count;
                                    }
                            @endphp
                        @endforeach
                        <div class="checkout_shiped_box">
                            <div class="checout_shiped_head flex-wrap d-flex align-items-center ">
                                <span class="package_text flex-fill"><a href="@if($seller->slug) {{route('frontend.seller',$seller->slug)}} @else {{route('frontend.seller',base64_encode($seller->id))}} @endif"><h6 class="f_s_16 f_w_600 mb-1" >@if($seller->role->type == 'seller') {{$seller->first_name .' '.$seller->last_name}} @else {{ app('general_setting')->company_name }} @endif <i class="ti-angle-right"></i> </h6></a></span>
                                
                            </div>
                            
                            <div class="checout_shiped_products">
                                @foreach($cartItems as $key => $cart)
                                    @if($cart->product_type == 'product')
                                        @if($cart->is_select == 1)
                                        @php
                                            $subtotal += $cart->product->selling_price * $cart->qty;
                                        @endphp
                                        @endif
                                        <div class="single_checkout_shiped_product d-flex align-items-center">
                                            <div class="product_information d-flex align-items-center flex-fill">
                                                <div class="thumb">
                                                    <img src="
                                                        @if(@$cart->product->product->product->product_type == 1)
                                                        {{asset(asset_path(@$cart->product->product->product->thumbnail_image_source))}}
                                                        @else
                                                        {{asset(asset_path(@$cart->product->sku->variant_image?@$cart->product->sku->variant_image:@$cart->product->product->product->thumbnail_image_source))}}
                                                        @endif
                                                    " alt="">
                                                </div>
                                                <div class="product_content">
                                                    <p><a href="{{route('frontend.item.show',@$cart->product->product->slug)}}">{{ \Illuminate\Support\Str::limit(@$cart->product->product->product_name, 22, $end='...') }}</a></p>
                                                    <span>
                                                        @if(@$cart->product->product->product->product_type == 2)
    
                                                            @foreach(@$cart->product->product_variations as $key => $combination)
                                                                @if(@$combination->attribute->name == 'Color')
                                                                    {{@$combination->attribute->name}}: {{@$combination->attribute_value->color->name}}
                                                                @else
                                                                    {{@$combination->attribute->name}}: {{@$combination->attribute_value->value}}
                                                                @endif
                                                                @if($key < count(@$cart->product->product_variations)-1),@endif
    
                                                            @endforeach
    
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="offer_prise">
                                                @if($cart->product->product->hasDeal)
                                                    @if($cart->product->product->hasDeal->discount > 0)
                                                        @if($cart->product->product->hasDeal->discount_type == 0)
                                                            <span class="prise_offer">-{{$cart->product->product->hasDeal->discount}}%</span>
                                                            <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                        @else
                                                            <span class="prise_offer">-{{single_price($cart->product->product->hasDeal->discount)}}</span>
                                                            <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if(@$cart->$product->product->hasDiscount == 'yes')
                                                        @if($cart->product->product->discount_type == 0)
                                                            <span class="prise_offer">-{{$cart->product->product->discount}}%</span>
                                                            <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                        @else
                                                            <span class="prise_offer">-{{single_price($cart->product->product->discount)}}</span>
                                                            <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                        @endif
                                                    @else
                                                        <span class="prise">{{single_price($cart->product->selling_price)}}</span>
                                                    @endif
    
                                                @endif
                                            </div>
                                            
                                            <div class="product_count">
                                                <input type="text" name="qty[]" id="qty_{{$cart->id}}" class="qty" maxlength="12" value="{{$cart->qty}}" class="input-text qty" readonly/>
                                                <input type="hidden" value="{{$cart->id}}" name="cart_id[]">
                                                <input type="hidden" id="maximum_qty_{{$cart->id}}" value="{{$cart->product->product->product->max_order_qty}}">
                                                <input type="hidden" id="minimum_qty_{{$cart->id}}" value="{{$cart->product->product->product->minimum_order_qty}}">
                                                <div class="button-container">
                                                    <button class="cart-qty-plus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                         data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="+"><i class="ti-plus"></i></button>
                                                    <button class="cart-qty-minus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                         data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="-"><i class="ti-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="total_prise d-flex align-items-center">
                                                <span>{{single_price($cart->total_price)}}</span>
                                                <i class="ti-trash cart_item_delete_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-unique_id="#delete_item_{{$cart->id}}" id="delete_item_{{$cart->id}}"></i>
                                            </div>
                                        </div>
                                    @else
                                        @if($cart->is_select == 1)
                                            @php
                                                $subtotal += $cart->giftCard->selling_price * $cart->qty;
                                            @endphp
                                        @endif
                                        <div class="single_checkout_shiped_product d-flex align-items-center">
                                            
                                            <div class="product_information d-flex align-items-center flex-fill">
                                                <div class="thumb">
                                                    <img src="{{asset(asset_path(@$cart->giftCard->thumbnail_image))}}" alt="">
                                                </div>
                                                <div class="product_content">
                                                    <p><a href="{{route('frontend.gift-card.show',$cart->giftCard->sku)}}">{{ \Illuminate\Support\Str::limit(@$cart->giftCard->name, 22, $end='...') }}</a></p>
                                                </div>
                                            </div>
                                            <div class="offer_prise">
                                                @if($cart->giftCard->hasDiscount())
                                                    @if($cart->giftCard->discount_type == 0)
                                                        <span class="prise_offer">-{{$cart->giftCard->discount}}%</span>
                                                    @else
                                                        <span class="prise_offer">-{{$cart->giftCard->discount}}</span>
                                                    @endif
                                                    <span class="prise">{{single_price($cart->giftCard->selling_price)}}</span>
                                                @else
                                                    <span class="prise_main">{{single_price($cart->giftCard->selling_price)}}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="product_count">
                                                <input type="text" name="qty[]" id="qty_{{$cart->id}}" class="qty" maxlength="12" value="{{$cart->qty}}" class="input-text qty" readonly/>
                                                <input type="hidden" value="{{$cart->id}}" name="cart_id[]">
                                                <input type="hidden" id="maximum_qty_{{$cart->id}}" value="">
                                                <input type="hidden" id="minimum_qty_{{$cart->id}}" value="1">
                                                <div class="button-container">
                                                    <button class="cart-qty-plus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                         data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="0" data-stock_manage="0" type="button" value="+"><i class="ti-plus"></i></button>
                                                    <button class="cart-qty-minus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                                         data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="0" data-stock_manage="0" type="button" value="-"><i class="ti-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="total_prise d-flex align-items-center">
                                                <span>{{single_price($cart->total_price)}}</span>
                                                <i class="ti-trash cart_item_delete_btn" data-id="{{$cart->id}}" data-product_id="{{$cart->product_id}}" data-unique_id="#delete_item_{{$cart->id}}" id="delete_item_{{$cart->id}}"></i>
                                            </div>
                                        </div>
                                    @endif
                                    @if($cart->is_select == 1)
                                        @php
                                            $actual_price += $cart->total_price;
                                        @endphp
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="check_v3_btns flex-wrap d-flex align-items-center mt-25 gap_10 ">
                    <div class="d-flex align-items-center gap_10 flex-fill">
                        <button type="submit" class="btn_2 m-0 text-uppercase cursor_pointer">{{__('common.update')}} {{__('common.cart')}}</button>
                    <a class="btn_2 m-0 text-uppercase cursor_pointer" href="{{url('/')}}">{{__('defaultTheme.continue_shopping')}}</a>
                    </div>
                    <a class="btn_1 m-0 text-uppercase cursor_pointer @if (count($cartData) > 0) process_to_checkout_check @endif" data-value="{{$selected_product_check}}">{{__('defaultTheme.proceed_to_checkout')}}</a>
                </div>
                
            </div>
            
            @else
                <div class="col-lg-12 text-center">
                    <span class="product_not_found">{{ __('defaultTheme.no_product_found') }}</span>
                </div>
            @endif
        </div>
        </form>
        @php
            $grand_total = $actual_price;
            $discount = $subtotal -$actual_price;
        @endphp
        <div class="checkout_v3_right d-flex justify-content-start">
            <div class="order_sumery_box flex-fill">
                <h3 class="check_v3_title mb_25">{{__('common.order_summary')}}</h3>
                <div class="subtotal_lists">
                    <div class="single_total_list d-flex align-items-center">
                        <div class="single_total_left flex-fill">
                            <h4 >{{ __('common.subtotal') }}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>+ {{single_price($subtotal)}}</span>
                        </div>
                    </div>
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.shipping_charge')}}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>{{__('defaultTheme.calculated_at_next_step')}}</span>
                        </div>
                    </div>
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.discount')}}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>- {{single_price($discount)}}</span>
                        </div>
                    </div>
                    <div class="single_total_list d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <h4>{{__('common.tax')}}/{{__('gst.gst')}}</h4>
                        </div>
                        <div class="single_total_right">
                            <span>{{__('defaultTheme.calculated_at_next_step')}}</span>
                        </div>
                    </div>
                    <div class="total_amount d-flex align-items-center flex-wrap">
                        <div class="single_total_left flex-fill">
                            <span class="total_text">{{__('common.total')}}</span>
                        </div>
                        <div class="single_total_right">
                            <span class="total_text"><span>{{single_price($grand_total)}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.default.partials._delete_modal_for_ajax',['item_name' => __('product.cart_product'),'modal_id' => 'deleteProductModalAll',
        'form_id' => 'product_delete_form_all','delete_item_id' => 'delete_product_id_all','dataDeleteBtn' =>'productDeleteBtnAll'])
    </div>