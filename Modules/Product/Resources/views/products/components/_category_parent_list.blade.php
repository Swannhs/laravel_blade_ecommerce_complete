<div class="primary_input mb-25">
    <label class="primary_input_label" for="">{{ __('product.parent_category') }} <span class="text-danger">*</span></label>
    <select class="primary_select mb-25" name="parent_id" id="parent_id">
        @foreach($categories as $item)
            <option value="{{$item->id}}">{{ $item->name}}</option>
            @endforeach
    </select>
    
    <span class="text-danger"></span>
    
</div>