@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/style.css'))}}" />
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('marketing.bulk_sms')])
        <div class="container-fluid p-0">
            <div class="row">
                @csrf
                @if (permissionCheck('marketing.bulk-sms.store'))
                    <div id="form_div" class="col-lg-3">
                        @include('marketing::bulk_sms.components.create')
                    </div>
                @endif
                <div class="col-lg-9">

                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 no-gutters">
                                    <div class="main-title">
                                        <h3 class="mb-30">{{ __('marketing.sms_list') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="item_table">
                                @include('marketing::bulk_sms.components.list')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@include('marketing::bulk_sms.components._scripts')
