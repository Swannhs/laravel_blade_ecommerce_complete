@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="create_div">
                        @include('product::units.create')
                    </div>
                    <div class="edit_div d-none">
                        @include('product::units.edit')
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.units') }}</h3>
                            @if (permissionCheck('product.csv_unit_download'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('product.csv_unit_download') }}"><i class="ti-download"></i>{{ __('product.units_csv') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="unit_list">
                                    @include('product::units.units_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="app_base_url" id="app_base_url" value="{{ URL::to('/') }}">

@if (permissionCheck('product.units.destroy'))
    @include('backEnd.partials.delete_modal',['item_name' => __('product.unit')])
@endif
@endsection
@include('product::units.scripts')
