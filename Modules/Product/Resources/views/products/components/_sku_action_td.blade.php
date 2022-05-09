<!-- shortby  -->
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('product.sku.update'))
            <a class="dropdown-item edit_sku" href="" data-value="{{ $skus }}">{{ __('common.edit') }}</a>
        @endif
        

    </div>
</div>
<!-- shortby  -->
