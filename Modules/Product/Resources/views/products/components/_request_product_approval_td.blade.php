<label class="switch_toggle" for="checkbox{{ $products->id }}">
    <input type="checkbox" id="checkbox{{ $products->id }}" @if ($products->is_approved == 1) checked @endif @if (permissionCheck('product.request.approved')) value="{{ $products->id }}" data-id="{{ $products->id }}" class="product_approve" @else disabled @endif>
    <div class="slider round"></div>
</label>
