<table class="table" id="mainProductTable">
    <thead>
        @php
            $user = auth()->user();
            $type = $user->role->type;
        @endphp
    <tr>
        <th scope="col">{{ __('common.sl') }}</th>
        <th scope="col">{{ __('common.name') }}</th>
        <th scope="col">{{ __('common.product_type') }}</th>
        <th scope="col">{{ __('product.brand') }}</th>
        <th scope="col">{{ __('common.image') }}</th>
        @if(!isModuleActive('MultiVendor'))
        <th scope="col">{{ __('product.stock') }}</th>
        @endif
        @if($type == "superadmin" || $type == "admin" || $type == "staff")
        <th scope="col">{{ __('common.status') }}</th>
        @else
        <th scope="col">{{ __('common.approval') }}</th>
        @endif
        <th scope="col">{{ __('common.action') }}</th>
    </tr>
    </thead>
    
</table>
