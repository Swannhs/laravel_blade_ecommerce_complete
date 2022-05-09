
            <tr>
                <input type="hidden" name="product_skus[]" value="{{$variant->id}}">
                <td class="text-center product_sku_name">{{$variant->sku}}</td>
                
                <td class="text-center sku_price_td"><input  class="primary_input_field" type="number" name="selling_price_sku[]" value="{{$variant->selling_price?$variant->selling_price: 0}}" min="0" step="{{step_decimal()}}" class="form-control" required></td>

                @if ($stock_manage == 1)
                    <td class="sku_price_td"><input  class="primary_input_field" type="number" name="stock[]" value="0" min="0" step="0" class="form-control" required></td>
                @endif
                <td class="text-center product_sku_name">
                    @php
                        $rand = rand(2999,8888);
                    @endphp
                    <label class="switch_toggle" for="checkbox_{{$variant->id}}_{{$rand}}">
                        <input type="checkbox" id="checkbox_{{$variant->id}}_{{$rand}}" name="status_{{$variant->id}}"  checked  value="1">
                        <div class="slider round"></div>
                    </label>
                </td>
                <td class="text-center sku_delete_td sku_delete_new" data-unique_id="#badge_id_{{$variant->id}}"><p><i class="fa fa-trash"></i></p></td>
            </tr>
