<table class="table" id="SKUTable">
    <thead>

        <tr>
            <th scope="col">{{ __('common.sl') }}</th>
            <th scope="col">{{ __('common.name') }}</th>
            <th scope="col">{{ __('product.brand') }}</th>
            <th scope="col">{{ __('product.sku') }}</th>
            <th scope="col">{{ __('product.selling_price') }}</th>
            <th scope="col">{{ __('common.image') }}</th>
            <th scope="col">{{ __('common.action') }}</th>
        </tr>
    </thead>

</table>


@include('backEnd.partials._deleteModalForAjax',['item_name' => __('product.product_sku '),'form_id' =>
'sku_delete_form','modal_id' => 'sku_delete_modal'])
