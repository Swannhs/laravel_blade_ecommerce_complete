@extends('backEnd.master')

@section('styles')
@endsection

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">

        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                @if (permissionCheck('setup.city.store'))
                    <div class="col-lg-3">
                        <div class="row">
                            <div id="formHtml" class="col-lg-12">
                                @include('setup::location.city.components.create')
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-9">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.city') }} {{ __('common.list')  }}</h3>


                            </div>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">

                                @include('setup::location.city.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@include('setup::location.city.components.scripts')
