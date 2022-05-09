<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('product.brand') }}</label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_brand">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="brand_id" id="brand_id" class="primary_select mb-15 brand">
        <option disabled selected>{{ __('product.select_brand') }}</option>
        @foreach ($brands as $key => $brand)
            <option value="{{ $brand->id }}" @isset($product) @if ($product->brand_id == $brand->id) selected @endif @endisset>{{ $brand->name }}</option>
        @endforeach
    </select>
    <span class="text-danger">{{ $errors->first('brand_id') }}</span>
</div>
