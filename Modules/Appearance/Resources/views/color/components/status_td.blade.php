@if ($data->is_active)
<button class="primary-btn tr-bg" disabled href="{{route('appearance.color.index')}}"
    dusk="Add New">{{__('common.activated')}}</button>
@else
<a class="primary-btn radius_30px mr-10 fix-gr-bg text-white activate_post" data-id="{{$data->id}}"> @lang('common.activate')</a>
@endif
