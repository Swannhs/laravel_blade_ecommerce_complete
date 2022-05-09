

<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('common.category_list') }} <span class="text-danger">*</span></label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_category">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="category_id" id="category_id" class="primary_select mb-15">
        <option value="" selected disabled>{{__('common.select_one')}}</option>
        @foreach ($CategoryList as $key => $item)
            <option value="{{ $item->id }}" {{isset($editData->category_id) != null ? ($item->id == @$editData->category_id? 'selected':''):''}}>{{ $item->name }} </option>
        @endforeach

    </select>
    @if ($errors->has('category_id'))
    <span class="text-danger"  id="error_category_id">{{ $errors->first('category_id') }}</span>
    @endif
</div>