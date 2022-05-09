<div class="menu_item_div">
    @if($menu->menu_type == 'mega_menu')
    <div id="itemDiv" class="row">
        @foreach($menu->columns as $key => $column)
        <div class="col-lg-12 card mb-10 column_header_div" data-id="{{$column->id}}">
            <div class="card-header card_header" id="accordion_column_{{$column->id}}">
                <h4 class="d-inline">{{$column->column}}[{{$column->size}}] ({{__('menu.column')}})</h4>
                <div class="pull-right">
                    <a href="javascript:void(0);" class="panel-title d-inline  mr-10 primary-btn" data-toggle="collapse" data-target="#collapse_column_{{$column->id}}" aria-expanded="false" aria-controls="collapse_column_{{$column->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                    <a href="" data-id="{{$column->id}}" class="d-inline primary-btn column_delete_btn"><i class="ti-close"></i></a>
                </div>

                <div class="mt-20 column_edit_div collapse" id="collapse_column_{{$column->id}}" aria-labelledby="heading_column_{{$column->id}}" data-parent="#accordion_column_{{$column->id}}">
                    <form enctype="multipart/form-data" id="columnEditForm">
                        <div class="row">
                            <input type="hidden" name="column_id" value="{{$column->id}}">
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="name">
                                        {{__('marketing.navigation_label')}} <span class="text-danger">*</span>

                                    </label>
                                    <input class="primary_input_field name" type="text" id="edit_column" name="column" autocomplete="off" value="{{$column->column}}"  placeholder="{{ __('menu.column') }}" required>
                                </div>
                                <span class="text-danger" id="error_edit_column"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.size') }}</label>
                                    <select name="size" id="edit_size" class="primary_select mb-15 edit_size">
                                        <option data-display="Select Size" value="">{{__('common.size')}}</option>
                                        <option {{$column->size =='1/1'?'selected':''}} value="1/1">1/1</option>
                                        <option {{$column->size =='1/2'?'selected':''}} value="1/2">1/2</option>
                                        <option {{$column->size =='1/3'?'selected':''}} value="1/3">1/3</option>
                                        <option {{$column->size =='1/4'?'selected':''}} value="1/4">1/4</option>
                                    </select>
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

            <div class="card-body p-10 item_list" data-id="{{$column->id}}">
                @foreach(@$column->elements as $key => $element)
                <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
                    <div class="mb-10">
                        <div class="card" id="accordion_{{$element->id}}">
                            <div class="card-header card_header_element">
                                <p class="d-inline">
                                    @if($element->type == 'category')
                                    {{@$element->title}} ({{__('common.category')}})

                                    @elseif($element->type == 'link')
                                    {{@$element->title}} ({{__('common.link')}})

                                    @elseif($element->type == 'page')
                                    {{@$element->title}} ({{__('common.page')}})

                                    @elseif($element->type == 'product')
                                    {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                    ({{__('common.product')}})

                                    @elseif($element->type == 'brand')
                                    {{@$element->title}} ({{__('product.brand')}})

                                    @elseif($element->type == 'tag')
                                    {{@$element->title}} ({{__('common.tag')}})

                                    @endif
                                </p>
                                <div class="pull-right">

                                    <a href="javascript:void(0);" class="d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                                    <a href="" data-id="{{$element->id}}" class="d-inline primary-btn element_delete_btn"><i class="ti-close"></i></a>
                                </div>
                            </div>

                            <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                <div class="card-body">
                                    <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{$element->id}}">
                                            <input type="hidden" name="type" class="element_type" value="{{$element->type}}">



                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="title">
                                                        {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                    <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                </div>
                                            </div>
                                            @if($element->type == 'link')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="link">
                                                        {{__('common.link')}}

                                                    </label>
                                                    <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                </div>
                                            </div>

                                            @elseif($element->type == 'category')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                    <select name="category" class="primary_select mb-15 edit_category">
                                                        <option selected disabled value="">{{__('common.select_one')}}</option>
                                                        @foreach($categories as $key => $category)
                                                            @if($category->status == 1)
                                                                <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                            @endif

                                                            @if(count($category->subCategories) > 0)
                                                                @foreach($category->subCategories as $subItem)
                                                                    @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger"></span>
                                                </div>


                                            </div>
                                            @elseif($element->type == 'page')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                    <select name="page" class="primary_select mb-15 edit_page">
                                                        <option selected disabled value="">{{__('common.select_one')}}</option>
                                                        @foreach($pages as $key => $page)
                                                        <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            @elseif($element->type == 'product')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                    <select name="product" class="primary_select mb-15 edit_product">
                                                        <option selected disabled value="">{{__('common.select_one')}}</option>
                                                        @foreach($products as $key => $product)
                                                        <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor'))[{{@$product->seller->first_name}}]@endif</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            @elseif($element->type == 'brand')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                    <select name="brand" class="primary_select mb-15 edit_brand">
                                                        <option selected disabled value="">{{__('common.select_one')}}</option>
                                                        @foreach($brands as $key => $brand)
                                                        <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            @elseif($element->type == 'tag')
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                    <select name="tag" class="primary_select mb-15 edit_tag">
                                                        <option selected disabled value="">{{__('common.select_one')}}</option>
                                                        @foreach($tags as $key => $tag)
                                                        <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                        @endforeach
                                                    </select>
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
                                                            <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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

            </div>
        </div>
        @endforeach


    </div>
    <div class="mt-20 white-box p-15">
        <h4>{{__('menu.menu_item_list')}}</h4>
        <div id="elementDiv">
            @if(count(@$menu->notUsedElement)>0)
            @foreach(@$menu->notUsedElement as $key => $element)
            <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
                <div class="mb-10">
                    <div class="card" id="accordion_{{$element->id}}">
                        <div class="card-header card_header_element">
                            <p class="d-inline">
                                @if($element->type == 'category')
                                    {{@$element->title}} ({{__('common.category')}})

                                    @elseif($element->type == 'link')
                                    {{@$element->title}} ({{__('common.link')}})

                                    @elseif($element->type == 'page')
                                    {{@$element->title}} ({{__('common.page')}})

                                    @elseif($element->type == 'product')
                                    {{@$element->title}} @if(isModuleActive('MultiVendor')) [{{@$element->product->seller->first_name}}] @endif
                                     ({{__('common.product')}})

                                    @elseif($element->type == 'brand')
                                    {{@$element->title}} ({{__('common.brand')}})

                                    @elseif($element->type == 'tag')
                                    {{@$element->title}} ({{__('common.tag')}})

                                    @endif
                            </p>
                            <div class="pull-right">
                                <a href="javascript:void(0);" class="d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                                <a href="" data-id="{{$element->id}}" class="d-inline primary-btn element_delete_btn"><i class="ti-close"></i></a>
                            </div>

                        </div>
                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                            <div class="card-body">
                                <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{$element->id}}">
                                        <input type="hidden" name="type" value="{{$element->type}}">



                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="title">
                                                    {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                            </div>
                                        </div>
                                        @if($element->type == 'link')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="link">
                                                    {{__('common.link')}}

                                                </label>
                                                <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                            </div>
                                        </div>

                                        @elseif($element->type == 'category')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                <select name="category" class="primary_select mb-15 edit_category">
                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                    @foreach($categories as $key => $category)
                                                        @if($category->status == 1)
                                                            <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                        @endif
                                                        @if(count($category->subCategories) > 0)
                                                            @foreach($category->subCategories as $subItem)
                                                                @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>


                                        </div>
                                        @elseif($element->type == 'page')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                <select name="page" class="primary_select mb-15 edit_page">
                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                    @foreach($pages as $key => $page)
                                                    <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        @elseif($element->type == 'product')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                <select name="product" class="primary_select mb-15 edit_product">
                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                    @foreach($products as $key => $product)
                                                    <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        @elseif($element->type == 'brand')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                <select name="brand" class="primary_select mb-15 edit_brand">
                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                    @foreach($brands as $key => $brand)
                                                    <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        @elseif($element->type == 'tag')
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                <select name="tag" class="primary_select mb-15 edit_tag">
                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                    @foreach($tags as $key => $tag)
                                                    <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                    @endforeach
                                                </select>
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
                                                        <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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

            @endif
        </div>
    </div>
    @elseif($menu->menu_type == 'normal_menu')
        @if(count(@$menu->elements)>0)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="dd">

                            <ol class="dd-list">
                                @foreach($menu->elements as $key => $element)
                                <li class="dd-item" data-id="{{$element->id}}">
                                    <div class="card accordion_card" id="accordion_{{$element->id}}">
                                        <div class="card-header item_header" id="heading_{{$element->id}}">
                                            <div class="dd-handle">
                                                <div class="pull-left">
                                                    @if($element->type == 'category')
                                                    {{@$element->title}} ({{ __('common.category') }})

                                                    @elseif($element->type == 'link')
                                                    {{@$element->title}} ({{__('common.link')}})

                                                    @elseif($element->type == 'page')
                                                    {{@$element->title}} ({{__('common.page')}})

                                                    @elseif($element->type == 'product')
                                                    {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                                    ({{__('common.product')}})

                                                    @elseif($element->type == 'brand')
                                                    {{@$element->title}} ({{__('product.brand')}})

                                                    @elseif($element->type == 'tag')
                                                    {{@$element->title}} ({{__('common.tag')}})

                                                    @endif
                                                </div>

                                            </div>
                                            <div class="pull-right btn_div">
                                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}" class="primary-btn btn_zindex panel-title">{{__('common.edit')}} <span class="collapge_arrow_normal"></span></a>
                                                <a href="" data-id="{{$element->id}}" class="primary-btn element_delete_btn btn_zindex"><i class="ti-close"></i></a>
                                            </div>
                                        </div>
                                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                            <div class="card-body">
                                                <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                                    <div class="row">
                                                        <input type="hidden" name="id" value="{{$element->id}}">
                                                        <input type="hidden" name="type" value="{{$element->type}}">



                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="title">
                                                                    {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                                <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                            </div>
                                                        </div>
                                                        @if($element->type == 'link')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="link">
                                                                    {{__('common.link')}}

                                                                </label>
                                                                <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                            </div>
                                                        </div>

                                                        @elseif($element->type == 'category')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                <select name="category" class="primary_select mb-15 edit_category">
                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                    @foreach($categories as $key => $category)
                                                                        @if($category->status == 1)
                                                                            <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                        @endif
                                                                        @if(count($category->subCategories) > 0)
                                                                            @foreach($category->subCategories as $subItem)
                                                                                @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>


                                                        </div>
                                                        @elseif($element->type == 'page')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                                <select name="page" class="primary_select mb-15 edit_page">
                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                    @foreach($pages as $key => $page)
                                                                    <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        @elseif($element->type == 'product')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                                <select name="product" class="primary_select mb-15 edit_product">
                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                    @foreach($products as $key => $product)
                                                                    <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        @elseif($element->type == 'brand')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                                <select name="brand" class="primary_select mb-15 edit_brand">
                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                    @foreach($brands as $key => $brand)
                                                                    <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        @elseif($element->type == 'tag')
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                                <select name="tag" class="primary_select mb-15 edit_tag">
                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                    @foreach($tags as $key => $tag)
                                                                    <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        @endif

                                                        <div class="col-xl-12">
                                                            <div class="primary_input">
                                                                <label class="primary_input_label" for="">{{ __('common.show') }}</label>
                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                    <li>
                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                            <input name="show" {{$element->show == 1?'checked':''}} id="show_active" value="1" checked="true" class="active"
                                                                                type="radio">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                        <p>{{ __('menu.left') }}</p>
                                                                    </li>
                                                                    <li>
                                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                            <input name="show" {{$element->show == 0?'checked':''}} value="0" id="show_inactive" class="de_active" type="radio">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                        <p>{{ __('menu.right') }}</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input">
                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                    <li>
                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                            <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                        <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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


                                    <ol class="dd-list">
                                        @foreach($element->childs as $key => $element)
                                        <li class="dd-item" data-id="{{$element->id}}">
                                            <div class="card accordion_card" id="accordion_{{$element->id}}">
                                                <div class="card-header item_header" id="heading_{{$element->id}}">
                                                    <div class="dd-handle">
                                                        <div class="pull-left">
                                                            @if($element->type == 'category')
                                                            {{@$element->title}} ({{ __('common.category') }})

                                                            @elseif($element->type == 'link')
                                                            {{@$element->title}} ({{__('common.link')}})

                                                            @elseif($element->type == 'page')
                                                            {{@$element->title}} ({{__('common.page')}})

                                                            @elseif($element->type == 'product')
                                                            {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                                            ({{__('common.product')}})

                                                            @elseif($element->type == 'brand')
                                                            {{@$element->title}} ({{__('product.brand')}})

                                                            @elseif($element->type == 'tag')
                                                            {{@$element->title}} ({{__('common.tag')}})

                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="pull-right btn_div">
                                                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}" class="primary-btn btn_zindex panel-title">{{__('common.edit')}} <span class="collapge_arrow_normal"></span></a>
                                                        <a href="" data-id="{{$element->id}}" class="primary-btn element_delete_btn btn_zindex"><i class="ti-close"></i></a>
                                                    </div>
                                                </div>
                                                <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                                    <div class="card-body">
                                                        <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                                            <div class="row">
                                                                <input type="hidden" name="id" value="{{$element->id}}">
                                                                <input type="hidden" name="type" value="{{$element->type}}">


                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="title">
                                                                            {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                                        <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                                    </div>
                                                                </div>

                                                                @if($element->type == 'link')

                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="link">
                                                                            {{__('common.link')}}

                                                                        </label>
                                                                        <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                                    </div>
                                                                </div>

                                                                @elseif($element->type == 'category')
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                        <select name="category" class="primary_select mb-15 edit_category">
                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                            @foreach($categories as $key => $category)
                                                                                @if($category->status == 1)
                                                                                    <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                                @endif
                                                                                @if(count($category->subCategories) > 0)
                                                                                    @foreach($category->subCategories as $subItem)
                                                                                        @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger"></span>
                                                                    </div>


                                                                </div>
                                                                @elseif($element->type == 'page')
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                                        <select name="page" class="primary_select mb-15 edit_page">
                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                            @foreach($pages as $key => $page)
                                                                            <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger"></span>
                                                                    </div>

                                                                </div>
                                                                @elseif($element->type == 'product')
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                                        <select name="product" class="primary_select mb-15 edit_product">
                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                            @foreach($products as $key => $product)
                                                                            <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger"></span>
                                                                    </div>

                                                                </div>
                                                                @elseif($element->type == 'brand')
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                                        <select name="brand" class="primary_select mb-15 edit_brand">
                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                            @foreach($brands as $key => $brand)
                                                                            <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                                @elseif($element->type == 'tag')
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                                        <select name="tag" class="primary_select mb-15 edit_tag">
                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                            @foreach($tags as $key => $tag)
                                                                            <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                                @endif

                                                                <div class="col-xl-12">
                                                                    <div class="primary_input">
                                                                        <label class="primary_input_label" for="">{{ __('common.show') }}</label>
                                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                                            <li>
                                                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                    <input name="show" {{$element->show == 1?'checked':''}} id="show_active" value="1" checked="true" class="active"
                                                                                        type="radio">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                                <p>{{ __('menu.left') }}</p>
                                                                            </li>
                                                                            <li>
                                                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                                    <input name="show" {{$element->show == 0?'checked':''}} value="0" id="show_inactive" class="de_active" type="radio">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                                <p>{{ __('menu.right') }}</p>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input">
                                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                                            <li>
                                                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                    <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                                <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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

                                            <ol class="dd-list">
                                                @foreach($element->childs as $key => $element)
                                                <li class="dd-item" data-id="{{$element->id}}">
                                                    <div class="card accordion_card" id="accordion_{{$element->id}}">
                                                        <div class="card-header item_header" id="heading_{{$element->id}}">
                                                            <div class="dd-handle">
                                                                <div class="pull-left">
                                                                    @if($element->type == 'category')
                                                                    {{@$element->title}} ({{ __('common.category') }})

                                                                    @elseif($element->type == 'link')
                                                                    {{@$element->title}} ({{__('common.link')}})

                                                                    @elseif($element->type == 'page')
                                                                    {{@$element->title}} ({{__('common.page')}})

                                                                    @elseif($element->type == 'product')
                                                                    {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                                                    ({{__('common.product')}})

                                                                    @elseif($element->type == 'brand')
                                                                    {{@$element->title}} ({{__('product.brand')}})

                                                                    @elseif($element->type == 'tag')
                                                                    {{@$element->title}} ({{__('common.tag')}})

                                                                    @endif
                                                                </div>

                                                            </div>
                                                            <div class="pull-right btn_div">
                                                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}" class="primary-btn btn_zindex panel-title">{{__('common.edit')}} <span class="collapge_arrow_normal"></span></a>
                                                                <a href="" data-id="{{$element->id}}" class="primary-btn element_delete_btn btn_zindex"><i class="ti-close"></i></a>
                                                            </div>
                                                        </div>
                                                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                                            <div class="card-body">
                                                                <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                                                    <div class="row">
                                                                        <input type="hidden" name="id" value="{{$element->id}}">
                                                                        <input type="hidden" name="type" value="{{$element->type}}">

                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label" for="title">
                                                                                    {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                                                <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                                            </div>
                                                                        </div>

                                                                        @if($element->type == 'link')

                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label" for="link">
                                                                                    {{__('common.link')}}

                                                                                </label>
                                                                                <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                                            </div>
                                                                        </div>

                                                                        @elseif($element->type == 'category')
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                                <select name="category" class="primary_select mb-15 edit_category">
                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                    @foreach($categories as $key => $category)
                                                                                        @if($category->status == 1)
                                                                                            <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                                        @endif
                                                                                        @if(count($category->subCategories) > 0)
                                                                                            @foreach($category->subCategories as $subItem)
                                                                                                @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger"></span>
                                                                            </div>


                                                                        </div>
                                                                        @elseif($element->type == 'page')
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                                                <select name="page" class="primary_select mb-15 edit_page">
                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                    @foreach($pages as $key => $page)
                                                                                    <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger"></span>
                                                                            </div>

                                                                        </div>
                                                                        @elseif($element->type == 'product')
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                                                <select name="product" class="primary_select mb-15 edit_product">
                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                    @foreach($products as $key => $product)
                                                                                    <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        @elseif($element->type == 'brand')
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                                                <select name="brand" class="primary_select mb-15 edit_brand">
                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                    @foreach($brands as $key => $brand)
                                                                                    <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        @elseif($element->type == 'tag')
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                                                <select name="tag" class="primary_select mb-15 edit_tag">
                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                    @foreach($tags as $key => $tag)
                                                                                    <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                        </div>

                                                                        @endif

                                                                        <div class="col-xl-12">
                                                                            <div class="primary_input">
                                                                                <label class="primary_input_label" for="">{{ __('common.show') }}</label>
                                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                                    <li>
                                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                            <input name="show" {{$element->show == 1?'checked':''}} id="show_active" value="1" checked="true" class="active"
                                                                                                type="radio">
                                                                                            <span class="checkmark"></span>
                                                                                        </label>
                                                                                        <p>{{ __('menu.left') }}</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                                            <input name="show" {{$element->show == 0?'checked':''}} value="0" id="show_inactive" class="de_active" type="radio">
                                                                                            <span class="checkmark"></span>
                                                                                        </label>
                                                                                        <p>{{ __('menu.right') }}</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-12">
                                                                            <div class="primary_input">
                                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                                    <li>
                                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                            <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                                                            <span class="checkmark"></span>
                                                                                        </label>
                                                                                        <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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

                                                    <ol class="dd-list">
                                                        @foreach($element->childs as $key => $element)
                                                        <li class="dd-item" data-id="{{$element->id}}">
                                                            <div class="card accordion_card" id="accordion_{{$element->id}}">
                                                                <div class="card-header item_header" id="heading_{{$element->id}}">
                                                                    <div class="dd-handle">
                                                                        <div class="pull-left">
                                                                            @if($element->type == 'category')
                                                                            {{@$element->title}} ({{ __('common.category') }})

                                                                            @elseif($element->type == 'link')
                                                                            {{@$element->title}} ({{__('common.link')}})

                                                                            @elseif($element->type == 'page')
                                                                            {{@$element->title}} ({{__('common.page')}})

                                                                            @elseif($element->type == 'product')
                                                                            {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                                                            ({{__('common.product')}})

                                                                            @elseif($element->type == 'brand')
                                                                            {{@$element->title}} ({{__('product.brand')}})

                                                                            @elseif($element->type == 'tag')
                                                                            {{@$element->title}} ({{__('common.tag')}})

                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                    <div class="pull-right btn_div">
                                                                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}" class="primary-btn btn_zindex panel-title">{{__('common.edit')}} <span class="collapge_arrow_normal"></span></a>
                                                                        <a href="" data-id="{{$element->id}}" class="primary-btn element_delete_btn btn_zindex"><i class="ti-close"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                                                    <div class="card-body">
                                                                        <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                                                            <div class="row">
                                                                                <input type="hidden" name="id" value="{{$element->id}}">
                                                                                <input type="hidden" name="type" value="{{$element->type}}">


                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-25">
                                                                                        <label class="primary_input_label" for="title">
                                                                                            {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                                                        <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                                                    </div>
                                                                                </div>

                                                                                @if($element->type == 'link')

                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-25">
                                                                                        <label class="primary_input_label" for="link">
                                                                                            {{__('common.link')}}

                                                                                        </label>
                                                                                        <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                                                    </div>
                                                                                </div>

                                                                                @elseif($element->type == 'category')
                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-15">
                                                                                        <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                                        <select name="category" class="primary_select mb-15 edit_category">
                                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                            @foreach($categories as $key => $category)
                                                                                                @if($category->status == 1)
                                                                                                    <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                                                @endif
                                                                                                @if(count($category->subCategories) > 0)
                                                                                                    @foreach($category->subCategories as $subItem)
                                                                                                        @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <span class="text-danger"></span>
                                                                                    </div>


                                                                                </div>
                                                                                @elseif($element->type == 'page')
                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-15">
                                                                                        <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                                                        <select name="page" class="primary_select mb-15 edit_page">
                                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                            @foreach($pages as $key => $page)
                                                                                            <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <span class="text-danger"></span>
                                                                                    </div>

                                                                                </div>
                                                                                @elseif($element->type == 'product')
                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-15">
                                                                                        <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                                                        <select name="product" class="primary_select mb-15 edit_product">
                                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                            @foreach($products as $key => $product)
                                                                                            <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>

                                                                                </div>
                                                                                @elseif($element->type == 'brand')
                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-15">
                                                                                        <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                                                        <select name="brand" class="primary_select mb-15 edit_brand">
                                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                            @foreach($brands as $key => $brand)
                                                                                            <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>

                                                                                </div>

                                                                                @elseif($element->type == 'tag')
                                                                                <div class="col-lg-12">
                                                                                    <div class="primary_input mb-15">
                                                                                        <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                                                        <select name="tag" class="primary_select mb-15 edit_tag">
                                                                                            <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                            @foreach($tags as $key => $tag)
                                                                                            <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>

                                                                                </div>

                                                                                @endif

                                                                                <div class="col-xl-12">
                                                                                    <div class="primary_input">
                                                                                        <label class="primary_input_label" for="">{{ __('common.show') }}</label>
                                                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                                                            <li>
                                                                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                                    <input name="show" {{$element->show == 1?'checked':''}} id="show_active" value="1" checked="true" class="active"
                                                                                                        type="radio">
                                                                                                    <span class="checkmark"></span>
                                                                                                </label>
                                                                                                <p>{{ __('menu.left') }}</p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                                                    <input name="show" {{$element->show == 0?'checked':''}} value="0" id="show_inactive" class="de_active" type="radio">
                                                                                                    <span class="checkmark"></span>
                                                                                                </label>
                                                                                                <p>{{ __('menu.right') }}</p>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-12">
                                                                                    <div class="primary_input">
                                                                                        <ul id="theme_nav" class="permission_list sms_list ">
                                                                                            <li>
                                                                                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                                    <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                                                                    <span class="checkmark"></span>
                                                                                                </label>
                                                                                                <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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

                                                            <ol class="dd-list">
                                                                @foreach($element->childs as $key => $element)
                                                                <li class="dd-item" data-id="{{$element->id}}">
                                                                    <div class="card accordion_card" id="accordion_{{$element->id}}">
                                                                        <div class="card-header item_header" id="heading_{{$element->id}}">
                                                                            <div class="dd-handle">
                                                                                <div class="pull-left">
                                                                                    @if($element->type == 'category')
                                                                                    {{@$element->title}} ({{ __('common.category') }})

                                                                                    @elseif($element->type == 'link')
                                                                                    {{@$element->title}} ({{__('common.link')}})

                                                                                    @elseif($element->type == 'page')
                                                                                    {{@$element->title}} ({{__('common.page')}})

                                                                                    @elseif($element->type == 'product')
                                                                                    {{@$element->title}} @if(isModuleActive('MultiVendor')) [@if(@$element->product->seller->role->type == 'seller') {{@$element->product->seller->first_name}} @else Inhouse @endif] @endif 
                                                                                    ({{__('common.product')}})

                                                                                    @elseif($element->type == 'brand')
                                                                                    {{@$element->title}} ({{__('product.brand')}})

                                                                                    @elseif($element->type == 'tag')
                                                                                    {{@$element->title}} ({{__('common.tag')}})

                                                                                    @endif
                                                                                </div>

                                                                            </div>
                                                                            <div class="pull-right btn_div">
                                                                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}" class="primary-btn btn_zindex panel-title">{{__('common.edit')}} <span class="collapge_arrow_normal"></span></a>
                                                                                <a href="" data-id="{{$element->id}}" class="primary-btn element_delete_btn btn_zindex"><i class="ti-close"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                                                                            <div class="card-body">
                                                                                <form enctype="multipart/form-data" id="elementEditForm" data-element_type = "{{$element->type}}">
                                                                                    <div class="row">
                                                                                        <input type="hidden" name="id" value="{{$element->id}}">
                                                                                        <input type="hidden" name="type" value="{{$element->type}}">

                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-25">
                                                                                                <label class="primary_input_label" for="title">
                                                                                                    {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                                                                <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" {{$element->type =='tag'?'readonly':'' }} required>
                                                                                            </div>
                                                                                        </div>

                                                                                        @if($element->type == 'link')

                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-25">
                                                                                                <label class="primary_input_label" for="link">
                                                                                                    {{__('common.link')}}

                                                                                                </label>
                                                                                                <input class="primary_input_field link" type="text" name="link" autocomplete="off" value="{{$element->link}}"  placeholder="{{__('common.link')}}">
                                                                                            </div>
                                                                                            <span class="text-danger" id="error_name"></span>
                                                                                        </div>

                                                                                        @elseif($element->type == 'category')
                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-15">
                                                                                                <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                                                <select name="category" class="primary_select mb-15 edit_category">
                                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                                    @foreach($categories as $key => $category)
                                                                                                        @if($category->status == 1)
                                                                                                            <option {{$element->element_id == $category->id?'selected':'' }} value="{{$category->id}}"><span>-></span> {{$category->name}}</option>
                                                                                                        @endif
                                                                                                        @if(count($category->subCategories) > 0)
                                                                                                            @foreach($category->subCategories as $subItem)
                                                                                                                @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                                                                            @endforeach
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                                <span class="text-danger"></span>
                                                                                            </div>


                                                                                        </div>
                                                                                        @elseif($element->type == 'page')
                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-15">
                                                                                                <label class="primary_input_label" for="">{{ __('common.page') }} <span class="text-danger">*</span></label>
                                                                                                <select name="page" class="primary_select mb-15 edit_page">
                                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                                    @foreach($pages as $key => $page)
                                                                                                    <option {{$element->element_id == $page->id?'selected':'' }} value="{{$page->id}}">{{$page->title}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                                <span class="text-danger"></span>
                                                                                            </div>

                                                                                        </div>
                                                                                        @elseif($element->type == 'product')
                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-15">
                                                                                                <label class="primary_input_label" for="">{{__('common.product')}} <span class="text-danger">*</span></label>
                                                                                                <select name="product" class="primary_select mb-15 edit_product">
                                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                                    @foreach($products as $key => $product)
                                                                                                    <option {{$element->element_id == $product->id?'selected':'' }} value="{{$product->id}}">{{$product->product->product_name}} @if(isModuleActive('MultiVendor')) [{{@$product->seller->first_name}}] @endif</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        @elseif($element->type == 'brand')
                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-15">
                                                                                                <label class="primary_input_label" for="">{{__('product.brand')}} <span class="text-danger">*</span></label>
                                                                                                <select name="brand" class="primary_select mb-15 edit_brand">
                                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                                    @foreach($brands as $key => $brand)
                                                                                                    <option {{$element->element_id == $brand->id?'selected':'' }} value="{{$brand->id}}">{{$brand->name}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>

                                                                                        @elseif($element->type == 'tag')
                                                                                        <div class="col-lg-12">
                                                                                            <div class="primary_input mb-15">
                                                                                                <label class="primary_input_label" for="">{{__('common.tag')}} <span class="text-danger">*</span></label>
                                                                                                <select name="tag" class="primary_select mb-15 edit_tag">
                                                                                                    <option selected disabled value="">{{__('common.select_one')}}</option>
                                                                                                    @foreach($tags as $key => $tag)
                                                                                                    <option {{$element->element_id == $tag->id?'selected':'' }} value="{{$tag->id}}">{{$tag->name}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>

                                                                                        @endif

                                                                                        <div class="col-xl-12">
                                                                                            <div class="primary_input">
                                                                                                <label class="primary_input_label" for="">{{ __('common.show') }}</label>
                                                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                                                    <li>
                                                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                                            <input name="show" {{$element->show == 1?'checked':''}} id="show_active" value="1" checked="true" class="active"
                                                                                                                type="radio">
                                                                                                            <span class="checkmark"></span>
                                                                                                        </label>
                                                                                                        <p>{{ __('menu.left') }}</p>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                                                                            <input name="show" {{$element->show == 0?'checked':''}} value="0" id="show_inactive" class="de_active" type="radio">
                                                                                                            <span class="checkmark"></span>
                                                                                                        </label>
                                                                                                        <p>{{ __('menu.right') }}</p>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-xl-12">
                                                                                            <div class="primary_input">
                                                                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                                                                    <li>
                                                                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                                                            <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                                                                            <span class="checkmark"></span>
                                                                                                        </label>
                                                                                                        <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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



                                                                </li>
                                                                @endforeach

                                                            </ol>
                                                        </li>
                                                        @endforeach

                                                    </ol>
                                                </li>
                                                @endforeach

                                            </ol>

                                        </li>
                                        @endforeach

                                    </ol>
                                </li>
                                @endforeach

                            </ol>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center">
                no elements
            </div>
        </div>
        @endif

    @elseif($menu->menu_type == 'multi_mega_menu')
    <div class="white-box p-15">
        <h4 class="mb-10">Menu List</h4>
        <div id="menuDiv" class="minh-250">
            @if(count(@$menu->menus)>0)
            @foreach(@$menu->menus as $key => $element)
            <div class="col-lg-12 single_item" data-id="{{$element->id}}" >
                <div class="mb-10">
                    <div class="card" id="accordion_{{$element->id}}">
                        <div class="card-header card_header_element">
                            <p class="d-inline">
                                @if(@$element->menu->menu_type == 'mega_menu')
                                    {{@$element->title}} (mega menu)

                                @elseif(@$element->menu->menu_type == 'normal_menu')
                                    {{@$element->title}} (normal menu)

                                @endif
                            </p>
                            <div class="pull-right">
                                <a href="{{route('menu.setup',$element->menu->id)}}" target="_blank" class=" d-inline  mr-10 primary-btn">Setup</a>


                                <a href="javascript:void(0);" class=" d-inline  mr-10 primary-btn panel-title" data-toggle="collapse" data-target="#collapse_{{$element->id}}" aria-expanded="false" aria-controls="collapse_{{$element->id}}">{{__('common.edit')}} <span class="collapge_arrow"></span></a>
                                <a href="" data-id="{{$element->id}}" class="d-inline primary-btn menu_delete_btn"><i class="ti-close"></i></a>
                            </div>

                        </div>
                        <div id="collapse_{{$element->id}}" class="collapse" aria-labelledby="heading_{{$element->id}}" data-parent="#accordion_{{$element->id}}">
                            <div class="card-body">
                                <form enctype="multipart/form-data" id="menuEditForm">
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{$element->id}}">

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="title">
                                                    {{__('marketing.navigation_label')}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field title" type="text" name="title" autocomplete="off" value="{{$element->title}}"  placeholder="{{__('marketing.navigation_label')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('menu.menu')}} <span class="text-danger">*</span></label>
                                                <select name="menu" class="primary_select mb-15 edit_menu">
                                                    @foreach($menus as $key => $item)
                                                    <option {{$element->menu_id == $item->id? 'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input">
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="is_newtab" id="is_newtab" value="1" {{$element->is_newtab == 1? 'checked':''}} type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
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
                no menus
            </div>
            @endif
        </div>
    </div>

    @endif
</div>
