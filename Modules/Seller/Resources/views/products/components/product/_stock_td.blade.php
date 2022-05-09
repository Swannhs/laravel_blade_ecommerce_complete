@if ($products->stock_manage == 1)
    @php
        $stock = 0;
    @endphp
    @foreach ($products->skus as $sku)
        @php
            $stock += $sku->product_stock;
        @endphp
    @endforeach
@else
    @php
        $stock = 'Not Manage';
    @endphp
@endif

{{ $stock }}
@if ($products->product->unit_type_id != null)
    ({{ @$products->product->unit_type->name }})
@endif
