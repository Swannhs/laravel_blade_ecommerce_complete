<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('marketing.bulk-sms.edit'))
            @if($message->is_send == 0)
            <a data-id="{{$message->id}}" class="dropdown-item edit_sms">{{ __('common.edit') }}</a>
            @endif
        @endif
        @if (permissionCheck('marketing.bulk-sms.delete'))
            <a class="dropdown-item delete_sms" data-id="{{$message->id}}">{{ __('common.delete') }}</a>
        @endif

    </div>
</div>
