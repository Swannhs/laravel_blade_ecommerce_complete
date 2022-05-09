@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/review/css/style.css'))}}" />


@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center">

            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav" role="tablist">
                            @if (permissionCheck('review.product.get-all-data'))
                                <li class="nav-item">
                                    <a class="nav-link active show" href="#all_review" role="tab"
                                        data-toggle="tab" id="product_list_id" aria-selected="true">{{__('review.all_review')}}</a>
                                </li>
                            @endif
                            @if (permissionCheck('review.product.get-pending-data'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#pending_review" role="tab" data-toggle="tab" id="product_request_id"
                                        aria-selected="true">{{__('common.pending')}}</a>
                                </li>
                            @endif
                            @if (permissionCheck('review.product.get-declined-data'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#declined_review" role="tab" data-toggle="tab" id="product_sku_id"
                                        aria-selected="true">{{__('common.declined')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active show" id="all_review">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('review.all_product_review_list')}}</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div class="" id="all_item_table">
                                        @include('review::product_review.components.all_list')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="pending_review">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('review.pending_product_review_list')}}</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div class="" id="pending_item_table">
                                        @include('review::product_review.components.pending_list')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="declined_review">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('review.declined_review_list')}}</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div class="" id="declined_item_table">
                                        @include('review::product_review.components.declined_list')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="approveModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('review.approve_all_review')}} </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('review.approve_confirm')}}</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.cancel')}}</button>
                        <form id="approveAllForm">
                            <input id="dataApproveBtn" type="submit" class="primary-btn fix-gr-bg" value="{{__('review.approve')}}"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteItemModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('review.deny_review')}} </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('review.deny_confirm')}}</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.cancel')}}</button>
                        <form id="item_delete_form">
                            <input type="hidden" name="id" id="delete_item_id">
                            <input id="dataDeleteBtn" type="submit" class="primary-btn fix-gr-bg" value="{{__('review.deny')}}"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";

            $(document).ready(function(){

                allReviewDatatable();
                approveReviewDatatable();
                declinedReviewDatatable();

                $(document).on('submit','#approveAllForm', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    $('#approveModal').modal('hide');
                    $.ajax({
                        url: "{{ route('review.product.approve-all') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            toastr.success("{{__('common.approved_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}','{{__("common.error")}}');
                        }
                    });
                });

                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteItemModal').modal('hide');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('review.product.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            toastr.error('{{ __("common.error_message") }}','{{__("common.error")}}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.approve_single', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    approveReview(id);
                });

                function approveReview(id){
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    $.ajax({
                        url: "{{ route('review.product.approve') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            toastr.success("{{__('common.approved_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}','{{__("common.error")}}');
                        }
                    });
                }

                $(document).on('click', '.approve_all', function(event){
                    event.preventDefault();
                    $('#approveModal').modal('show');
                });

                $(document).on('click', '.delete_review', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });

                function reloadWithData(response){

                    $('#all_item_table').html(response.allTableData);
                    $('#pending_item_table').html(response.pendingTableData);
                    $('#declined_item_table').html(response.declinedTableData);
                    allReviewDatatable();
                    approveReviewDatatable();
                    declinedReviewDatatable();

                }
                function allReviewDatatable(){

                    var url = "{{route('review.product.get-all-data')}}";
                    $('#allReviewTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: url
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'rating', name: 'rating' },
                            { data: 'customer_feedback', name: 'customer_feedback' },
                            { data: 'status', name: 'status' },
                            { data: 'customer_time', name: 'customer_time' },
                            { data: 'approve', name: 'approve' }

                        ],

                        bLengthChange: false,
                        "bDestroy": true,
                        language: {
                            search: "<i class='ti-search'></i>",
                            searchPlaceholder: trans('common.quick_search'),
                            paginate: {
                                next: "<i class='ti-arrow-right'></i>",
                                previous: "<i class='ti-arrow-left'></i>"
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'copyHtml5',
                                text: '<i class="fa fa-files-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'Copy',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel',
                                title: $("#logo_title").val(),
                                margin: [10, 10, 10, 0],
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },

                            },
                            {
                                extend: 'csvHtml5',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'PDF',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },
                                orientation: 'landscape',
                                pageSize: 'A4',
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                header: true,
                                customize: function (doc) {
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: "data:image/png;base64," + $("#logo_img").val()
                                    });
                                }

                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Print',
                                title: $("#logo_title").val(),
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'colvis',
                                text: '<i class="fa fa-columns"></i>',
                                postfixButtons: ['colvisRestore']
                            }
                        ],
                        columnDefs: [{
                            visible: false
                        }],
                        responsive: true,
                    });
                }

                function approveReviewDatatable(){

                    var url = "{{route('review.product.get-pending-data')}}";
                    $('#approveReviewTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: url
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'rating', name: 'rating' },
                            { data: 'customer_feedback', name: 'customer_feedback' },
                            { data: 'customer_time', name: 'customer_time' },
                            { data: 'approve', name: 'approve' }

                        ],

                        bLengthChange: false,
                        "bDestroy": true,
                        language: {
                            search: "<i class='ti-search'></i>",
                            searchPlaceholder: trans('common.quick_search'),
                            paginate: {
                                next: "<i class='ti-arrow-right'></i>",
                                previous: "<i class='ti-arrow-left'></i>"
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'copyHtml5',
                                text: '<i class="fa fa-files-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'Copy',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel',
                                title: $("#logo_title").val(),
                                margin: [10, 10, 10, 0],
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },

                            },
                            {
                                extend: 'csvHtml5',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'PDF',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },
                                orientation: 'landscape',
                                pageSize: 'A4',
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                header: true,
                                customize: function (doc) {
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: "data:image/png;base64," + $("#logo_img").val()
                                    });
                                }

                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Print',
                                title: $("#logo_title").val(),
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'colvis',
                                text: '<i class="fa fa-columns"></i>',
                                postfixButtons: ['colvisRestore']
                            }
                        ],
                        columnDefs: [{
                            visible: false
                        }],
                        responsive: true,
                    });
                }

                function declinedReviewDatatable(){

                    var url = "{{route('review.product.get-declined-data')}}";
                    $('#declinedReviewTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: url
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'rating', name: 'rating' },
                            { data: 'customer_feedback', name: 'customer_feedback' },
                            { data: 'customer_time', name: 'customer_time' },
                            { data: 'approve', name: 'approve' }

                        ],

                        bLengthChange: false,
                        "bDestroy": true,
                        language: {
                            search: "<i class='ti-search'></i>",
                            searchPlaceholder: trans('common.quick_search'),
                            paginate: {
                                next: "<i class='ti-arrow-right'></i>",
                                previous: "<i class='ti-arrow-left'></i>"
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'copyHtml5',
                                text: '<i class="fa fa-files-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'Copy',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel',
                                title: $("#logo_title").val(),
                                margin: [10, 10, 10, 0],
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },

                            },
                            {
                                extend: 'csvHtml5',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'PDF',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },
                                orientation: 'landscape',
                                pageSize: 'A4',
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                header: true,
                                customize: function (doc) {
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: "data:image/png;base64," + $("#logo_img").val()
                                    });
                                }

                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Print',
                                title: $("#logo_title").val(),
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'colvis',
                                text: '<i class="fa fa-columns"></i>',
                                postfixButtons: ['colvisRestore']
                            }
                        ],
                        columnDefs: [{
                            visible: false
                        }],
                        responsive: true,
                    });
                }


            });
        })(jQuery);

    </script>
@endpush
