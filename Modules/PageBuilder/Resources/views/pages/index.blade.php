@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('page-builder.Pages')}}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('page_builder.pages.store'))
                                    <li>
                                        <a  data-toggle="modal" data-target="#add_page_modal" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#">
                                            <i class="ti-plus"></i> {{ __('page-builder.Add New') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="" id="lms_data_table">
                                @include('pagebuilder::pages.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="append_html"></div>
        @include('pagebuilder::_deleteModalForAjax',['item_name' => __("page-builder.Page")])
        @include('pagebuilder::pages.create')
        <input type="hidden" value="{{route('page_builder.pages.destroy')}}" id="delete_url">
        <input type="hidden" value="{{route('page_builder.pages.store')}}" id="store_url">
        <input type="hidden" value="{{route('page_builder.pages.edit',':id')}}" id="edit_url">
        <input type="hidden" value="{{route('page_builder.pages.update',':id')}}" id="update_url">
        <input type="hidden" value="{{route('page_builder.pages.status')}}" id="status_change_url">
        <input type="hidden" value="{{route('page_builder.slug_generate')}}" id="slug_generate_url">
    </section>
@endsection
@push('scripts')
    <script src="{{asset('Modules/PageBuilder/Resources/assets/js/datatable_active.js')}}"></script>
    <script src="{{asset('Modules/PageBuilder/Resources/assets/js/pages.js')}}"></script>
@endpush
