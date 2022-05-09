@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {
                ipDataTable();

                $(document).on("submit", "#unitForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('ignore_ip_list_store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}");
                            $("#unitForm").trigger("reset");
                            $("#list").html(response.ip_list);
                            ipDataTable();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            if (response) {
                                $.each(response.responseJSON.errors, function (key, message) {
                                    $("#" + key + "_error").html(message[0]);
                                });
                            }
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.delete_unit', function(event){
                    event.preventDefault();
                    let route = $(this).data('value');
                    confirm_modal(route);
                });

                function ipDataTable(){

                    $('#ip_list_datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ({
                            url: "{{ route('ignore_ip_list_data') }}"
                        }),
                        "initComplete": function(json) {

                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'id'
                            },
                            {
                                data: 'ip',
                                name: 'ip'
                            },
                            {
                                data: 'action',
                                name: 'action'
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
