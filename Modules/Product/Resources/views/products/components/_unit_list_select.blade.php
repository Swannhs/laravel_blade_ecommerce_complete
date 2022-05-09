
<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('product.unit') }} <span class="text-danger">*</span></label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_unit">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="unit_type_id" id="unit_type_id" class="primary_select mb-15 unit"
        required="1">
        <option disabled selected>{{ __('product.select_unit') }}</option>
        @foreach ($units as $key => $unit)
            <option value="{{ $unit->id }}" @isset($product) @if ($product->unit_type_id == $unit->id) selected @endif @endisset>{{ $unit->name }}</option>
        @endforeach
    </select>
    <span class="text-danger" id="error_unit_type">{{ $errors->first('unit_type_id') }}</span>
</div>
