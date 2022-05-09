<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('review.product.approve'))
            <a href="" data-id="{{$review->id}}" class="dropdown-item approve_single">{{ __('review.approve') }}</a>
        @endif
        @if (permissionCheck('review.product.approve-all'))
            <a href="" class="dropdown-item approve_all" onclick="">{{ __('review.approve_all') }}</a>
        @endif
        @if (permissionCheck('review.product.delete'))
            <a href="" data-id="{{$review->id}}" class="dropdown-item delete_review" onclick="">{{ __('review.deny') }}</a>
        @endif
    </div>
</div>
