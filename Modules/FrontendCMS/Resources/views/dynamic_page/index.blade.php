@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/frontendcms/css/style.css'))}}" />

@endsection
@section('mainContent')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('frontendCms.dynamic_page')])
    <section class="admin-visitor-area up_st_admin_visitor">

        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('frontendCms.page_list') }}</h3>
                            @if (permissionCheck('frontendcms.dynamic-page.store'))
                                <ul class="d-flex">
                                    <li><a href="{{ route('frontendcms.dynamic-page.create') }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i
                                                class="ti-plus"></i>{{ __('common.add_new') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">
                                @include('frontendcms::dynamic_page.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@include('frontendcms::dynamic_page.components.scripts')
