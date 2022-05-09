@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/create.css'))}}" />

@endsection
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center mb-40">

            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30">{{__('common.add')}} {{ __('common.product') }}</h3>

                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="white_box box_shadow_white p-25">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="product_types">{{ __('common.product_type') }}
                                    <span class="text-danger">*</span></label>
                                <select class="primary_select mb-25" name="product_types" id="product_types" required>
                                    <option selected value="2">{{ __('product.existing_product') }}</option>
                                    <option value="1">{{ __('product.new_product') }}</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div id="exsisitng_product_div" class="col-xl-12">
                            <form action="{{route('seller.product.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="product_id" id="product_id" value="">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="product_sku">{{ __('common.select') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="primary_select mb-25 product_id" name="product_id" required>
                                                <option value="" selected disabled>{{ __('common.select') }}</option>
                                                @foreach($Products as $product)
                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="error_product_id"></span>
                                        </div>

                                    </div>
                                    <div id="single_product_stock_manage_div" class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="product_stock_manage">{{__('product.product_stock_manage')}} <span
                                                    class="text-danger">*</span></label>
                                            <select class="primary_select mb-25" name="stock_manage" id="stock_manage"
                                                required>
                                                <option value="1">{{ __('common.yes') }}</option>
                                                <option value="0" selected>{{ __('common.no') }}</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div id="single_product_stock_div" class="col-xl-6 d-none">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="product_stock">{{__('product.product_stock')}} <span
                                                    class="text-danger">*</span></label>
                                            <input class="primary_input_field" name="product_stock" id="product_stock"
                                                placeholder="{{__("product.product_stock")}}" type="number" min="0"
                                                step="{{step_decimal()}}" value="0" required>
                                            @error('product_stock')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div id="variant_sku_div" class="col-xl-6 d-none">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="product_sku">{{ __('product.select_product_sku') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="primary_select mb-25" name="product_sku []" id="product_sku"
                                                multiple>
                                                <option value="" selected disabled>{{ __('common.select') }}</option>

                                            </select>
                                        </div>

                                    </div>


                                </div>
                                <div id="priceBoxDiv" class="row">

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__("product.selling_price")}}
                                                <span class="text-danger">*</span></label>
                                            <input class="primary_input_field" name="selling_price" id="selling_prices"
                                                placeholder="{{__("product.selling_price")}}" type="number" min="0"
                                                step="{{step_decimal()}}" value="0" required>
                                            @error('selling_price')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">
                                                {{__("product.display_name")}} </label>
                                            <input class="primary_input_field" id="product_name" name="product_name"
                                                placeholder="{{__("product.display_name")}}" type="text">
                                            <span class="text-danger">{{$errors->first('product_name')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('product.thumbnail_image') }} (165x165)PX</label>
                                                    <div class="primary_file_uploader">
                                                        <input class="primary-input" type="text"
                                                            id="thumbnail_image_file_seller"
                                                            placeholder="{{ __('product.thumbnail_image') }}"
                                                            readonly="">
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                for="thumbnail_image_seller">{{ __('product.Browse') }}
                                                            </label>
                                                            <input type="file" class="d-none" name="thumbnail_image" accept="image/*"
                                                                id="thumbnail_image_seller">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-12">
                                                <div class="seller_thumb_img_div">
                                                    <img id="sellerThumbnailImg" src="{{asset(asset_path('backend/img/default.png'))}}"
                                                    alt="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__("product.tax")}}</label>
                                            <input class="primary_input_field" id="tax" name="tax"
                                                placeholder="{{__("product.tax")}}" type="number" min="0" step="{{step_decimal()}}"
                                                value="0">
                                            <span class="text-danger">{{$errors->first('tax')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="">{{ __('product.tax_type') }}</label>
                                            <select class="primary_select mb-25" name="tax_type" id="tax_type">
                                                <option value="1">{{ __('product.amount') }}</option>
                                                <option value="0">{{ __('product.percentage') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">
                                                {{__("product.discount")}}</label>
                                            <input class="primary_input_field" name="discount" id="discount"
                                                placeholder="{{__("product.discount")}}" type="number" min="0"
                                                step="{{step_decimal()}}" value="0">
                                            <span class="text-danger">{{$errors->first('discount')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                for="">{{ __('product.discount_type') }}</label>
                                            <select class="primary_select mb-25" name="discount_type"
                                                id="discount_type">
                                                <option value="1">{{ __('product.amount') }}</option>
                                                <option value="0">{{ __('product.percentage') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                for="startDate">{{__('product.discount_start_date')}}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="{{ __('common.date') }}"
                                                                class="primary_input_field primary-input date form-control"
                                                                id="startDate" type="text" name="discount_start_date"
                                                                value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                for="endDate">{{__('product.discount_end_date')}}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="{{ __('common.date') }}"
                                                                class="primary_input_field primary-input date form-control"
                                                                id="endDate" type="text" name="discount_end_date"
                                                                value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="end-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="variant_table_div" class="col-xl-12 d-none overflow-auto">

                                        <table class="table table-bordered sku_table_exsist">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">{{ __('product.variant') }}</th>

                                                    <th class="text-center">{{ __('product.selling_price') }}</th>
                                                    <th class="text-center product_stock_th stock_td">
                                                        {{ __('product.product_stock') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sku_tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center mt-20">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg mr-1"
                                                id="save_button_parent" type="submit"><i
                                                    class="ti-check"></i>{{__('common.save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div id="new_product_div" class="col-xl-12 d-none">
                            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                                id="choice_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="white_box box_shadow_white mb-20 p-15">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-2 mr-30">{{ __('product.product_information') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    

                                                    <input type="hidden" value="1" id="product_type">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label" for="">{{ __('common.type') }} <span
                                                                class="text-danger">*</span></label>
                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                            <li>
                                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                    <input name="product_type" id="single_prod" value="1" checked
                                                                        class="active prod_type" type="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('product.single') }}</p>
                                                            </li>
                                                            <li>
                                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                    <input name="product_type" value="2" id="variant_prod"
                                                                        class="de_active prod_type" type="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('product.variant') }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for=""> {{__("common.name")}}
                                                            <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" name="product_name"
                                                            id="product_name_new" placeholder="{{__("common.name")}}"
                                                            type="text" value="{{old('name')}}" required="1">
                                                        <span
                                                            class="text-danger" id="error_product_new_name">{{$errors->first('product_name')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 sku_single_div">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.product_sku")}} <span
                                                                class="text-danger">*</span></label>
                                                        <input class="primary_input_field" name="sku" id="sku_single"
                                                            placeholder="{{__("product.product_sku")}}" type="text"
                                                            required="1">
                                                        <span class="text-danger" id="error_single_sku">{{$errors->first('sku')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="model_number">
                                                            {{__("common.model_number")}}</label>
                                                        <input class="primary_input_field" name="model_number"
                                                            placeholder="{{__("common.model_number")}}" type="text"
                                                            value="{{old('model_number')}}">
                                                        <span
                                                            class="text-danger">{{$errors->first('model_number')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.category') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="category_ids[]" id="category_id"
                                                            class="primary_select mb-15 category" @if(app('general_setting')->multi_category == 1) multiple @endif required="1">
                                                            @foreach($categories as $key => $category)
                                                                @if($category->status == 1)
                                                                    <option value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                @endif
                                                                @if(count($category->subCategories) > 0)
                                                                    @foreach ($category->subCategories as $subItem)
                                                                        @include('seller::products.components.product._category_option_select',['subItem' => $subItem])
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="error_category_ids">{{$errors->first('category_id')}}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.brand') }}</label>
                                                        <select name="brand_id" id="brand_id"
                                                            class="primary_select mb-15 brand">
                                                            <option disabled selected>{{__('product.select_brand')}}
                                                            </option>
                                                            @foreach($brands as $key=>$brand)
                                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">{{$errors->first('brand_id')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.unit') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="unit_type_id" id="unit_type_id"
                                                            class="primary_select mb-15 unit">
                                                            <option disabled selected>{{__('product.select_unit')}}
                                                            </option>
                                                            @foreach($units as $key => $unit)
                                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="text-danger" id="error_unit_type">{{$errors->first('unit_type_id')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                            for="">{{__('product.barcode_type')}}</label>
                                                        <select name="barcode_type" id="barcode_type"
                                                            class="primary_select mb-15">
                                                            @foreach (barcodeList() as $key => $barcode)
                                                            <option value="{{ $barcode }}" @if($key==0) selected @endif>
                                                                {{ $barcode }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="text-danger">{{$errors->first('barcode_type')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.minimum_order_qty")}} <span
                                                                class="text-danger">*</span></label>
                                                        <input class="primary_input_field" name="minimum_order_qty"
                                                            id="minimum_order_qty" value="1" type="number" min="1"
                                                            step="0" required="1">
                                                        <span
                                                            class="text-danger" id="error_minumum_qty">{{$errors->first('minimum_order_qty')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.max_order_qty")}} </label>
                                                        <input class="primary_input_field" name="max_order_qty"
                                                            type="number" min="0">
                                                        <span
                                                            class="text-danger">{{$errors->first('max_order_qty')}}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">

                                                    <div class="single_field ">
                                                        <label for="">@lang('blog.tags') (@lang('product.comma_separated'))<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="tagInput_field mb_26">
                                                        <input name="tags" class="tag-input" id="tag-input-upload-shots"
                                                            type="text" value="" data-role="tagsinput" />
                                                    </div>
                                                    <br>
                                                    <div class="suggeted_tags">
                                                        <label>@lang('blog.suggested_tags')</label>
                                                        <ul id="tag_show"  class="suggested_tag_show">
                                                        </ul>
                                                    </div>
                                                    <br>
                                                    <span class="text-danger" id="error_tags"></span>
                                                </div>

                                                <div class="col-lg-12 attribute_div">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.attribute') }}</label>
                                                        <select name="choice_attributes" id="choice_attributes"
                                                            class="primary_select mb-15 choice_attribute">
                                                            <option value="" selected disabled>{{__('product.select_attribute')}}</option>
                                                            @foreach($attributes as $key => $attribute)
                                                            <option value="{{$attribute->id}}">{{$attribute->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span
                                                            class="text-danger">{{$errors->first('choice_attributes')}}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="customer_choice_options" id="customer_choice_options">

                                                    </div>
                                                </div>

                                                <div class="col-lg-12 sku_combination overflow-auto">

                                                </div>

                                            </div>

                                            <div class="row">
                                                
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.price_info_and_stock') }}
                                                        </h3>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="primary_input">
                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                            <li>
                                                                <label data-id="bg_option"
                                                                    class="primary_checkbox d-flex mr-12">
                                                                    <input name="" id="is_physical" checked value="1"
                                                                        type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('product.is_physical_product') }}</p>
                                                                <input type="hidden" name="is_physical" value="1"
                                                                    id="is_physical_prod">
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div id="phisical_shipping_div" class="col-lg-12">
                                                    <div class="row">

                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                    for="additional_shipping">
                                                                    {{ __('product.additional_shipping_charge') }}
                                                                </label>
                                                                <input class="primary_input_field"
                                                                    name="additional_shipping"
                                                                    placeholder="{{ __('product.tax') }}" type="number"
                                                                    min="0" step="{{step_decimal()}}"
                                                                    value="{{old('additional_shipping')?old('additional_shipping'):0}}">
                                                                <span
                                                                    class="text-danger">{{ $errors->first('additional_shipping') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 digital_file_upload_div_single">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.program_file_upload') }}</label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                id="digital_file_place"
                                                                placeholder="{{ __('common.upload_file') }}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="digital_file">{{ __('product.Browse') }}
                                                                </label>
                                                                <input type="file" class="d-none" accept=".pdf"
                                                                    name="digital_file" id="digital_file">
                                                            </button>
                                                        </div>
                                                        <span
                                                            class="text-danger">{{ $errors->first('documents') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 selling_price_div">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.selling_price")}} <span
                                                                class="text-danger">*</span></label>
                                                        <input class="primary_input_field" name="selling_price"
                                                            id="selling_price"
                                                            placeholder="{{__("product.selling_price")}}" type="number"
                                                            min="0" step="{{step_decimal()}}" value="0" required>
                                                        <span
                                                            class="text-danger" id="error_selling_price">{{$errors->first('selling_price')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.tax")}}</label>
                                                        <input class="primary_input_field" name="tax" id="tax"
                                                            placeholder="{{__("product.tax")}}" type="number" min="0"
                                                            step="{{step_decimal()}}" value="0">
                                                        <span class="text-danger" id="error_tax">{{$errors->first('tax')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.tax_type') }}</label>
                                                        <select class="primary_select mb-25" name="tax_type"
                                                            id="tax_type">
                                                            <option value="1">{{ __('product.amount') }}</option>
                                                            <option value="0">{{ __('product.percentage') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.discount")}} </label>
                                                        <input class="primary_input_field" name="discount" id="discount"
                                                            placeholder="{{__("product.discount")}}" type="number"
                                                            min="0" step="{{step_decimal()}}" value="0">
                                                        <span class="text-danger" id="error_discunt">{{$errors->first('discount')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.discount_type') }}</label>
                                                        <select class="primary_select mb-25" name="discount_type"
                                                            id="discount_type">
                                                            <option value="1">{{ __('product.amount') }}</option>
                                                            <option value="0">{{ __('product.percentage') }}</option>
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
                                                        <textarea class="summernote" name="description"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.specifications') }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">

                                                        <textarea class="summernote" id="specification"
                                                            name="specification"></textarea>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('common.seo_info') }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("common.meta_title")}}</label>
                                                        <input class="primary_input_field" name="meta_title"
                                                            placeholder="{{__("common.meta_title")}}" type="text"
                                                            value="{{old('meta_title')}}">
                                                        <span
                                                            class="text-danger">{{$errors->first('meta_title')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("common.meta_description")}}</label>
                                                        <textarea class="primary_textarea height_112 meta_description"
                                                            placeholder="{{ __('common.meta_description') }}"
                                                            name="meta_description" spellcheck="false"></textarea>
                                                        <span
                                                            class="text-danger">{{$errors->first('meta_description')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{__('product.meta_image')}} (150x150)px</label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                id="meta_image_file"
                                                                placeholder="{{ __('common.browse_file') }}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="meta_image">{{__("product.meta_image")}}
                                                                </label>
                                                                <input type="file" class="d-none" name="meta_image" accept="image/*"
                                                                    id="meta_image">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="meta_img_div">
                                                        <img id="MetaImgDiv" src="{{asset(asset_path('backend/img/default.png'))}}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="white_box box_shadow_white p-15">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.product_image_info') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{__('product.thumbnail_image')}} (165x165)PX<span
                                                                class="text-danger">*</span></label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                id="thumbnail_image_file"
                                                                placeholder="{{__("product.thumbnail_image")}}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="thumbnail_image">{{__("product.Browse")}}
                                                                </label>
                                                                <input type="file" class="d-none" name="thumbnail_image" accept="image/*"
                                                                    id="thumbnail_image" required>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="thumb_img_div">
                                                        <img id="ThumbnailImg"
                                                            src="{{asset(asset_path('backend/img/default.png'))}}" alt="">
                                                    </div>
                                                </div>
                                                <span id="error_thumbnail" class="text-danger"></span>

                                                <div class="col-lg-12">
                                                    <div id="gallery_img_prev">

                                                    </div>

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{__('product.galary_image')}} (600x545)PX</label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                id="placeholderFileOneName"
                                                                placeholder="{{__("product.galary_image")}}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="galary_image">{{__("product.Browse")}} </label>
                                                                <input type="file" class="d-none" name="galary_image[]" accept="image/*"
                                                                    id="galary_image" multiple>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.pdf_specifications') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{__('product.pdf_specifications')}}</label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text" id="pdf_place"
                                                                placeholder="{{ __('common.upload_pdf') }}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="pdf">{{__("product.Browse")}} </label>
                                                                <input type="file" class="d-none" accept=".pdf"
                                                                    name="pdf_file" id="pdf">
                                                            </button>
                                                        </div>
                                                        <span class="text-danger">{{$errors->first('documents')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 shipping_title_div">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.product_shipping_cost') }}
                                                        </h3>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 shipping_type_div">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.shipping_methods') }}
                                                            <span class="text-danger">*</span></label>
                                                        <select class="primary_select mb-25" name="shipping_methods[]"
                                                            id="shipping_methods" multiple required>
                                                            @foreach($shippings->where('id','>', 1) as $key => $shipping)
                                                            <option value="{{$shipping->id}}">
                                                                {{ $shipping->method_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="error_shipping_method"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="main-title d-flex">
                                                        <h3 class="mb-3 mr-30">{{ __('product.product_videos_info') }}
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('product.video_provider') }}</label>
                                                        <select class="primary_select mb-25" name="video_provider"
                                                            id="video_provider">
                                                            <option value="youtube">{{ __('product.youtube') }}</option>
                                                            <option value="daily_motion">
                                                                {{ __('product.daily_motion') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">
                                                            {{__("product.video_link")}}</label>
                                                        <input class="primary_input_field" name="video_link"
                                                            placeholder="{{__("product.video_link")}}" type="text"
                                                            value="{{old('video_link')}}">
                                                        <span
                                                            class="text-danger">{{$errors->first('video_link')}}</span>
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
                                                                    <input name="status" id="status_active" value="1" checked class="active" type="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('common.publish') }}</p>
                                                            </li>
                                                            <li>
                                                                <label data-id="color_option"
                                                                       class="primary_checkbox d-flex mr-12">
                                                                    <input name="status" value="0" id="status_inactive"  class="de_active"
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
                                                                    <input name="display_in_details" id="status_active" value="1" checked class="active" type="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('common.up_sale') }}</p>
                                                            </li>
                                                            <li>
                                                                <label data-id="color_option"
                                                                       class="primary_checkbox d-flex mr-12">
                                                                    <input name="display_in_details" value="2" id="status_inactive"  class="de_active"
                                                                           type="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p>{{ __('common.cross_sale') }}</p>
                                                            </li>
                                                        </ul>
                                                        <span class="text-danger" id="status_error"></span>
                                                    </div>
                                                </div>
                                                @php
                                                $user = auth()->user();
                                                @endphp
                                                <input type="hidden" name="request_from"
                                                    value="@if($user->role->type == 'seller') seller_product_form @else inhouse_product_form @endif">
                                                <div class="col-12">
                                                    <button class="primary_btn_2 mt-5 saveBtn"><i
                                                            class="ti-check"></i>{{__("common.save")}} </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="product_type_input" value="1">

</section>


@endsection

@push('scripts')

<script type="text/javascript">
    (function($){
        "use strict";

        $(document).ready(function(){
            $('.summernote').summernote({
                height: 200,
                codeviewFilter: true,
			    codeviewIframeFilter: true
            });
            getActiveFieldAttribute();
            getActiveFieldShipping();
            $('.digital_file_upload_div_single').hide();

            $(document).on('change', '#product_types', function(){
                let val = $('#product_types').val();
                productTypeChange(val);
            });

            function productTypeChange(val){
                if(val == 2){
                        $('#exsisitng_product_div').removeClass('d-none');
                        $('#new_product_div').addClass('d-none');

                }if(val == 1){
                    if("{{ auth()->user()->role->type }}" == "superadmin" || "{{ auth()->user()->role->type }}" == "admin" || "{{ auth()->user()->role->type }}" == "staff"){
                        location.href = "{{ route('product.create') }}";
                    }else{
                        $('#exsisitng_product_div').addClass('d-none');
                        $('#new_product_div').removeClass('d-none');
                    }
                }
            }

            $(document).on('change', '.product_id', function(event){
                event.preventDefault();
                let val = $('.product_id').val();
                getActiveField(val);
            });

            function getActiveField(val){
                $('#variant_table_div').addClass('d-none');
                $('#pre-loader').removeClass('d-none');
                    if(val != null){


                        let url = "/seller/product/" + val;
                        $.ajax({
                            url: url,
                            type: "GET",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#pre-loader').addClass('d-none');
                                if(response == 'product_exsist'){
                                    toastr.error("{{__('seller.product_allready_added')}}", "{{__('common.error')}}");
                                    $('#priceBoxDiv').removeClass('d-none');
                                    $('#variant_sku_div').addClass('d-none');
                                    $('.product_id').val('');
                                    $('.product_id').niceSelect('update');

                                }else{
                                    $('#product_type_input').val(response.product_type);
                                    if(response.product_type == 1){
                                        getStockField();

                                        $('#priceBoxDiv').removeClass('d-none');
                                        $('#variant_sku_div').addClass('d-none');


                                        $('#product_id').val(response.id);
                                        $('#purchase_prices').val(response.skus[0].purchase_price)
                                        $('#selling_prices').val(response.skus[0].selling_price)
                                        $('#tax').val(response.tax)
                                        $('#discount').val(response.discount)
                                        $('#tax_type').val(response.tax_type)
                                        $('#discount_type').val(response.discount_type)
                                        $('#tax_type').niceSelect('update');
                                        $('#discount_type').niceSelect('update');
                                    }else{
                                        $('#single_product_stock_div').addClass('d-none');
                                        $('#single_product_stock_manage_div').removeClass('col-xl-3');
                                        $('#single_product_stock_manage_div').addClass('col-xl-6');
                                        $('#product_stock').removeAttr('required');
                                        $('#priceBoxDiv').addClass('d-none');
                                        $('#variant_sku_div').removeClass('d-none');

                                        $('#tax').val(response.tax)
                                        $('#discount').val(response.discount)
                                        $('#tax_type').val(response.tax_type)
                                        $('#discount_type').val(response.discount_type)
                                        $('#tax_type').niceSelect('update');
                                        $('#discount_type').niceSelect('update');

                                        $('#product_sku').empty();
                                        $.each( response.active_skus, function(key,value) {
                                            $('#product_sku').append(`<option value="${value.id}">${value.sku}</option>`)
                                        });
                                        $('#product_sku').niceSelect('update');


                                    }
                                }

                            },
                            error: function(response) {
                                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                        });


                    }else{
                        $('#priceBoxDiv').addClass('d-none');
                    }
            }

            $(document).on('change', '#stock_manage', function(){
                getStockField();
            });

            function getStockField(){
                var stock_manage = $('#stock_manage').val();
                if (stock_manage == 1) {
                    if($('#product_type_input').val()== 1){
                        $('#single_product_stock_div').removeClass('col-xl-6');
                        $('#single_product_stock_div').addClass('col-xl-3');
                        $('#single_product_stock_manage_div').removeClass('col-xl-6');
                        $('#single_product_stock_manage_div').addClass('col-xl-3');
                        $('#single_product_stock_div').removeClass('d-none');
                        $("#product_stock").prop('required',true);

                    }else{
                        $('.stock_td').removeClass('d-none');

                    }
                }else {
                    $('#single_product_stock_div').addClass('d-none');
                    $('#single_product_stock_manage_div').removeClass('col-xl-3');
                    $('#single_product_stock_manage_div').addClass('col-xl-6');
                    $('#product_stock').removeAttr('required');
                    $('.stock_td').addClass('d-none');
                }
            }

            $(document).on('change', '#thumbnail_image_seller', function(){
                getFileName($(this).val(),'#thumbnail_image_file_seller');
                imageChangeWithFile($(this)[0],'#sellerThumbnailImg');
            });

            $(document).on('click', '.prod_type', function(){
                if($('#product_type').val($(this).val())){
                    getActiveFieldAttribute();
                }
            });

            function getActiveFieldAttribute() {
                $('#is_physical').prop('checked',true);
                var product_type = $('#product_type').val();
                if (product_type == 1) {
                    $('.attribute_div').hide();

                    $('.variant_physical_div').hide();
                    $('.customer_choice_options').hide();
                    $('.sku_combination').hide();

                    $('.sku_single_div').show();
                    $('.selling_price_div').show();
                    $("#sku_single").removeAttr("disabled");
                    $("#purchase_price").removeAttr("disabled");
                    $("#selling_price").removeAttr("disabled");
                } else {
                    $('.attribute_div').show();
                    $('.sku_single_div').hide();
                    $('.variant_physical_div').show();
                    $('.sku_combination').show();
                    $('.customer_choice_options').show();

                    $('.selling_price_div').hide();
                    $("#sku_single").attr('disabled', true);
                    $("#purchase_price").attr('disabled', true);
                    $("#selling_price").attr('disabled', true);
                }
            }

            $(document).on('change','#product_sku', function(){

                $('#variant_table_div').addClass('d-none');

                $('#sku_tbody').empty();
                var a_id = $(this).val();
                var a_name = $(this).text();
                var stock_manage = $('#stock_manage').val();
                $.post('{{ route('seller.product.variant') }}', {_token:'{{ csrf_token() }}', ids:a_id, stock_manage:stock_manage}, function(data){
                    $('#variant_table_div').removeClass('d-none');
                    if (stock_manage == 1) {
                        $('.product_stock_th').removeClass('d-none');
                    }else {
                        $('.product_stock_th').addClass('d-none');
                    }
                    $('#sku_tbody').empty();
                    $('#sku_tbody').append(data.variants)
                });
            });

            $(document).on('change', '#digital_file', function(){
                getFileName($(this).val(),'#digital_file_place');
            });

            $(document).on('change', '#meta_image' , function(){
                getFileName($(this).val(),'#meta_image_file'),imageChangeWithFile($(this)[0],'#MetaImgDiv');
            });

            $(document).on('change', '#thumbnail_image', function(){
                getFileName($(this).val(),'#thumbnail_image_file'),imageChangeWithFile($(this)[0],'#ThumbnailImg');
            });

            $(document).on('change', '#galary_image', function(){
                galleryImage($(this)[0],'#galler_img_prev');
            });

            $(document).on('change', '#pdf', function(){
                getFileName(this.value,'#pdf_place');
            });

            $(document).on('change', '#choice_options', function(){
                get_combinations();
            })

            function get_combinations(el){
                $.ajax({
                    type:"POST",
                    url:'{{ route('product.sku_combination') }}',
                    data:$('#choice_form').serialize(),
                    success: function(data){
                        $('.sku_combination').html(data);
                        if ($('#is_physical').is(":checked")){
                            $('.variant_physical_div').show();
                            $('.variant_digital_div').hide();
                        }else{
                            $('.variant_physical_div').hide();
                            $('.variant_digital_div').show();
                        }
                    }
                });
            }

            $(document).on('change', '.variant_img_change', function(event){
                let name_id = $(this).data('name_id');
                let img_id = $(this).data('img_id');
                getFileName($(this).val(), name_id);
                imageChangeWithFile($(this)[0], img_id);
            });

            $(document).on('change', '#is_physical', function(event){
                var product_type = $('#product_type').val();
                if (product_type ==1) {
                    if ($('#is_physical').is(":checked"))
                    {
                        $('#phisical_shipping_div').show();
                        $('.variant_physical_div').hide();
                        $('.digital_file_upload_div_single').hide();
                        shipping_div_show();
                    }else{
                        $('#phisical_shipping_div').hide();
                        $('.digital_file_upload_div_single').show();
                        shipping_div_hide();
                    }
                }else {
                    if($('#is_physical').is(":checked")){
                        $('#phisical_shipping_div').show();
                        $('.digital_file_upload_div_single').hide();
                        $('.variant_physical_div').show();
                        $('.variant_digital_div').hide();
                        shipping_div_show();
                    }else{
                        $('.variant_physical_div').hide();
                        $('.digital_file_upload_div_single').hide();
                        $('.variant_digital_div').show();
                        $('#phisical_shipping_div').hide();
                        shipping_div_hide();
                    }
                }

                if ($('#is_physical').is(":checked")){
                    $('#is_physical_prod').val(1);
                }else{
                    $('#is_physical_prod').val(0);
                }

            });

            // $(document).on('change','#choice_attributes', function() {
            //     var a_id = $(this).val();
            //     var a_name = $(this).text();
            //     $.post('{{ route('product.attribute.values') }}', {
            //         _token: '{{ csrf_token() }}',
            //         id: a_id
            //     },
            //     function(data) {
            //         $('#customer_choice_options').html(data);
            //         $('select').niceSelect();
            //     });

            // });

            $(document).on('change', '#choice_attributes', function() {
                
                var a_id = $(this).val();
                var a_name = $(this).text();
                $('#pre-loader').removeClass('d-none');
                var exsist = $('#attribute_id_'+a_id).length;
                if(exsist > 0){
                    toastr.error("{{__('marketing.this_item_already_added_to_list')}}");
                    $('#pre-loader').addClass('d-none');
                    $('#choice_attributes').val('');
                    $('#choice_attributes').niceSelect('update');
                    return false;
                }
                $.post('{{ route('product.attribute.values') }}', {
                    _token: '{{ csrf_token() }}',
                    id: a_id
                },
                function(data) {
                    $('#customer_choice_options').append(data);
                    $('select').niceSelect();
                    $('#pre-loader').addClass('d-none');
                    $('#choice_attributes').val('');
                    $('#choice_attributes').niceSelect('update');
                });

            });

            $(document).on('click', '.attribute_remove', function(){
                let this_data = $(this)[0];
                delete_product_row(this_data);
                $('.sku_combination').html('');
            });
            function delete_product_row(this_data){
                let row = this_data.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }

            function shipping_div_hide()
            {
                $('.shipping_title_div').hide();
                $('.shipping_type_div').hide();
                $('.shipping_cost_div').hide();
                $('#shipping_cost').val(0);
            }

            function shipping_div_show()
            {
                $('.shipping_title_div').show();
                $('.shipping_type_div').show();
                $('.shipping_cost_div').show();
                $('#shipping_cost').val(0);
            }

            // function add_more_customer_choice_option(i, name, data){
            //     var option_value = '';
            //     $.each(data.values, function (key, item) {
            //         if (item.color) {
            //             option_value += `<option value="${item.id}">${item.color.name}</option>`
            //         }
            //         else {
            //             option_value += `<option value="${item.id}">${item.value}</option>`
            //         }
            //     });
            //     $('#customer_choice_options').append('<div class="row"><div class="col-lg-4"><input type="hidden" name="choice_no[]" value="'+i+'"><div class="primary_input mb-25"><input class="primary_input_field" width="40%" name="choice[]" type="text" value="'+name+'" readonly></div></div><div class="col-lg-8">'+
            //         '<div class="primary_input mb-25">'+
            //             '<select name="choice_options_'+i+'[]" id="choice_options" class="primary_select mb-15" multiple>'+option_value+
            //         '</select'+
            //         '</div>'+
            //     '</div></div>');
            //     $('select').niceSelect();
            // }

            function getActiveFieldShipping()
            {
                var shipping_type = $('#shipping_type').val();
                if (shipping_type == 1) {
                    $('.shipping_cost_div').hide();
                    $('#shipping_cost').val(0);
                }else {
                    $('.shipping_cost_div').show();
                    $('#shipping_cost').val(0);
                }
            }

            function galleryImage(data, divId){

                if(data.files){

                    $.each( data.files, function(key,value) {
                        $('#gallery_img_prev').empty();
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#gallery_img_prev').append(
                            `
                                <div class="galary_img_div">
                                    <img class="galaryImg" src="`+ e.target.result +`" alt="">
                                </div>
                            `
                        );

                        };
                        reader.readAsDataURL(value);
                    });
                }

            }

            $(document).on('click','.saveBtn',function() {
                $('#error_single_sku').text('');
                $('#error_product_id').text('');
                $('#error_product_new_name').text('');
                $('#error_category_ids').text('');
                $('#error_unit_type').text('');
                $('#error_minumum_qty').text('');
                $('#error_selling_price').text('');
                $('#error_tax').text('');
                $('#error_discunt').text('');
                $('#error_thumbnail').text('');
                $('#error_shipping_method').text('');
                $('#error_tags').text('');

                var requireMatch = 0;

                if ($("#product_name_new").val() === '') {
                    requireMatch = 1;

                    $('#error_product_new_name').text("{{ __('product.please_input_product_name') }}");
                }
                if($('#product_type').val() == 1){
                    if ($("#sku_single").val() === '') {
                        requireMatch = 1;
                        $('#error_single_sku').text("{{ __('product.please_input_product_sku') }}");
                    }
                }

                if ($("#category_id").val().length < 1) {
                    requireMatch = 1;
                    $('#error_category_ids').text("{{ __('product.please_select_category') }}");
                }
                if ($("#unit_type_id").val() === null) {
                    requireMatch = 1;
                    $('#error_unit_type').text("{{ __('product.please_select_product_unit') }}");
                }
                if (parseInt($("#minimum_order_qty").val()) < 1 || $("#minimum_order_qty").val() === '') {
                    requireMatch = 1;
                    $('#error_minumum_qty').text("{{ __('product.please_input_minimum_order_qty') }}");
                }

                if ($("#selling_price").val() === '') {
                    requireMatch = 1;
                    $('#error_selling_price').text("{{ __('product.please_input_selling_price') }}");
                }
                if ($("#tax").val() === '') {
                    requireMatch = 1;
                    $('#error_tax').text("{{ __('product.please_input_tax') }}");
                }
                if ($("#discount").val() === '') {
                    requireMatch = 1;
                    $('#error_discunt').text("{{ __('product.please_input_discount_minimum_0') }}");
                }
                if ($("#thumbnail_image").val() === '') {
                    requireMatch = 1;
                    $('#error_thumbnail').text("{{ __('product.please_upload_thumnail_image') }}");
                }
                if ($("#shipping_methods").val().length < 1) {
                    requireMatch = 1;
                    $('#error_shipping_method').text("{{ __('product.please_select_shipping_method') }}");
                }
                if ($("#tag-input-upload-shots").val() === '') {
                    requireMatch = 1;
                    $('#error_tags').text("{{ __('product.please_input_tags') }}");
                }
                if ($('#product_type').val() === '2' && $(".choice_attribute").val().length === 0) {
                    requireMatch = 1;
                    toastr.warning("{{ __('product.please_select_attribute') }}");
                }
                if (requireMatch == 1) {
                    event.preventDefault();
                }
            });

            $(document).on('click','#save_button_parent', function(event){
                $('#error_product_id').text("");
                var requireMatch = 0;
                if ($(".product_id").val() === null) {
                    requireMatch = 1;
                    $('#error_product_id').text("{{ __('defaultTheme.please_select_product_first') }}");
                }
                if (requireMatch == 1) {
                    event.preventDefault();
                }
            });

            function deleteRow(btn) {
                var row = btn.parentNode;
                row.parentNode.removeChild(row);
            }

            // tag

        $(document).on('click', '.tag-add', function(e){
            e.preventDefault();
            $('#tag-input-upload-shots').tagsinput('add', $(this).text());
        });
        $(document).on('focusout', '#product_name_new', function(){
            // tag get
            $("#tag_show").html('<li></li>');
            var sentence = $(this).val();
            $.get('/setup/getTagBySentence',{sentence:sentence},function(result){
                $("#tag_show").append(result);
            })
        });



        });
    })(jQuery);

</script>

@endpush
