@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{ __('refund.pending_refund_requests') }}</h3>
                    </div>
                </div>
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <table id="refundTable" class="table Crm_table_active3">
                            <thead>
                                <tr>
                                    <th>{{ __('common.sl') }}</th>
                                    <th width="10%">{{ __('common.date') }}</th>
                                    <th>{{ __('common.order_id') }}</th>
                                    <th>{{ __('common.email') }}</th>
                                    <th>{{ __('common.total_amount') }}</th>
                                    <th>{{ __('refund.request_status') }}</th>
                                    <th>{{ __('refund.is_refunded') }}</th>
                                    <th>{{ __('common.action') }}</th>
                                </tr>
                            </thead>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            $('#refundTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('refund.all_refund_request_data') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                                { data: 'DT_RowIndex', name: 'id' },
                                { data: 'date', name: 'date' },
                                { data: 'order_id', name: 'order_id' },
                                { data: 'email', name: 'email' },
                                { data: 'total_amount', name: 'total_amount' },
                                { data: 'request_status', name: 'request_status' },
                                { data: 'is_refunded', name: 'is_refunded' },
                                { data: 'action', name: 'action' },
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

        })(jQuery);
    </script>
@endpush
