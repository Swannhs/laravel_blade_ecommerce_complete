@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title)
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0 mb-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.select') }}
                            {{ __('common.payment_method') }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="white_box_50px box_shadow_white pb-3">
                    <form class="" action="{{ route('report.payment') }}" method="GET">
                        <div class="row">
                            <div class="col">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.payment_method') }}</label>
                                    <select required class="primary_select mb-15" name="payment_method_id" id="type">
                                        <option value="">{{ __('common.select_one') }}</option>
                                        @foreach ($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}" @if(isset($payment_method_id) && $payment_method->id == $payment_method_id) selected @endif>{{ $payment_method->method}} </option>
                                        @endforeach
                                        <option @if(!isset($payment_method_id)) selected @endif @if(isset($payment_method_id) && $payment_method_id=="0" )
                                        selected @endif value="0">{{ __('common.all') }}</option>
                                    </select>
                                    <span class="text-danger">{{$errors->first('seller_id')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="primary_input">
                                <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                        class="ti-search"></i>{{ __('report.search') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($payment_method_id))
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.payment') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="visitorTable" class="table Crm_table_active3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.user') }}</th>
                                        <th scope="col">{{ __('common.amount') }}</th>
                                        <th scope="col">{{ __('common.payment_method') }}</th>
                                        <th scope="col">{{ __('common.payment') }} {{ __('common.details') }}</th>
                                        <th scope="col">{{ __('common.txn_id') }}</th>
                                        <th scope="col">{{ __('common.date') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
            "use strict";

            @if(isset($payment_method_id))
            $('#visitorTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('report.payment_data') }}?payment_method_id={{ $payment_method_id }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                                { data: 'DT_RowIndex', name: 'id' },
                                { data: 'user', name: 'user' },
                                { data: 'amount', name: 'amount' },
                                { data: 'payment_method', name: 'payment_method' },
                                { data: 'payment_details', name: 'payment_details' },
                                { data: 'txn_id', name: 'txn_id' },
                                { data: 'date', name: 'date' },
                            ],

                    bLengthChange: false,
                    "order":[[6,"desc"]],
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
            @endif

        })(jQuery);
</script>
@endpush
