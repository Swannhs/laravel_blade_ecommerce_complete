
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
                <p class="text-nowrap">{{substr(@$product->product->product_name, 0, 40)}}</p>
                <input type="hidden" name="products[]" value="{{$product->id}}">
            </div>

        </div>
    </td>
    <td>
        <p class="priceDiv mt-25 ml-5 mr-5 text-nowrap">
        @if (@$product->product->product_type == 1)
        {{single_price(@$product->skus->max('selling_price'))}}
        @else
        {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
        @endif
        </p>
        <input type="hidden" name="price[]" value="{{single_price(@$product->skus->max('selling_price'))}}">
    </td>
    <td class="text-center pl-5 pr-5"><input class="primary_input_field mt-14" name="discount[]" id="discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{$product->discount}}" required></td>
    <td class="pl-5 pr-5">
        <div class="primary_input mt-14">
            <select class="primary_select mb-25 discount_type p_discount_type" name="discount_type[]">
                <option {{$product->discount_type ==1?'selected':''}}  value="1">{{ __('common.amount') }}</option>
                <option {{$product->discount_type ==0?'selected':''}}   value="0">{{ __('common.percentage') }}</option>
            </select>
        </div>
    </td>
    <td class="text-center pt-25">
        <a class="product_delete_btn" href=""><i class="ti-close"></i></a>
        <input type="hidden" id="product_{{$product->id}}">
    </td>
</tr>

