<div id="shipping_method_modal_{{auth()->check()?$data->id:$data['cart_id']}}" class="modal fade shipping_method_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div id="list_div" class="col-md-12">
                        <div class="address_list_div" id="address_list_div">
                            <table class="table table-hover tablesaw tablesaw-stack text-center shipping_modal_table">
                                <thead>
                                    <tr class="">
                                        <th>{{__('Estimated Delivery')}}</th>
                                        <th>{{__('Cost')}}</th>
                                        <th>{{__('Carrier')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="cart_table_body mt-20">
                                    @foreach($shipping_methods as $key => $shipping)
                                    <tr>
                                        <td>
                                            @php
                                                $cart_shipping = (auth()->check())?$data->shipping_method_id:$data['shipping_method_id'];
                                            @endphp
                                            <div class="d-flex align-items-center flex-wrap gap_15">
                                            <label class="cs_checkbox cartv2_check_box">
                                                <input name="shiping_name_{{auth()->check()?$data->id:$data['cart_id']}}"
                                                 data-modal_id="#shipping_method_modal_{{auth()->check()?$data->id:$data['cart_id']}}"
                                                  data-id="{{auth()->check()?$data->id:$data['cart_id']}}" data-value="{{$shipping->shippingMethod->id}}"
                                                   class="shipping_input_data" type="radio" @if ($cart_shipping == @$shipping->shippingMethod->id) checked @endif>
                                                <span class="checkmark"></span>
                                            </label>
                                            
                                            <p class="f_s_14 f_w_400 m-0 @if ($cart_shipping == @$shipping->shippingMethod->id) selected_shipping_text @endif">Estimated Delivery Time: {{$shipping->shippingMethod->shipment_time}}</p>
                                            </div>
                                        </td>
                                        <td><p class="@if ($cart_shipping == @$shipping->shippingMethod->id) selected_shipping_text @endif">Shipping: {{single_price($shipping->shippingMethod->cost)}}</p></td>
                                        <td><p class="@if ($cart_shipping == @$shipping->shippingMethod->id) selected_shipping_text @endif">{{$shipping->shippingMethod->method_name}}</p></td>

                                    </tr>
                                    @endforeach
                                    

                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>