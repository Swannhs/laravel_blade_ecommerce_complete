<div class="modal fade admin-query" id="productDetails">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->productSKU->product->product_name }} {{ __('product.details') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="products_view_left text-center mb-35">
                                <div class="products_image mb-25">
                                    <img src="{{ asset(asset_path(@$product->productSKU->product->thumbnail_image_source)) }}" alt="">
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="products_view_right mb-35">
                                <div class="products_details_list">
                                    <div class="products_details_single">
                                        <span>{{__('product.product_name')}}: </span>
                                        <span>{{ $product->productSKU->product->product_name }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.SKU')}}: </span>
                                        <span>{{ $product->productSKU->product->skus->first()->sku }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.product_type')}}: </span>
                                        <span>{{$product->productSKU->product->product_type}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.category')}}: </span>
                                        <span>{{@$product->productSKU->product->category->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.Brand')}}:</span>
                                        <span>{{@$product->productSKU->product->brand->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.barcode_type')}}: </span>
                                        <span>{{$product->productSKU->product->barcode_type }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.unit')}}: </span>
                                        <span>{{@$product->productSKU->product->unit_type->name}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.minimum_order_qty')}}: </span>
                                        <span>{{$product->productSKU->product->minimum_order_qty}} <small>/{{@$product->productSKU->product->unit_type->name}}</small> </span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.unit_cost')}}: </span>
                                        <span>{{single_price($product->purchase_price)}}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.tax')}}:  </span>
                                        <span>{{ ($product->tax_type == 1) ? single_price($product->tax) : $product->tax. "%" }}</span>
                                    </div>
                                    <div class="products_details_single">
                                        <span>{{__('product.discount')}}:  </span>
                                        <span>{{ ($product->discount_type == 1) ? single_price($product->discount) : $product->discount. "%" }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($product->productSKU->product->gallary_images) > 0)
                            <div class="col-12">
                                <div class="mb-35">
                                    <div class="box_header m-0">
                                        <div class="main-title d-flex mb-15">
                                            <h3 class="mb-0">{{__('product.galary_image')}}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($product->productSKU->product->gallary_images as $key => $gallary_image)
                                            <div class="col-md-3">
                                                <img  height="50px" width="70px" src="{{asset(asset_path($gallary_image->images_source))}}" alt="{{$product->product_name}}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-12 mt-40 mb-20">
                            <h4 class="f_s_14 f_w_500 mb_10">{{__('product.Description')}}:</h4>
                            <p class="f_w_400" >
                                @php
                                    echo $product->productSKU->product->description;
                                @endphp
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
