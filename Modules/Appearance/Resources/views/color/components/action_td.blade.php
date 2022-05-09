<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        @lang('common.select')
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a class="dropdown-item" href="{{ route('appearance.color.clone',$data->id)}}"> @lang('common.clone')</a>
        @if ($data->id != 1)
        <a class="dropdown-item" href="{{ route('appearance.color.edit',$data->id)}}"> @lang('common.edit')</a>
        @endif
        @if($data->is_active == 0 && $data->id != 1)
        <a class="dropdown-item delete-item" data-value="{{route('appearance.color.delete', $data->id)}}">@lang('common.delete')</a>
        @endif
    </div>
</div>
