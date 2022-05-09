@extends('account::layouts.app')
@php
$elements = ['datatable', 'datepicker']
@endphp
@push('css')
@if(Route::has('_asset.css'))
<link rel="stylesheet" href="{{ route('_asset.css', ['elements' => $elements]) }}">
@endif
@endpush

@push('scripts_after')
@if(Route::has('_asset.js'))
<script type="text/javascript" src="{{  route('_asset.js', ['elements' => $elements])  }}"></script>
@endif

<script>
    (function($){
            "use strict";
            $('input[name="date_range"]').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "startDate": moment().subtract(7, 'days'),
                "endDate": moment()
            }, function (start, end, label) {
                $('#start').val(start.format('YYYY-MM-DD'))
                $('#end').val(end.format('YYYY-MM-DD'))

            });
            $(document).ready(function(){
                $('#start').val(moment().subtract(7, 'days').format('YYYY-MM-DD'))
                $('#end').val(moment().format('YYYY-MM-DD'))
            });

            $(document).on('submit', '#content_form', function(e){
                e.preventDefault();

            });


            $(document).ready(function() {
                $('.Crm_table_active_3').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": $.fn.dataTable.pipeline( {
                        url: '{{ route('account.transaction_dtbl') }}',
                        data: function(d) {
                            d.filter_date = $('input[name="date_range"]').val();
                        },
                        pages: 5 // number of pages to cache
                    } ),
                    columns: [
                        { data: 'date', name: 'date', searchable:false },
                        { data: 'chart_of_account', name: 'chart_of_account' },
                        { data: 'bank_account', name: 'bank_account' },
                        { data: 'title', name: 'title' },
                        { data: 'credit', name: 'credit' },
                        { data: 'debit', name: 'debit' }

                    ],
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // converting to interger to find total
                        var parseFloat = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[^0-9\.]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var creditTotal = api
                            .column( 4 , { page: 'current'})
                            .data()
                            .reduce( function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0 );
                        var debitTotal = api
                            .column( 5 , { page: 'current'})
                            .data()
                            .reduce( function (a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0 );

                        var currency_sym = $('#currency_sym').val();
                        // Update footer by showing the total with the reference of the column index
                    $( api.column( 0 ).footer() ).html('Total');
                        $( api.column( 4 ).footer() ).html(currency_sym + ' ' +creditTotal.toFixed(2));
                        $( api.column( 5 ).footer() ).html(currency_sym + ' ' +debitTotal.toFixed(2));
                    },
                    bLengthChange: true,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title : $("#header_title").text(),
                            titleAttr: 'Copy',
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title : $("#header_title").text(),

                            margin: [10 ,10 ,10, 0],
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',

                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title : $("#header_title").text(),
                            titleAttr: 'PDF',
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A3',
                            margin: [ 0, 0, 0,0 ],
                            alignment: 'center',
                            header: true,

                            messageBottom: 'Generated By : {{ auth()->user()->name }}',
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            alignment: 'center',
                            title : window.dataTableHeadingText,
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            header: true,
                            extend: 'print',
                            footer: true,

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
                    ordering: false,
                    "scrollX": false
                });

                let table = $('.Crm_table_active_3').DataTable();

                table.on( 'draw', function () {
                    if($('.Crm_table_active_3 tbody tr').length <= 3){
                        $('.dataTables_scrollBody').addClass('manage-table-height')
                    }else{
                        $('.dataTables_scrollBody').removeClass('manage-table-height')
                    }
                });

                $('input[name="date_range"]').on('change',function(){
                    table.clearPipeline();
                    table.ajax.reload();
                });
            });
        })(jQuery);
</script>

@endpush
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('hr.select_criteria') }}</h3>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="white-box">
                    <form method="GET" action="{{ route('account.transaction_dtbl') }}" id="content_form">

                        <div class="row">
                            <div class="col-lg-12">
                                <x-backEnd.date_range name="date_range" :required="true"
                                    :field="trans('common.select_criteria')" />
                            </div>
                            <input type="hidden" id="start">
                            <input type="hidden" id="end">

                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="row mt-40">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('transaction.Transaction') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table" id="report_data">
                        @includeIf('account::report.transaction.data')
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
