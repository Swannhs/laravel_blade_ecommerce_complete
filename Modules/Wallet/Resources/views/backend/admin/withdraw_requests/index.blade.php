@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('wallet.withdraw_requests') }} </h3>
                    </div>
                </div>
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <table class="table" id="withdrawTable">
                            <thead>
                                <tr>
                                    <th>{{__('common.sl')}}</th>
                                    <th>{{__('common.date')}}</th>
                                    <th>{{__('common.user')}}</th>
                                    <th>{{__('order.txn_id')}}</th>
                                    <th>{{__('common.amount')}}</th>
                                    <th>{{__('common.type')}}</th>
                                    <th>{{__('common.payment_method')}}</th>
                                    <th>{{__('common.approval')}}</th>
                                    <th>{{__('common.action')}}</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="app_base_url" id="app_base_url" value="{{ URL::to('/') }}">
</section>

<div id="show_modal_div"></div>
@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
        "use strict";

        $(document).ready(function(){
            $('#withdrawTable').DataTable({
                processing: true,
                serverSide: true,
                "ajax": ( {
                    url: "{{ route('wallet.withdraw_requests.get_data') }}"
                }),
                "initComplete":function(json){

                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'date', name: 'date' },
                    { data: 'user', name: 'user.first_name' },
                    { data: 'txn_id', name: 'txn_id' },
                    { data: 'amount', name: 'amount' },
                    { data: 'type', name: 'type' },
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'approval', name: 'approval' },
                    { data: 'action', name: 'action' }

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

            $(document).on('click', '.getDetails', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#pre-loader').removeClass('d-none');
                let baseUrl = $('#url').val();
                let url = baseUrl + '/wallet/withdraw-requests/show/' + id;
                $.get(url, function(response){
                    $('#show_modal_div').html(response);
                    $("#Withdraw_Modal").modal('show');
                    $('#pre-loader').addClass('d-none');
                    $('#status').niceSelect();
                });

            });

            var baseUrl = $('#app_base_url').val();
            $(document).ready(function() {
                $(document).on("submit", ".withdrawRequestStatus", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/wallet/withdraw-requests-status-update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#withdrawRequestStatus").trigger("reset");
                            $("#Withdraw_Modal").modal('hide');

                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")

                            $('#pre-loader').addClass('d-none');
                            location.reload();

                        },
                        error: function (error) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
            });
        });
    })(jQuery);


</script>
@endpush
