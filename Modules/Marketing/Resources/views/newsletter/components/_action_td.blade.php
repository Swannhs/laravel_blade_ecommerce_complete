<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('marketing.news-letter.edit'))
            @if($message->is_send == 0)
            <a href="{{route('marketing.news-letter.edit',$message->id)}}" class="dropdown-item edit_brand">{{ __('common.edit') }}</a>
            @endif
        @endif
        @if (permissionCheck('marketing.news-letter.delete'))
            <a href="javascript:void(0)" class="dropdown-item delete_mail" data-id="{{$message->id}}">{{ __('common.delete') }}</a>
        @endif
    </div>
</div>
