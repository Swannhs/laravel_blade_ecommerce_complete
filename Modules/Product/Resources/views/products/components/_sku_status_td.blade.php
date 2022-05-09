@if ($skus->product->is_approved == '1')

    <label class="switch_toggle" for="checkboxx{{ $skus->id }}">
        <input type="checkbox" id="checkboxx{{ $skus->id }}" @if ($skus->status == 1) checked @endif @if (permissionCheck('product.sku.status')) value="{{ $skus->id }}" class="sku_status_change" data-id="{{ $skus->id }}" @else disabled @endif>
        <div class="slider round"></div>
    </label>

@else
    <span class="badge_2">{{ __('common.not_approved') }}</span>

@endif
