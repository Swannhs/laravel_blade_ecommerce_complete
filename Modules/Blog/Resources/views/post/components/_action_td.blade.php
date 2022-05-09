<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        @lang('common.select')
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a class="dropdown-item" href="{{ route('blog.posts.show',$value->id)}}"> @lang('common.show')</a>
        @if(permissionCheck('blog.posts.edit'))
            <a class="dropdown-item" href="{{ route('blog.posts.edit',$value->id)}}"> @lang('common.edit')</a>
        @endif

        @if(permissionCheck('blog.posts.delete'))
            <a class="dropdown-item delete_post" data-id="{{$value->id}}">@lang('common.delete')</a>
        @endif
    </div>
</div>
