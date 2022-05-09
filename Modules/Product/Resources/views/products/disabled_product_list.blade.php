<table class="table" id="disabledProductTable">
    <thead>
    <tr>
        <th scope="col">{{ __('common.sl') }}</th>
        <th scope="col">{{ __('common.name') }}</th>
        <th scope="col">{{ __('common.product_type') }}</th>
        <th scope="col">{{ __('product.brand') }}</th>
        <th scope="col">{{ __('common.image') }}</th>
        @if(!isModuleActive('MultiVendor'))
        <th scope="col">{{ __('product.stock') }}</th>
        @endif
        <th scope="col">{{ __('common.status') }}</th>
        <th scope="col">{{ __('common.action') }}</th>
    </tr>
    </thead>
    
</table>
