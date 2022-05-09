@if($type == "superadmin" || $type == "admin" || $type == "staff")
<label class="switch_toggle" for="checkbox{{$status_slider}}{{ $products->id }}">
    <input type="checkbox" id="checkbox{{$status_slider}}{{ $products->id }}" @if ($products->status == 1) checked @endif @if (permissionCheck('product.update_active_status')) value="{{ $products->id }}" data-id="{{ $products->id }}" class="product_status_change" @else disabled @endif>
    <div class="slider round"></div>
</label>
@else

    @if($products->is_approved == 1)<span class="badge_1">{{__('common.approved')}}</span>@else<span class="badge_2">{{__('common.pending')}}</span>@endif

@endif
