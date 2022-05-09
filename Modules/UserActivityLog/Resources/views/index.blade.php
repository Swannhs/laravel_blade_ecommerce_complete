@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('common.activity_logs') }}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('activity_log.destroy_all'))
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="" id="clear_log_btn"><i class="ti-plus"></i>{{__('common.clean_all')}}</a></li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="table-responsive" id="log_table_div">
                                @include('useractivitylog::components.log_list')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __("common.activity_logs")])
    </section>
@endsection

@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                activeDataTable();

                $(document).on('click', '#clear_log_btn', function(event){
                    event.preventDefault();
                    $('#deleteItemModal').modal('show');
                });

                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#deleteItemModal').modal('hide');
                    $("#pre-loader").removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('activity_log.destroy_all') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#log_table_div').html(response.log_lists);
                            $("#pre-loader").addClass('d-none');
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                            activeDataTable();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });

                function activeDataTable(){
                    var url = "{{ route('activity_log.get-data') }}";
                    $('#activityDataTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ({
                            url: url
                        }),
                        "initComplete": function(json) {

                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'id'
                            },
                            {
                                data: 'type',
                                name: 'type'
                            },
                            {
                                data: 'subject',
                                name: 'subject'
                            },

                            {
                                data: 'url',
                                name: 'url'
                            },
                            {
                                data: 'ip',
                                name: 'ip'
                            },
                            {
                                data: 'agent',
                                name: 'agent'
                            },
                            {
                                data: 'attempt_at',
                                name: 'attempt_at'
                            },
                            {
                                data: 'user_name',
                                name: 'user_name'
                            }

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
                                customize: function(doc) {
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: "data:image/png;base64," + $("#logo_img")
                                            .val()
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
