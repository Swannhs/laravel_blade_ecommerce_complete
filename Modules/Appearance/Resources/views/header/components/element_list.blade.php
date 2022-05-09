@if($header->type == 'category')
<div class="white-box p-15">
    <h4 class="mb-10">{{__('common.category_list')}}</h4>
    <div id="categoryDiv" class="minh-250">
        @if(count(@$header->CateGorySectionItems())>0)
        @foreach(@$header->CateGorySectionItems() as $key => $element)
        @if($element->category->status == 1)
        <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
            <div class="mb-10">
                <div class="card" id="accordion_{{$element->id}}">
                    <div class="card-header card_header_element">
                        <p class="d-inline">
                            {{$element->title}}
                        </p>
                        <div class="pull-right">

                            <a href="javascript:void(0);" class=" d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">Edit <span class="collapge_arrow"></span></a>
                            <a href="" data-id="{{$element->id}}" class=" d-inline primary-btn category_delete_btn"><i class="ti-close"></i></a>
                        </div>

                    </div>
                    <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="element_edit_form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$element->id}}">
                                    <input type="hidden" name="header_id" value="{{$header->id}}">
                                    <input type="hidden" id="header_type" value="{{$header->type}}">

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="title">
                                                {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" required>
                                        </div>
                                    </div>
                                    @if($header->type == 'category')
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.category_list') }}</label>
                                            <select name="category" class="primary_select mb-15 category" required>

                                                @foreach($categories as $key => $category)
                                                    @if($category->status == 1)
                                                        <option value="{{$category->id}}" {{$element->category_id == $category->id?'selected':''}}><span>-></span> {{$category->name}}</option>
                                                    @endif
                                                    @if(count($category->subCategories) > 0)
                                                        @foreach ($category->subCategories as $subItem)
                                                            @include('appearance::header.components._category_select_option',['subItem' => $subItem,'element' => $element])
                                                        @endforeach
                                                    @endif
                                                @endforeach

                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                <li>
                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                        <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="submit" class="primary-btn fix-gr-bg"><i
                                                    class="ti-check"></i>
                                                {{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif
        @endforeach
        @else
        <div class="mt-20 pt-100 text-center">
            {{__('appearance.no_categories')}}
        </div>
        @endif
    </div>
</div>

@elseif($header->type == 'product')
<div class="white-box p-15">
    <h4 class="mb-10">{{__('appearance.product_list')}}</h4>
    <div id="productDiv" class="minh-250">
        @if(count(@$header->productSectionItems())>0)
        @foreach(@$header->productSectionItems() as $key => $element)
        <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
            <div class="mb-10">
                <div class="card" id="accordion_{{$element->id}}">
                    <div class="card-header card_header_element">
                        <p class="d-inline">
                            {{$element->title}}
                        </p>
                        <div class="pull-right">

                            <a href="javascript:void(0);" class=" d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                            <a href="" data-id="{{$element->id}}" class="d-inline primary-btn product_delete_btn"><i class="ti-close"></i></a>
                        </div>

                    </div>
                    <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="element_edit_form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$element->id}}">
                                    <input type="hidden" name="header_id" value="{{$header->id}}">
                                    <input type="hidden" id="header_type" value="{{$header->type}}">

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="title">
                                                {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" required>
                                        </div>
                                    </div>
                                    @if($header->type == 'product')
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('appearance.product_list') }}</label>
                                            <select name="product" class="primary_select mb-15 product" required>
                                                @foreach ($products as $key => $product)
                                                    <option {{$element->product_id == $product->id?'selected':''}} value="{{ $product->id }}">{{ @$product->product->product_name }} @if(isModuleActive('MultiVendor')) [@if($product->seller->role->type == 'seller') {{$product->seller->first_name}} @else Inhouse @endif] @endif</option>
                                                @endforeach

                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>

                                    @endif
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                <li>
                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                        <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="submit" class="primary-btn fix-gr-bg"><i
                                                    class="ti-check"></i>
                                                {{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="mt-20 pt-100 text-center">
            {{__('appearance.no_categories')}}
        </div>
        @endif
    </div>
</div>

@elseif($header->type == 'slider')

    <div class="white-box p-15">
        <h4 class="mb-10">{{__('appearance.slider_list')}}</h4>
        <div id="sliderDiv" class="minh-250">
            @if(count(@$header->sliderSectionItems())>0)
            @foreach(@$header->sliderSectionItems() as $key => $element)
            <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
                <div class="mb-10">
                    <div class="card" id="accordion_{{$element->id}}">
                        <div class="card-header card_header_element">
                            <p class="d-inline">
                                {{$element->name}}
                            </p>
                            <div class="pull-right">

                                <a href="javascript:void(0);" class=" d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                                <a href="" data-id="{{$element->id}}" class="d-inline primary-btn slider_delete_btn"><i class="ti-close"></i></a>
                            </div>

                        </div>
                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                            <div class="card-body">
                                <form enctype="multipart/form-data" id="element_edit_form">
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{$element->id}}">
                                        <input type="hidden" name="header_id" value="{{$header->id}}">
                                        <input type="hidden" id="header_type" value="{{$header->type}}">

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off"
                                                    value="{{$element->name}}" placeholder="{{__('common.name')}}" required>
                                            </div>
                                            <span class="text-danger" id="error_name"></span>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('appearance.slider_image') }} (660 x 365)PX <span class="text-danger">*</span></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="banner_image_file_{{$element->id}}"
                                                        placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="slider_image_{{$element->id}}">{{ __('common.browse') }} </label>
                                                        <input type="file" class="d-none slider_image_edit" data-img_id="#slider_img_div_{{$element->id}}" data-name_id="#banner_image_file_{{$element->id}}" name="slider_image" id="slider_image_{{$element->id}}">
                                                    </button>
                                                </div>
                                            </div>
                                            @error('slider_image')
                                            <span class="text-danger" id="error_slider_image">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="slider_img">

                                                <img class="sliderImgDiv" id="slider_img_div_{{$element->id}}"
                                                     src="{{ showImage($element->slider_image?$element->slider_image:'backend/img/default.png') }}" alt="">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('appearance.slider_for') }}</label>
                                                <select name="data_type" data-id="#data_div_{{$element->id}}" class="primary_select slider_drop mb-15 element_list_data_type">
                                                    <option value="">select</option>
                                                    <option {{$element->data_type == 'product'?'selected':''}} value="product">{{ __('appearance.for_product') }}</option>
                                                    <option {{$element->data_type == 'category'?'selected':''}} value="category">{{ __('appearance.for_category') }}</option>
                                                    <option {{$element->data_type == 'brand'?'selected':''}} value="brand">{{ __('appearance.for_brand') }}</option>
                                                    <option {{$element->data_type == 'tag'?'selected':''}} value="tag">{{ __('appearance.for_tag') }}</option>
                                                    <option {{$element->data_type == 'url'?'selected':''}} value="url">{{ __('appearance.for_url_not_support_in_mobile_app') }}</option>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>



                                        <div class="col-lg-12" id="data_div_{{$element->id}}">

                                                @if($element->data_type == 'url')

                                                    <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                for="url">{{__('setup.url')}} <span class="text-danger">*</span></label>
                                                                <input class="primary_input_field" type="text" id="url" name="url" autocomplete="off"
                                                            value="{{$element->url}}" placeholder="{{__('setup.url')}}" required>
                                                    </div>
                                                    <span class="text-danger" id="error_name"></span>

                                                @elseif($element->data_type == 'product')

                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="">{{ __('product.product_list') }}</label>
                                                        <select name="data_id" class="primary_select slider_drop mb-15">
                                                            @foreach($products as $key => $product)
                                                            <option {{$product->id == $element->data_id?'selected':''}} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [@if($product->seller->role->type == 'seller') {{$product->seller->first_name}} @else Inhouse @endif] @endif</option>
                                                            @endforeach

                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>

                                                @elseif($element->data_type == 'category')

                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="">{{ __('product.category_list') }}</label>
                                                        <select name="data_id" class="primary_select slider_drop mb-15">

                                                            @foreach($categories->where('parent_id', 0) as $key => $item)
                                                            <option {{$item->id == $element->data_id?'selected':''}} value="{{$item->id}}"><span>-></span> {{ $item->name}}</option>

                                                            @if(count($item->subCategories) > 0)
                                                                @foreach($item->subCategories as $subItem)
                                                                    @include('product::category.components.category_select_edit',['subItem' => $subItem, 'parent_id' => $element->data_id])
                                                                @endforeach
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>

                                                @elseif($element->data_type == 'brand')

                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="">{{ __('product.brand_list') }}</label>
                                                        <select name="data_id" id="slider_brand" class="primary_select slider_drop mb-15">
                                                            @foreach($brands as $key => $brand)
                                                            <option {{$brand->id == $element->data_id?'selected':''}}  value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach

                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>

                                                @elseif($element->data_type == 'tag')

                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="">{{ __('common.tag') }} {{__('common.list')}}</label>
                                                        <select name="data_id" id="slider_tag" class="primary_select slider_drop mb-15">
                                                            @foreach($tags as $key => $tag)
                                                            <option {{$tag->id == $element->data_id?'selected':''}} value="{{$tag->id}}">{{$tag->name}}</option>
                                                            @endforeach

                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>


                                                @endif

                                        </div>



                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="status" id="status_active" value="1" {{$element->status?'checked':''}} class="active"
                                                                type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.active') }}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" id="status_inactive" {{$element->status == 0?'checked':''}} class="de_active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.inactive') }}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input">
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab?'checked':''}} type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn fix-gr-bg"><i
                                                        class="ti-check"></i>
                                                    {{ __('common.update') }}
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
            @else


            <div class="mt-20 pt-100 text-center">
                {{__('appearance.no_sliders')}}
            </div>
            @endif

        </div>
    </div>

@endif
