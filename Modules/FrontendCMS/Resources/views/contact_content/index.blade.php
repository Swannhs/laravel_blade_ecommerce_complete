@extends('backEnd.master')

@section('mainContent')
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('frontendCms.Inquery')])

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{ __('frontendCms.contact_us_contant') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        @if (permissionCheck('frontendcms.contact-content.update'))
                            @include('frontendcms::contact_content.components.form')
                        @endif

                        <div class="row">
                            @if (permissionCheck('frontendcms.query.store'))
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div id="formHtml" class="col-lg-12">
                                            @include('frontendcms::contact_content.components.create_query')
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-8">

                                <div class="row ">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 no-gutters">
                                                <div class="main-title">
                                                    <h3 class="mb-30">{{__('frontendCms.inquery_list')}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="QA_section QA_section_heading_custom check_box_table">
                                            <div class="QA_table">
                                                <div id="item_table">
                                                    @include('frontendcms::contact_content.components.query_list')
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
    </section>
@endsection

@include('frontendcms::contact_content.components.scripts')
