        @foreach($variants as $key => $id)
        @php
            $variant = \Modules\Product\Entities\ProductSku::where('id',$id)->first();
        @endphp
            <tr>
                <input type="hidden" name="product_skus[]" value="{{$variant->id}}">
                <td class="text-center product_sku_name text-nowrap">{{$variant->sku}}</td>
                
                <td class="text-center sku_price_td"><input  class="primary_input_field" type="number" name="selling_price_sku[]" value="{{$variant->selling_price?$variant->selling_price: 0}}" min="0" step="{{step_decimal()}}" class="form-control" required></td>
                
                <td class="sku_price_td stock_td @if ($stock_manage == 1) @else d-none @endif"><input  class="primary_input_field" type="number" name="stock[]" value="0" min="0" step="0" class="form-control" required></td>
            </tr>
        @endforeach
