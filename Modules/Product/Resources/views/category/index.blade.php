@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />

<link rel="stylesheet" href="{{asset(asset_path('modules/product/css/style.css'))}}" />
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        @include('product::category.components.show')
        @if (permissionCheck('product.category.delete'))
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __("common.category")])
        @endif
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                @if (permissionCheck('product.category.store'))
                    <div class="col-lg-4">
                        <div class="row">
                            <div id="formHtml" class="col-lg-12">
                                @include('product::category.components.create')
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-8 list_div">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.category_list')}}</h3>
                            @if (permissionCheck('product.csv_category_download'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('product.csv_category_download') }}"><i class="ti-download"></i>{{ __('product.category_csv') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="item_table">
                                    @include('product::category.components.list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </section>
@endsection

@include('product::category.components.scripts')
