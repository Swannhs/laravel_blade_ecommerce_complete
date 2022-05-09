<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a href="{{ route('admin.giftcard.view', $card->id) }}" class="dropdown-item edit_brand">{{ __('common.view') }}</a>
        @if (permissionCheck('admin.giftcard.edit'))
            <a href="{{ route('admin.giftcard.edit', $card->id) }}" class="dropdown-item edit_brand">{{ __('common.edit') }}</a>
        @endif
        @if (permissionCheck('admin.giftcard.delete'))
            <a href="" class="dropdown-item delete_card" data-id="{{ $card->id }}">{{ __('common.delete') }}</a>
        @endif
    </div>
</div>
