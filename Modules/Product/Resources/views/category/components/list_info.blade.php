<div class="row">
    <div class="col-lg-12">
        <table class="table Crm_table_active3 text-center">
            <thead>
                <tr>
                    <th scope="col">{{ __('common.id') }}</th>
                    <th scope="col">{{ __('common.name') }}</th>
                    <th scope="col">{{ __('product.parent_category') }}</th>
                    @if(isModuleActive('MultiVendor'))
                    <th scope="col">{{ __('common.commission_rate') }}</th>
                    @endif
                    <th scope="col">{{ __('product.total_product') }}</th>
                    <th scope="col">{{ __('product.num_of_sale') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach($CategoryList as $key => $item)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->parentCategory? $item->parentCategory->name:'Parent'}}</td>
                    @if(isModuleActive('MultiVendor'))
                    <td>{{ $item->commission_rate }} %</td>
                    @endif
                    <td>{{ count($item->products) }}</td>
                    <td>{{ $item->total_sale }}</td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </div>
</div>
