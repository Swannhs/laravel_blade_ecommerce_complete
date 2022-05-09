
<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('common.status') }} <span class="text-danger">*</span></label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_status">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    
    <select name="status" id="status" class="primary_select mb-15">
        <option value="" selected disabled>{{__('common.select_one')}}</option>
        @foreach ($StatusList as $key => $status)
            <option value="{{ $status->id }}" {{ isset($editData)? $editData->status->id == $status->id ? 'selected':'':'' }}>{{ $status->name }} </option>
        @endforeach

    </select>
    @if ($errors->has('status'))
    <span class="text-danger"  id="error_status">{{ $errors->first('status') }}</span>
    @endif
</div>