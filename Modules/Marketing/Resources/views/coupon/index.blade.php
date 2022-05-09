@extends('backEnd.master')

@section('mainContent')
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.coupon')])
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">

                @csrf
                @if (permissionCheck('marketing.coupon.store'))
                    <div id="form_div" class="col-lg-3">
                        @include('marketing::coupon.components.create')
                    </div>
                @endif
                <div class="col-lg-9">

                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 no-gutters">
                                    <div class="main-title">
                                        <h3 class="mb-30">{{ __('marketing.coupon_list') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div id="item_table">
                                        @include('marketing::coupon.components.list')
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

@include('marketing::coupon.components._scripts')
