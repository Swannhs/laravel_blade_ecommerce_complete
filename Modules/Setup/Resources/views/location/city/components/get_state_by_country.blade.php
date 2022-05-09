
<label class="primary_input_label" for="">{{ __('common.state') }} {{ __('common.list') }}</label>
    <select name="state" id="state" class="primary_select mb-15">
        <option value="" selected disabled>{{__('common.select_one')}}</option>
        @foreach($states as $key => $state)
            <option value="{{$state->id}}">{{$state->name}}</option>
        @endforeach
    </select>
<span class="text-danger"  id="error_state"></span>