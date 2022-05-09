<div class="primary_input mb-15">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{__('ticket.priority')}} <span class="text-danger">*</span></label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_priority">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="priority_id" id="priority_id" class="primary_select mb-15">
        <option value="" selected disabled>{{__('common.select_one')}}</option>
        @foreach ($PriorityList as $key => $item)
            <option value="{{ $item->id }}" {{isset($editData->priority_id)? ($item->id == @$editData->priority_id? 'selected':''):''}}>{{ $item->name }} </option>
        @endforeach

    </select>
    @if ($errors->has('priority_id'))
    <span class="text-danger"  id="error_priority_id">{{ $errors->first('priority_id') }}</span>
    @endif
    
</div>