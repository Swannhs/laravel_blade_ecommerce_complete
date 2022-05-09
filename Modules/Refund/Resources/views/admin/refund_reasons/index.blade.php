@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="create_div">
                        @include('refund::admin.refund_reasons.create')
                    </div>
                    <div class="edit_div d-none">
                        @include('refund::admin.refund_reasons.edit')
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('refund.reason_list') }}</h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="refund_list">
                                    @include('refund::admin.refund_reasons.refund_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="app_base_url" id="app_base_url" value="{{ URL::to('/') }}">

@include('backEnd.partials.delete_modal')
@endsection
@include('refund::admin.refund_reasons.scripts')
