<div class="modal fade admin-query" id="productDetails">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->product->product_name }} {{ __('product.details') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="products_view_left text-center mb-35">
                                <div class="products_image_div">
                                    <img src="{{ asset(asset_path(@$product->product->thumbnail_image_source)) }}" alt="">
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="products_view_right mb-35">
                                <div class="products_details_list">
                                    <div class="products_details_single">
                                        <span>{{__('product.product_name')}} </span>
                                        <span>: {{ $product->product->product_name }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.SKU')}} </span>
                                        <span>: {{ $product->product->skus->first()->sku }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.product_type')}} </span>
                                        <span>: {{$product->product->product_type}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.category')}} </span>
                                        <span>: {{@$product->product->category->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.Brand')}}</span>
                                        <span>: {{@$product->product->brand->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.barcode_type')}} </span>
                                        <span>: {{$product->product->barcode_type }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.unit')}} </span>
                                        <span>: {{@$product->product->unit_type->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.minimum_order_qty')}} </span>
                                        <span>: {{$product->product->minimum_order_qty}} <small>/{{@$product->productSKU->product->unit_type->name}}</small> </span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.unit_cost')}} </span>
                                        <span>: {{single_price($product->purchase_price)}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.tax')}}  </span>
                                        <span>: {{ ($product->tax_type == 1) ? single_price($product->tax) : $product->tax. "%" }}</span>
                                    </div>

                                    @if($product->product->product_type == 1)
                                    <div class="products_details_single">
                                        <span>{{__('product.selling_price')}}  </span>
                                        <span>: {{ single_price($product->skus->first()->selling_price) }}</span>
                                    </div>
                                    @endif

                                    <div class="products_details_single">
                                        <span>{{__('product.discount')}}  </span>
                                        <span>: {{ ($product->discount_type == 1) ? single_price($product->discount) : $product->discount. "%" }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($product->product->gallary_images) > 0)
                            <div class="col-12">
                                <div class="mb-35">
                                    <div class="box_header m-0">
                                        <div class="main-title d-flex mb-15">
                                            <h3 class="mb-0">{{__('product.galary_image')}}</h3>
                                        </div>
                                    </div>
                                    <div class="gallary_img_div">
                                        @foreach ($product->product->gallary_images as $key => $gallary_image)
                                            <div class="gallary_img">
                                                <img src="{{asset(asset_path($gallary_image->images_source))}}" alt="{{$product->product_name}}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (count($product->skus) > 1)
                            <div class="col-12 mb-40">
                                <!-- content  -->
                                <div class="QA_section3 QA_section_heading_custom">
                                    <div class="box_header m-0">
                                            <div class="main-title d-flex mb-10">
                                                <h3 class="mb-0">{{__('product.variant_items')}} <span class="f_s_12 f_w_500 theme_text2 ml-15" >({{ count($product->skus) }} Variant)</span> </h3>
                                            </div>
                                        </div>
                                    <div class="QA_table QA_table4">
                                        <!-- table-responsive -->
                                        <div class="table-responsive">
                                            <table class="table shadow_none pb-0 ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{__('product.attribute')}}</th>
                                                        <th scope="col">{{__('product.product_sku')}}</th>
                                                        <th scope="col">{{__('product.selling_price')}}</th>
                                                        <th scope="col">{{ __('common.status') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @foreach($product->skus as $key => $sku)
                                                        <tr>
                                                            <td class="text-nowrap">
                                                                @foreach ($sku->sku->product_variations as $key => $variation)
                                                                    {{ @$variation->attribute->name }} : {{ $variation->attribute_value->color ? @$variation->attribute_value->color->name : @$variation->attribute_value->value }} </br>
                                                                @endforeach
                                                            </td>
                                                            <td class="text-no-wrap">{{ $sku->sku->sku }}</td>
                                                            <td class="text-nowrap">{{ single_price($sku->selling_price) }}</td>
                                                            <td>
                                                                <label class="switch_toggle" for="checkbox{{ $sku->id }}">
                                                                    <input type="checkbox" id="checkbox{{ $sku->id }}" @if ($sku->status == 1) checked @endif value="{{ $sku->id }}" onchange="update_active_sku_status(this)">
                                                                    <div class="slider round"></div>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--/ content  -->
                            </div>
                        @endif
                        <div class="col-12 mt-40 mb-20">
                            <div class="description_box">
                                <h4 class="f_s_14 f_w_500 mb_10">{{__('common.description')}}:</h4>
                                <p class="f_w_400" >
                                    @php
                                        echo $product->product->description;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
