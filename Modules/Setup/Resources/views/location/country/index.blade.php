@extends('backEnd.master')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/setup/css/country.css'))}}" />

@endsection

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                @if (permissionCheck('setup.country.store'))
                    <div class="col-lg-4">
                        <div class="row">
                            <div id="formHtml" class="col-lg-12">
                                @include('setup::location.country.components.create')
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-8">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.country') }} {{ __('common.list')  }}</h3>


                            </div>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">

                                @include('setup::location.country.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@include('setup::location.country.components.scripts')
