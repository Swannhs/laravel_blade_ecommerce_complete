<div class="dropdown CRM_dropdown">
    <button type="button" class="btn dropdown-toggle"
        data-toggle="dropdown">
        @lang('common.select')
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @if (permissionCheck('blog.tags.edit'))
            <a class="dropdown-item" href="{{ route('blog.tags.edit', $value->id) }}"> @lang('common.edit')</a>
        @endif
        @if (permissionCheck('blog.tags.destroy'))
            <a class="dropdown-item delete_tag" data-id="{{$value->id}}">@lang('common.delete')</a>
        @endif
    </div>
</div>
