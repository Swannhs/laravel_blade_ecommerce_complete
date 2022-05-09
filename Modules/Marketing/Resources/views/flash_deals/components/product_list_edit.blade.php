@foreach($products as $key => $id)
@php
$product = \Modules\Seller\Entities\SellerProduct::findOrFail($id);
$flash_deal_product = \Modules\Marketing\Entities\FlashDealProduct::where('flash_deal_id',
$flash_deal_id)->where('seller_product_id', $product->id)->first();
@endphp
<tr>
    <td>
        <div class="product_info">
            <div class="product_img_div">
                <img class="productImg" src="{{ showImage($product->product->thumbnail_image_source) }}" alt="">
            </div>
            <div class="product_name_div">
                {{$product->product->product_name}}
                <input type="hidden" name="product_id[]" value="{{$product->id}}">
            </div>
        </div>

    </td>
    <td>
        @if ($product->product->product_type == 1)
        {{single_price($product->skus->max('selling_price'))}}
        @else
        {{single_price($product->skus->min('selling_price'))}} - {{single_price($product->skus->max('selling_price'))}}
        @endif
        <input type="hidden" name="price[]" value="{{single_price($product->skus->max('selling_price'))}}">
    </td>

    @if($flash_deal_product != null)
    <td class="text-center"><input class="primary_input_field" name="discount[]" id="discount" placeholder=""
            type="number" min="0" step="{{step_decimal()}}" value="{{$flash_deal_product->discount}}" required></td>
    <td>
        <div class="primary_input mb-25">
            <select class="primary_select mb-25 discount_type" name="discount_type[]" id="discount_type">
                <option {{$flash_deal_product->discount_type ==1?'selected':''}} value="1">{{ __('common.amount') }}
                </option>
                <option {{$flash_deal_product->discount_type ==0?'selected':''}} value="0">{{ __('common.percentage') }}
                </option>
            </select>
        </div>
    </td>
    @else
    <td class="text-center"><input class="primary_input_field" name="discount[]" id="discount" placeholder=""
            type="number" min="0" step="{{step_decimal()}}" value="{{$product->discount}}" required></td>
    <td>
        <div class="primary_input mb-25">
            <select class="primary_select mb-25 discount_type" name="discount_type[]" id="discount_type">
                <option {{$product->discount_type ==1?'selected':''}} value="1">{{ __('common.amount') }}</option>
                <option {{$product->discount_type ==0?'selected':''}} value="0">{{ __('common.percentage') }}</option>
            </select>
        </div>
    </td>
    @endif
</tr>
@endforeach
