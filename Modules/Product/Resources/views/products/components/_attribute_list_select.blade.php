
<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('product.attribute') }}</label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_attribute">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="choice_attributes[]" id="choice_attributes"
        class="primary_select mb-15 choice_attribute">
        <option value="" disabled selected>{{ __('product.select_attribute') }}</option>
        @foreach ($attributes as $key => $attribute)
            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
        @endforeach
    </select>
    <span class="text-danger">{{ $errors->first('choice_attributes') }}</span>
</div>