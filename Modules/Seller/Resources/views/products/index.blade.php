@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/index.css'))}}" />
  
@endsection
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">

        <div class="container-fluid p-0">
            @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.product')])

            <div class="row">


                <div class="col-md-12 mb-20">
                    <div class="box_header_right">
                        <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                            <ul class="nav nav_list" role="tablist">
                                @if (permissionCheck('seller.product.index') || auth()->user()->role->type =="seller")
                                    <li class="nav-item" id="product_list_li">
                                        <a class="nav-link active show" href="#product_list" role="tab" data-toggle="tab" id="1" aria-selected="true">{{__('product.product_list')}}</a>
                                    </li>
                                @endif
                                @if (permissionCheck('seller_own_product') && auth()->user()->role->type != 'superadmin')
                                    <li class="nav-item" id="my_product_list_li">
                                        <a class="nav-link" href="#my_product_data" role="tab" data-toggle="tab" id="1" aria-selected="true">{{ __('product.my_product_list') }}</a>
                                    </li>
                                @endif
                                @if (permissionCheck('seller_alert_product'))
                                    <li class="nav-item" id="alert_product_list_li">
                                        <a class="nav-link" href="#alert_product_list" role="tab" data-toggle="tab" id="1" aria-selected="true">{{ __('product.alert_list') }}</a>
                                    </li>
                                @endif
                                @if (permissionCheck('seller_out_of_stock_product'))
                                    <li class="nav-item" id="stock_out_product_list_li">
                                        <a class="nav-link" href="#out_of_stock_product_list" role="tab" data-toggle="tab" id="1" aria-selected="true">{{ __('product.out_of_stock_list') }}</a>
                                    </li>
                                @endif
                                @if (permissionCheck('seller_disabled_product'))
                                    <li class="nav-item" id="disabled_product_list_li">
                                        <a class="nav-link" href="#disabled_product_list" role="tab" data-toggle="tab" id="1" aria-selected="true">{{ __('product.disabled_product_list') }}</a>
                                    </li>
                                @endif
                                @if (auth()->user()->role->type == "seller")
                                    @if (permissionCheck('seller.product.create'))
                                        <li class="nav-item">
                                            <a class="primary-btn radius_30px mr-10 fix-gr-bg add_new_product" href="{{ route('seller.product.create') }}"><i class="ti-plus"></i>{{ __('product.add_new_product') }}</a>
                                        </li>
                                    @endif
                                @else
                                    @if (permissionCheck('admin.my-product.create'))
                                        <li class="nav-item">
                                            <a class="primary-btn radius_30px mr-10 fix-gr-bg add_new_product" href="{{ route('admin.my-product.create') }}"><i class="ti-plus"></i>{{ __('product.add_new_product') }}</a>
                                        </li>
                                    @endif
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="white_box_30px mb_30">

                        <div class="tab-content">
                            @if (permissionCheck('seller.product.index'))
                                <div role="tabpanel" class="tab-pane fade active show" id="product_list">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.product_list')}}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="product_list_div">
                                                @include('seller::products.components.list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (permissionCheck('seller_own_product') && auth()->user()->role->type != 'superadmin')
                                <div role="tabpanel" class="tab-pane fade" id="my_product_data">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.my_product_list') }}</h3>

                                        </div>
                                    </div>

                                    <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="my_product_div">
                                                @include('product::products.product_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (permissionCheck('seller_alert_product'))
                                <div role="tabpanel" class="tab-pane fade" id="alert_product_list">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.alert_list') }}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="alert_div">
                                                @include('seller::products.components.alert_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (permissionCheck('seller_out_of_stock_product'))
                                <div role="tabpanel" class="tab-pane fade" id="out_of_stock_product_list">

                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.out_of_stock_list') }}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="stock_div">
                                                @include('seller::products.components.stock_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (permissionCheck('seller_disabled_product'))
                                <div role="tabpanel" class="tab-pane fade" id="disabled_product_list">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.disabled_product_list') }}</h3>
                                        </div>
                                    </div>

                                    <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="disabled_div">
                                                @include('seller::products.components.disabled_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div id="product_detail_view_div"></div>
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.product '),'form_id' =>
'product_delete_form','modal_id' => 'product_delete_modal', 'delete_item_id' => 'product_delete_id'])

@endsection

@include('seller::products.components.scripts')
