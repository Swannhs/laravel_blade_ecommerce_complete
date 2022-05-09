<!-- shortby  -->
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a class="dropdown-item product_detail" data-id="{{$products->id}}">{{__('common.view')}}</a>
        @if (permissionCheck('product.edit'))
            @if($type == "superadmin" || $type == "admin" || $type == "staff" || $products->is_approved == 0)
                <a class="dropdown-item edit_brand" href="@if($type == 'superadmin' || $type == 'admin' || $type == "staff"){{ route('product.edit', $products->id) }} @else {{ route('seller.my-product.edit', $products->id) }} @endif">{{__('common.edit')}}</a>
            @endif
        @endif
        @if (permissionCheck('product.clone'))
            <a class="dropdown-item edit_brand" href="@if($type == 'superadmin' || $type == 'admin' || $type == "staff"){{ route('product.clone', $products->id) }} @else {{ route('seller.my-product.clone', $products->id) }} @endif">{{__('common.clone')}}</a>
        @endif
        @if (permissionCheck('product.destroy'))
            @if($type == "superadmin" || $type == "admin" || $type == "staff" || $products->is_approved == 0)
            <a class="dropdown-item delete_product" data-type="{{$type}}" data-id="{{$products->id}}">{{__('common.delete')}}</a>
            @endif
        @endif
    </div>
</div>
<!-- shortby  -->
