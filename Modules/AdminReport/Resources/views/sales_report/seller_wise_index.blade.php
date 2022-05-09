@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title)
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.filter_selection_criteria') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white pb-3">
                        <form class="" action="{{ route('report.seller_wise_sales') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.seller_id') }}</label>
                                        <select required class="primary_select mb-15" name="seller_id" id="seller_id">
                                            <option value="">{{ __('common.select_one') }}</option>
                                            @foreach ($sellers as $key => $seller)
                                                <option value="{{ $seller->user->id }}" @if(isset($seller_id) && $seller->user->id == $seller_id) selected @endif>{{ ($seller->seller_shop_display_name) ? $seller->seller_shop_display_name : $seller->user->first_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('seller_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('report.sale_type') }}</label>
                                        <select required class="primary_select mb-15" name="sale_type" id="sale_type">
                                            <option value="">{{ __('common.select_one') }}</option>
                                                <option @if(isset($sale_type) && $sale_type == "paid_order") selected @endif value="paid_order">{{ __('common.paid') }}</option>
                                                <option @if(isset($sale_type) && $sale_type == "completed_order") selected @endif  value="completed_order">{{ __('common.completed') }}</option>
                                                <option @if(isset($sale_type) && $sale_type == "confirmed_order") selected @endif  value="confirmed_order">{{ __('common.confirmed') }}</option>
                                                <option @if(isset($sale_type) && $sale_type == "cancelled_order") selected @endif  value="cancelled_order">{{ __('common.cancelled') }}</option>
                                                <option  @if(!isset($sale_type)) selected @endif @if(isset($sale_type) && $sale_type == "all_order") selected @endif  value="all_order">{{ __('common.all') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('seller_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-search"></i>{{ __('report.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-0 mt-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('report.seller_wise_sales_report') }}

                                @if(isset($sale_type) && $sale_type == "paid_order")
                                ({{ __('common.paid') }})
                                @endif
                                @if(isset($sale_type) && $sale_type == "completed_order")
                                ({{ __('common.completed') }})
                                @endif
                                @if(isset($sale_type) && $sale_type == "confirmed_order")
                                ({{ __('common.confirmed') }})
                                @endif
                                @if(isset($sale_type) && $sale_type == "cancelled_order")
                                ({{ __('common.cancelled') }})
                                @endif
                                @if(isset($sale_type) && $sale_type == "all_order")
                                ({{ __('common.all') }})
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="table-responsive">
                                <table
                                @if (isset($seller_id))
                                id="sellerWiseSaleTable"
                                @endif
                                  class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.order') }} {{ __('common.number') }}</th>
                                        <th scope="col">{{ __('common.customer') }} {{ __('common.name') }}</th>
                                        <th scope="col">{{ __('common.customer') }} {{ __('common.email') }}</th>
                                        <th scope="col">{{ __('common.total_amount') }}</th>
                                        <th scope="col">{{ __('common.date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('backEnd.partials.delete_modal',['item_name' => __('common.keyword')])
@endsection

@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).on('click', '.delete_keuword', function(event){
                event.preventDefault();
                let route = $(this).data('value');
                confirm_modal(route);
            });

            $('#sellerWiseSaleTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        @if (isset($seller_id))
                        url: "{{ route('report.get_seller_wise_sale_report_data',[$seller_id,$sale_type]) }}"
                        @endif
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                                { data: 'order_number', name: 'order_number' },
                                { data: 'customer_name', name: 'customer_name' },
                                { data: 'customer_email', name: 'customer_email' },
                                { data: 'total_amount', name: 'total_amount' },
                                { data: 'date', name: 'date' },
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
