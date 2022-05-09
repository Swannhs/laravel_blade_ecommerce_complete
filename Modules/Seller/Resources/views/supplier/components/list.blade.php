<div class="">
    <!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>

                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('seller.supplier_id') }}</th>
                <th scope="col">{{ __('common.name') }}</th>
                <th scope="col">{{ __('common.email') }}</th>
                <th scope="col">{{ __('common.phone_number') }}</th>
                <th scope="col">{{ __('seller.pay_term') }}</th>
                <th scope="col">{{ __('seller.tax_number') }}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $key => $supplier)
                <tr>
                    <th class="pl-3">{{ $key + 1 }}</th>
                    <td>{{ $supplier->supplier_id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->email ? $supplier->email : '' }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->payterm ? $supplier->payterm : '' }}</td>
                    <td>{{ $supplier->tax_number ? $supplier->tax_number : '' }}</td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $supplier->id }}">
                            <input type="checkbox" id="checkbox{{ $supplier->id }}"
                                {{ $supplier->status ? 'checked' : '' }}
                                value="{{ $supplier->id }}"
                                onchange="update_active_status(this)">
                            <div class="slider round"></div>
                        </label>
                    </td>
                    <td>
                        <!-- shortby  -->
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenu2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('common.Select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="dropdownMenu2">
                                <a class="dropdown-item" href="{{route('seller.supplier.show',$supplier->id)}}">{{ __('common.view') }}</a>
                                <a class="dropdown-item edit_brand"
                                    href="{{ route('seller.supplier.edit', $supplier->id) }}">{{ __('common.Edit') }}</a>
                                <a class="dropdown-item edit_brand"
                                    onclick="delete_modal({{ $supplier->id }})">{{ __('common.Delete') }}</a>
                            </div>
                        </div>
                        <!-- shortby  -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
