@extends('backEnd.master')

@section('styles')
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />

<link rel="stylesheet" href="{{asset(asset_path('modules/product/css/product_clone.css'))}}" />
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-20 white_box">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.clone_product') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs justify-content-end mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#GenaralInfo" role="tab" data-toggle="tab" id="1"
                            aria-selected="true">{{__('product.general_information')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link show" href="#RelatedProduct" role="tab" data-toggle="tab" id="2"
                            aria-selected="false">{{__('product.related_product')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link show" href="#UpSale" role="tab" data-toggle="tab" id="3"
                            aria-selected="false">{{__('common.up_sale')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link show" href="#CrossSale" role="tab" data-toggle="tab" id="4"
                            aria-selected="true">{{__('common.cross_sale')}}</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active show" id="GenaralInfo">

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="white_box pt-0 box_shadow_white mb-20 p-15">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-2 mr-30">{{ __('product.product_information') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">

                                            <input type="hidden" value="{{ $product->product_type }}" id="product_type">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><strong>{{ __('common.type') }}</strong> @if($product->product_type == 2) ({{__('product.variant_product_is_not_changable_to_single_product')}}) @endif<span
                                                        class="text-danger">*</span></label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="product_type" id="single_prod" value="1" {{$product->product_type == 2?'disabled':''}} {{$product->product_type == 1?'checked':''}}
                                                                class="active prod_type" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('product.single') }}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="product_type" value="2" id="variant_prod" {{$product->product_type == 2?'disabled':''}} {{$product->product_type == 2?'checked':''}}
                                                                class="de_active prod_type" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('product.variant') }}</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        @if($product->product_type == 2)
                                        <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                                        @endif
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("common.name")}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" name="product_name" id="product_name" placeholder="{{__("common.name")}}" type="text" value="{{ $product->product_name }}-{{date('ymis').rand(11,99)}}" required="1">
                                                <span class="text-danger" id="error_product_name">{{$errors->first('product_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 sku_single_div">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.product_sku")}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" name="sku" id="sku_single" placeholder="{{__("product.product_sku")}}" type="text" required="1" value="{{ @$product->skus->first()->sku }}">
                                                <span class="text-danger" id="error_single_sku">{{$errors->first('sku')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="model_number"> {{__("common.model_number")}}</label>
                                                <input class="primary_input_field" name="model_number" placeholder="{{__("common.model_number")}}" type="text" value="{{old('model_number')?old('model_number'):$product->model_number}}">
                                                <span class="text-danger">{{$errors->first('model_number')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="category_select_div">
                                            @php
                                                $product_categories = $product->categories->pluck('id')->toArray();
                                            @endphp
                                            @include('product::products.components._category_list_select',['product_categories' => $product_categories])
                                        </div>
                                        <div class="col-lg-6" id="brand_select_div">
                                            @include('product::products.components._brand_list_select')
                                        </div>
                                        <div class="col-lg-6" id="unit_select_div">
                                            @include('product::products.components._unit_list_select')
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('product.barcode_type')}}</label>
                                                <select name="barcode_type" id="barcode_type" class="primary_select mb-15">
                                                    @foreach (barcodeList() as $key => $barcode)
                                                        <option value="{{ $barcode }}" @if($barcode == @$product->skus->first()->barcode_type) selected @endif>{{ $barcode }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first('barcode_type')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.minimum_order_qty")}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" name="minimum_order_qty" id="minimum_order_qty" value="{{ $product->minimum_order_qty }}" type="number" min="1" step="0" required="1">
                                                <span class="text-danger" id="error_minumum_qty">{{$errors->first('minimum_order_qty')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.max_order_qty")}}</label>
                                                <input class="primary_input_field" name="max_order_qty" type="number" min="0" step="0" value="{{ $product->max_order_qty }}">
                                                <span class="text-danger">{{$errors->first('max_order_qty')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">

                                                <label for="">@lang('blog.tags') (@lang('product.comma_separated'))<span class="text-danger">*</span></label>
                                                <div class="tagInput_field mb_26">
                                                    @php
                                                        $tags =[];
                                                        foreach($product->tags as $tag){
                                                            $tags[] = $tag->name;
                                                        }
                                                        $tags = implode(',',$tags);
                                                    @endphp
                                                    <input name="tags" id="tags" class="tag-input" id="tag-input-upload-shots" type="text" value="{{$tags}}"
                                                        data-role="tagsinput" />
                                                </div>
                                                <span class="text-danger" id="error_tags">{{$errors->first('tags')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 attribute_div">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('product.attribute') }}</label>
                                                <select name="choice_attributes[]" id="choice_attributes" class="primary_select mb-15">
                                                    <option value="" selected disabled>{{__('product.select_attribute')}}</option>
                                                    @foreach($attributes as $key => $attribute)
                                                    <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                    @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('choice_attributes')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="customer_choice_options" id="customer_choice_options">
                                                @foreach ($product->variations->unique("attribute_id") as $key => $choice_option)
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <input type="hidden" name="choice_no[]" id="attribute_id_{{$choice_option->attribute_id}}" value="{{ $choice_option->attribute_id }}">
                                                            <div class="primary_input mb-25"><input class="primary_input_field" width="40%" name="choice[]" type="text" value="{{ \Modules\Product\Entities\Attribute::find($choice_option->attribute_id)->name }}" readonly></div>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <div class="primary_input mb-25">
                                                                <select name="choice_options_{{ $choice_option->attribute_id }}[]" id="choice_options" class="primary_select mb-15 choice_attribute" multiple>
                                                                    @foreach ($choice_option->attribute->values as $key => $value)
                                                                        <option value="{{ $value->id }}" @if ($product->variations->where('attribute_value_id', $value->id)->first()) selected @endif>{{ $value->color ? $value->color->name : $value->value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 text-center">
                                                            <a class="btn cursor_pointer attribute_remove"><i class="ti-trash"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-12 sku_combination overflow-auto">

                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.price_info_and_stock') }}</h3>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input">
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="is_physical" id="is_physical" {{$product->is_physical == 1?'checked':''}} value="1"
                                                                type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('product.is_physical_product') }}</p>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>


                                        <div class="col-lg-12 digital_file_upload_div_edit" style="display: {{$product->is_physical == 0?'block':'none'}}">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('product.program_file_upload') }}</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="pdf_place" placeholder="{{__('product.upload_file')}}"
                                                        readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="pdf">{{ __('product.Browse') }} </label>
                                                        <input type="file" class="d-none" name="digital_file" id="pdf"
                                                            >
                                                    </button>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('documents') }}</span>
                                            </div>
                                        </div>

                                        <div id="phisical_shipping_div" class="col-lg-12" style="display: {{$product->is_physical == 0?'none':'block'}}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="additional_shipping">
                                                            {{ __('product.additional_shipping_charge') }}
                                                            </label>
                                                        <input class="primary_input_field" name="additional_shipping"
                                                                type="number"
                                                            min="0" step="{{step_decimal()}}"
                                                            value="{{ @$product->skus->first()->additional_shipping }}">
                                                        <span
                                                            class="text-danger">{{ $errors->first('additional_shipping') }}</span>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>


                                        @if(!isModuleActive('MultiVendor'))
                                            @php
                                                $frontend_product = $product->sellerProducts->where('user_id', 1)->first();
                                            @endphp
                                            <div class="col-lg-12" id="stock_manage_div">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('Stock Manage') }}</label>
                                                    <select class="primary_select mb-25" name="stock_manage"
                                                        id="stock_manage">
                                                        <option value="1" {{@$frontend_product->stock_manage == 1?'selected':''}}>{{ __('common.yes') }}</option>
                                                        <option value="0" {{@$frontend_product->stock_manage == 0?'selected':''}}>{{ __('common.no') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 d-none" id="single_stock_div">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="single_stock"> {{
                                                        __('product.product_stock') }}
                                                    </label>
                                                    <input class="primary_input_field" name="single_stock" id="single_stock"
                                                        type="number" min="0" step="0"
                                                        value="{{old('single_stock')?old('single_stock'):@$frontend_product->skus[0]->product_stock}}">
                                                    <span class="text-danger">{{ $errors->first('single_stock') }}</span>
                                                </div>
                                            </div>

                                        @endif

                                        <div class="col-lg-12 selling_price_div">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.selling_price")}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" name="selling_price" id="selling_price" placeholder="{{__("product.selling_price")}}" type="number" min="0" step="{{step_decimal()}}" value="{{ @$product->skus->first()->selling_price }}" required>
                                                <span class="text-danger" id="error_selling_price">{{$errors->first('selling_price')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.tax")}}</label>
                                                <input class="primary_input_field" name="tax" id="tax" placeholder="{{__("product.tax")}}" type="number" min="0" step="{{step_decimal()}}" value="{{ $product->tax }}">
                                                <span class="text-danger" id="error_tax">{{$errors->first('tax')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('product.tax_type') }}</label>
                                                <select class="primary_select mb-25" name="tax_type" id="tax_type">
                                                    <option value="1" @if ($product->tax_type == 1) selected @endif>{{ __('common.amount') }}</option>
                                                    <option value="0" @if ($product->tax_type == 0) selected @endif>{{ __('common.percentage') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.discount")}}</label>
                                                <input class="primary_input_field" name="discount" id="discount" placeholder="{{__("product.discount")}}" type="number" min="0" step="{{step_decimal()}}" value="{{ $product->discount }}">
                                                <span class="text-danger" id="error_discunt">{{$errors->first('discount')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('product.discount_type') }}</label>
                                                <select class="primary_select mb-25" name="discount_type" id="discount_type">
                                                    <option value="1" @if ($product->discount_type == 1) selected @endif>{{ __('common.amount') }}</option>
                                                    <option value="0" @if ($product->discount_type == 0) selected @endif>{{ __('common.percentage') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{__("common.description")}}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <textarea class="summernote" name="description">{{ $product->description }}</textarea>
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.specifications') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <textarea class="summernote" id="specification" name="specification">{{ $product->specification }}</textarea>
                                            </div>
                                        </div>




                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('common.seo_info') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("common.meta_title")}}</label>
                                                <input class="primary_input_field" name="meta_title" placeholder="{{__("common.meta_title")}}" type="text" value="{{ $product->meta_title }}">
                                                <span class="text-danger">{{$errors->first('meta_title')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("common.meta_description")}}</label>
                                                <textarea class="primary_textarea height_112 meta_description" placeholder="{{ __('common.meta_description') }}" name="meta_description" spellcheck="false">{{ $product->meta_description }}</textarea>
                                                <span class="text-danger">{{$errors->first('meta_description')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('product.meta_image')}} (150x150)PX</label>
                                                <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="meta_image_file" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="meta_image">{{__("product.meta_image")}} </label>
                                                    <input type="file" class="d-none" name="meta_image" id="meta_image" accept="image/*">
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @if ($product->meta_image)
                                                <p class="cp" aria-disabled="true" id="metaImgDelete" data-id="{{$product->id}}"><i class="fas fa-times img_cross"></i></p>
                                            @endif
                                            <div class="meta_img_div">
                                                <img id="MetaImgDiv"
                                                src="{{showImage('backend/img/default.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="white_box pt-0 box_shadow_white p-15">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.product_image_info') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('product.thumbnail_image')}} (165x165)PX <span class="text-danger">*</span></label>
                                                <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="thumbnail_image_file" placeholder="{{__("product.thumbnail_image")}}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="thumbnail_image">{{__("common.browse")}} </label>
                                                    <input type="file" class="d-none" name="thumbnail_image" id="thumbnail_image" accept="image/*">
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <div class="thumb_img_div">
                                                <img id="ThumbnailImg" src="{{showImage('backend/img/default.png')}}" alt="">
                                            </div>
                                        </div>
                                        <span class="text-danger" id="error_thumbnail"></span>

                                        <div class="col-lg-12">
                                            <div id="gallery_img_prev">

                                            </div>

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('product.galary_image')}} (600x545)PX</label>
                                                <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{__("product.galary_image")}}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="galary_image">{{__("common.browse")}} </label>
                                                    <input type="file" class="d-none" name="galary_image[]" id="galary_image" multiple accept="image/*">
                                                </button>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.pdf_specifications') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('product.pdf_specifications')}}</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{__('product.upload_pdf')}}" readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg" for="pdf_file">{{__("common.browse")}} </label>
                                                        <input type="file" class="d-none" name="pdf_file" id="pdf_file">
                                                    </button>
                                                </div>
                                                <span class="text-danger">{{$errors->first('documents')}}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 shipping_title_div" style="display: {{$product->is_physical == 1?'block':'none'}}">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.product_shipping_cost') }}</h3>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 shipping_type_div" id="shipping_method_div" style="display: {{$product->is_physical == 1?'block':'none'}}">
                                            @include('product::products.components._shipping_method_list_select')
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.product_videos_info') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('product.video_provider') }}</label>
                                                <select class="primary_select mb-25" name="video_provider" id="video_provider">
                                                    <option value="youtube" @if ($product->video_provider == "youtube") selected @endif>{{ __('product.youtube') }}</option>
                                                    <option value="daily_motion" @if ($product->video_provider == "daily_motion") selected @endif>{{ __('product.daily_motion') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for=""> {{__("product.video_link")}}</label>
                                                <input class="primary_input_field" name="video_link" placeholder="{{__("product.video_link")}}" type="text" value="{{ $product->video_link }}">
                                                <span class="text-danger">{{$errors->first('video_link')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="main-title d-flex">
                                                <h3 class="mb-3 mr-30">{{ __('product.others_info') }}</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">{{ __('common.status') }} <span class="text-danger">*</span></label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" id="status_active" value="1" @if (@$product->status == 1) checked @endif class="active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.publish') }}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" id="status_inactive" @if (@$product->status == 0) checked @endif  class="de_active"
                                                                   type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.pending') }}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">{{ __('common.make_Display_in_details_page') }} <span class="text-danger">*</span></label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="display_in_details" id="status_active" value="1" @if ($product->display_in_details == 1) checked @endif class="active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.up_sale') }}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="display_in_details" value="2" id="status_inactive" @if ($product->display_in_details == 2) checked @endif class="de_active"
                                                                   type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.cross_sale') }}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="RelatedProduct">
                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.related_product') }}</h3>

                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive" id="product_list_div">
                                    <table class="table">
                                        <thead>

                                            <tr>
                                                <th width="10%" scope="col">
                                                    <label class="primary_checkbox d-flex ">
                                                        <input type="checkbox" id="relatedProductAll">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th width="25%" scope="col">{{ __('common.name') }}</th>
                                                <th width="15%" scope="col">{{ __('product.brand') }}</th>
                                                <th width="15%" scope="col">{{ __('product.thumbnail') }}</th>
                                                <th width="15%" scope="col">{{ __('product.created_at') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablecontentsrelatedProduct">
                                            @foreach (@$product->relatedProducts as $key => $relatedSale)
                                                <tr>
                                                    <th scope="col">
                                                        <label class="primary_checkbox d-flex">
                                                            <input name="related_product[]" id="related_product_{{$key}}" checked value="{{$relatedSale->main_product->id}}" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <td>{{ $relatedSale->main_product->product_name }}</td>
                                                    <td>{{ @$relatedSale->main_product->brand->name }}</td>
                                                    <td>
                                                        <div class="product_img_div">
                                                            <img class="product_list_img"
                                                                src="{{ showImage($relatedSale->main_product->thumbnail_image_source) }}"
                                                                alt="{{ $relatedSale->main_product->product_name }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($relatedSale->main_product->created_at)) }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-12 text-center mb-20">
                                        <button class="primary_btn_2 mt-5 text-center lodeMoreRelatedSale">{{ __('common.load_more') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="UpSale">

                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.up_sale') }}</h3>

                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive" id="product_list_div">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="10%" scope="col">
                                                    <label class="primary_checkbox d-flex ">
                                                        <input type="checkbox" id="upSaleAll">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th width="25%" scope="col">{{ __('common.name') }}</th>
                                                <th width="15%" scope="col">{{ __('product.brand') }}</th>
                                                <th width="15%" scope="col">{{ __('product.thumbnail') }}</th>
                                                <th width="15%" scope="col">{{ __('product.created_at') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablecontentsupSaleAll">
                                            @foreach (@$product->upSales as $key => $upSale)
                                                <tr>
                                                    <th scope="col">
                                                        <label class="primary_checkbox d-flex">
                                                            <input name="up_sale[]" id="up_sale_{{$key}}" checked value="{{$upSale->main_product->id}}" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <td>{{ $upSale->main_product->product_name }}</td>
                                                    <td>{{ @$upSale->main_product->brand->name }}</td>
                                                    <td>
                                                        <div class="product_img_div">
                                                            <img class="product_list_img"
                                                                src="{{ showImage($upSale->main_product->thumbnail_image_source) }}"
                                                                alt="{{ $upSale->main_product->product_name }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($upSale->main_product->created_at)) }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-12 text-center mb-20">
                                        <button class="primary_btn_2 mt-5 text-center lodeMoreUpSale">{{ __('common.load_more') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="CrossSale">

                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.cross_sale') }}</h3>

                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="table-responsive" id="product_list_div">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="10%" scope="col">
                                                    <label class="primary_checkbox d-flex ">
                                                        <input type="checkbox" id="crossSaleAll">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th width="25%" scope="col">{{ __('common.name') }}</th>
                                                <th width="15%" scope="col">{{ __('product.brand') }}</th>
                                                <th width="15%" scope="col">{{ __('product.thumbnail') }}</th>
                                                <th width="15%" scope="col">{{ __('product.created_at') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablecontentscrossSaleAll">
                                            @foreach (@$product->crossSales as $key => $crossSale)
                                                <tr>
                                                    <th scope="col">
                                                        <label class="primary_checkbox d-flex">
                                                            <input name="cross_sale[]" id="cross_sale_{{$key}}" checked value="{{$crossSale->main_product->id}}" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <td>{{ $crossSale->main_product->product_name }}</td>
                                                    <td>{{ @$crossSale->main_product->brand->name }}</td>
                                                    <td>
                                                        <div class="product_img_div">
                                                            <img class="product_list_img"
                                                                src="{{ showImage($crossSale->main_product->thumbnail_image_source) }}"
                                                                alt="{{ $crossSale->main_product->product_name }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($crossSale->main_product->created_at)) }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-12 text-center mb-20">
                                        <button class="primary_btn_2 mt-5 text-center lodeMoreCrossSale">{{ __('common.load_more') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-warning mt-30 text-center">
                            {{__('product.save_information')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </div>
                    </div>
                    <input type="hidden" name="request_from" value="main_product_form">
                    <div class="col-12 text-center">
                        <button class="primary_btn_2 mt-5 text-center saveBtn"><i class="ti-check"></i>{{ __('common.save') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>
    @include('product::products.components._create_category_modal')
    @include('product::products.components._create_brand_modal')
    @include('product::products.components._create_unit_modal')
    @include('product::products.components._create_shipping_modal')
@endsection
@include('product::products.clone_scripts')
