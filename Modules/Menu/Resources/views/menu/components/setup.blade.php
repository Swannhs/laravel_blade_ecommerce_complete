@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/nestable2.css')) }}" />

<link rel="stylesheet" href="{{asset(asset_path('modules/menu/css/setup.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">

        @if($menu->menu_type == 'mega_menu')

        <div class="row">
            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#Setup" role="tab" data-toggle="tab" id="1"
                                    aria-selected="true">{{__('common.setup')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link show" href="#RightPanel" role="tab" data-toggle="tab" id="2"
                                    aria-selected="false">{{__('menu.right_panel')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link show" href="#BottomPanel" role="tab" data-toggle="tab" id="3"
                                    aria-selected="false">{{__('menu.bottom_panel')}}</a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @endif


        @if($menu->menu_type == 'mega_menu')

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade active show" id="Setup">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.setup_menu') }} -> {{$menu->name}}</h3>

                                    <ul class="d-flex">
                                        <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @include('menu::menu.components.create_element')
                        </div>

                        <div id="div333" class="col-lg-8">
                            @include('menu::menu.components.element_list')

                        </div>
                   </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="RightPanel">
                <div class="row">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.right_panel_setup') }} -> {{$menu->name}}</h3>

                                <ul class="d-flex">
                                    <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                </ul>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">

                            <div id="formHtml" class="col-lg-12 mb-20">


                                <div class="white-box minh-250">
                                    <div class="add-visitor">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="accordion_rightpanel_create">


                                                    <div class="card">
                                                        <div class="card-header" id="heading_rightpanel_create">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link add_btn_link collapsed" data-toggle="collapse"
                                                                    data-target="#menusrightpanel_create" aria-expanded="false" aria-controls="collapse_rightpanel_create">
                                                                    {{__('product.add_category')}}
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="menusrightpanel_create" class="collapse" aria-labelledby="heading_rightpanel_create"
                                                            data-parent="#accordion_rightpanel_create">
                                                            <div class="card-body">
                                                              <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-15">
                                                                        <label class="primary_input_label"
                                                                            for="">{{ __('common.category') }} <span
                                                                                class="text-danger">*</span></label>
                                                                        <select name="category" id="category_rightpanel"
                                                                            class="primary_select mb-15" multiple>
                                                                            @foreach ($categories->where('parent_id', 0) as $key => $category)
                                                                                <option value="{{ $category->id }}"><span>-></span> {{ $category->name }}</option>
                                                                                @if(count($category->subCategories) > 0)
                                                                                    @foreach($category->subCategories as $subItem)
                                                                                        @include('menu::menu.components._category_select_option',['subItem' => $subItem])
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger"></span>
                                                                    </div>


                                                                </div>
                                                                <div class="col-lg-12 text-center">
                                                                    <button id="add_category_rightpanel_btn" type="submit" class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip" title=""
                                                                        data-original-title="">
                                                                        <span class="ti-check"></span>
                                                                        {{__('common.save')}} </button>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8">
                        <div class="white-box p-15">
                            <h4 class="mb-10">{{__('common.category_list')}}</h4>
                            <div id="rightpanelListDiv" class="minh-250">
                                @include('menu::menu.components.rightpanel_category_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="BottomPanel">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.bottom_panel_setup') }} -> {{$menu->name}}</h3>

                                <ul class="d-flex">
                                    <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                </ul>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">


                            <div id="formHtml" class="col-lg-12 mb-20">

                                <div class="white-box minh-250">
                                    <div class="add-visitor">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="accordion_bottompanel_create">


                                                    <div class="card mb-10">
                                                        <div class="card-header" id="headingBrand_bottompanel_create">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link add_btn_link collapsed" data-toggle="collapse"
                                                                    data-target="#brands_bottompanel_create" aria-expanded="false"
                                                                    aria-controls="collapseBrand_bottompanel_create">
                                                                    {{__('menu.add_brand')}}
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="brands_bottompanel_create" class="collapse" aria-labelledby="headingBrand_bottompanel_create"
                                                            data-parent="#accordion_bottompanel_create">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="primary_input mb-15">
                                                                            <label class="primary_input_label" for="">{{ __('product.brand') }}
                                                                                <span class="text-danger">*</span></label>
                                                                            <select name="brand" id="brand_bottompanel" class="primary_select mb-15"
                                                                                multiple>
                                                                                @foreach ($brands as $key => $brand)
                                                                                    <option value="{{ $brand->id }}">
                                                                                        {{ $brand->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span
                                                                                class="text-danger"></span>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-12 text-center">
                                                                        <button id="add_brand_bottompanel_create_btn" type="submit"
                                                                            class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip"
                                                                            title="" data-original-title="">
                                                                            <span class="ti-check"></span>
                                                                            {{__('common.save')}} </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8">
                        <div class="white-box p-15">
                            <h4 class="mb-10">{{__('product.brand_list')}}</h4>
                            <div id="bottompanelListDiv" class="minh-250">
                                @include('menu::menu.components.bottompanel_brand_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.setup_menu') }} -> {{$menu->name}}</h3>

                            <ul class="d-flex">
                                <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                            </ul>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('menu::menu.components.create_element')
                </div>

                <div id="div333" class="col-lg-8">
                    @include('menu::menu.components.element_list')

                </div>
           </div>
        </div>
        @endif
    </section>
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.column'),'modal_id' => 'deleteColumnModal',
    'form_id' => 'column_delete_form','delete_item_id' => 'delete_column_id','dataDeleteBtn' =>'columnDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.element'),'modal_id' => 'deleteElementModal',
    'form_id' => 'element_delete_form','delete_item_id' => 'delete_element_id','dataDeleteBtn' =>'elementDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.menu'),'modal_id' => 'deleteMenuModal',
    'form_id' => 'menu_delete_form','delete_item_id' => 'delete_menu_id','dataDeleteBtn' =>'menuDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('common.category'),'modal_id' => 'deleteCategoryModal',
    'form_id' => 'category_delete_form','delete_item_id' => 'delete_category_id','dataDeleteBtn' =>'categoryDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('product.brand'),'modal_id' => 'deleteBrandModal',
    'form_id' => 'brand_delete_form','delete_item_id' => 'delete_brand_id','dataDeleteBtn' =>'brandDeleteBtn'])

@endsection

@include('menu::menu.components._setup_script')


