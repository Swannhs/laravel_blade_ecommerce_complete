@extends('backEnd.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
        .iconpicker-popover.popover {
            width: 90%!important;
        }
        @media (max-width: 768px){
            .common_table_header .main-title {

                margin-top: 20px;
                margin-bottom: 0px;
            }
        }
    </style>
@endsection

@section('mainContent')

    @include("backEnd.partials._alertMessagePageLevelAll")

    <section class="admin-visitor-area up_st_admin_visitor">


        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.feature')])

        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-lg-4">
                    <div class="row">
                        <div id="formHtml" class="col-lg-12">
                            @include('frontendcms::feature.components.create')
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.feature') }} {{ __('common.list')  }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">
                                {{-- feature List --}}
                                @include('frontendcms::feature.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- Page level scripts --}}
@include('frontendcms::feature.components.scripts')
