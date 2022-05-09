
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('review.seller.approve'))
            <a href="" data-id="{{$review->id}}" class="dropdown-item approve_single">{{ __('review.approve') }}</a>
        @endif
    </div>
</div>
