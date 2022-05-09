@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/frontendcms/css/working_process.css'))}}" />
  
@endsection

@section('mainContent')
@include('frontendcms::merchant.benefit.create')
@include('frontendcms::merchant.benefit.edit')
@include('frontendcms::merchant.working_process.create')
@include('frontendcms::merchant.working_process.edit')
@include('frontendcms::merchant.faq.create')
@include('frontendcms::merchant.faq.edit')
@include('frontendcms::merchant.components.deletemodal')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{ __('frontendCms.merchant_content') }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        @include('frontendcms::merchant.components.form')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@include('frontendcms::merchant.components.scripts')
