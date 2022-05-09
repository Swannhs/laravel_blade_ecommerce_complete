
<div class="primary_input mb-25">
        <div class="double_label d-flex justify-content-between">
            <label class="primary_input_label" for="">{{ __('product.shipping_methods') }}
                <span class="text-danger">*</span></label>
            <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_shipping">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
        </div>
    <select class="primary_select mb-25" name="shipping_methods[]" id="shipping_methods" multiple>
        @foreach($shippings->where('id','>',1) as $key => $shipping)
        <option value="{{$shipping->id}}" @if(isset($product)) @if ($product->shippingMethods->where('shipping_method_id', $shipping->id)->first()) selected @endif @elseif ($key == 1) selected @endif>{{ $shipping->method_name }}</option>
        @endforeach
    </select>
    <span class="text-danger" id="error_shipping_method"></span>
</div>
