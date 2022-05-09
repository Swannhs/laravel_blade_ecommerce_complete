<div class="dropdown CRM_dropdown">
    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
        @lang('common.select')
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @if(permissionCheck('tags.edit'))
        <a class="dropdown-item edit_tag" data-value="{{$value}}" type="button">{{__('common.edit')}}</a>
        @endif
        @if(permissionCheck('tags.destroy'))
        <a class="dropdown-item"
            onclick="confirm_modal('{{route('tags.destroy', $value->id)}}');">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
