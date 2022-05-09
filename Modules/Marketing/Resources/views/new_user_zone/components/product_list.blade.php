
@php
    $product = \Modules\Seller\Entities\SellerProduct::findOrFail($product_id);
@endphp
<tr>
    <td>
        <div class="product_info">
            <div class="product_img_div">
                <img class="productImg" src="{{ showImage(@$product->product->thumbnail_image_source) }}" alt="">
            </div>
            <div class="product_name_div">
                <p class="text-nowrap">{{substr(@$product->product->product_name, 0, 30)}}</p>
                <input type="hidden" name="product[]" value="{{$product->id}}">
            </div>
        </div>
    </td>
    @if(isModuleActive('MultiVendor'))
    <td class="text-center">
        <div class="price_div">
            <p class="text-nowrap">@if($product->seller->role->type == 'seller'){{@$product->seller->first_name}} @else Inhouse @endif</p>
            <input type="hidden" id="product_check_{{$product->id}}">
        </div>
    </td>
    @endif
    <td class="text-center">
        <div class="price_div">
            <p class="text-nowrap">
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
                {{single_price(selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                @else

                    @if (selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount) === selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))
                        {{single_price(selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount))}}
                    @else
                        {{single_price(selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount))}} - {{single_price(selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))}}
                    @endif
                @endif
            @endif
            </p>
        </div>
    </td>
    <td class="text-center pl-16">
        <div class="price_div">
            <a class="product_delete_btn"><i class="ti-close"></i></a>
        </div>
    </td>
</tr>

