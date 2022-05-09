
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a class="dropdown-item product_detail" data-id="{{ $products->id }}">{{__('common.view')}}</a>
        @if (permissionCheck('product.edit'))
            <a class="dropdown-item edit_brand" href="{{ route('product.edit', $products->id) }}">{{__('common.edit')}}</a>
        @endif
        
        @if (permissionCheck('product.destroy'))
            <a class="dropdown-item delete_product" data-id="{{$products->id}}">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
