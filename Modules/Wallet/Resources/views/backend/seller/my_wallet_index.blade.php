@extends('backEnd.master')
@section('mainContent')
    @php
        session()->forget('wallet_recharge');
    @endphp
    <section class="admin-visitor-area up_st_admin_visitor mb-25">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <a class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ __('wallet.running_balance') }}</h3>
                            </div>
                            <h1 class="gradient-color2">{{ single_price(seller_wallet_balance_running()) }}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ __('wallet.pending_balance') }}</h3>
                            </div>
                            <h1 class="gradient-color2">{{ single_price(seller_wallet_balance_pending()) }}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ __('wallet.earning_balance') }}</h3>
                            </div>
                            <h1 class="gradient-color2">{{ single_price(auth()->user()->wallet_balances->where('type', 'Sale Payment')->sum('amount')) }}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ __('wallet.withdraw_balance') }}</h3>
                            </div>
                            <h1 class="gradient-color2">{{ single_price(auth()->user()->wallet_balances->where('type', 'Withdraw')->sum('amount')) }}</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{ __('wallet.refund_paid') }}</h3>
                            </div>
                            <h1 class="gradient-color2">{{ single_price(auth()->user()->wallet_balances->where('type', 'Refund')->sum('amount')) }}</h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('wallet.transaction_list') }}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('my-wallet.withdraw_request_sent'))
                                    <li><a data-toggle="modal" data-target="#Recharge_Modal" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"><i class="ti-plus"></i>{{ __('wallet.recharge_now') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table" id="myWalletTable">
                                <thead>
                                    <tr>
                                        <th>{{__('common.sl')}}</th>
                                        <th>{{__('common.date')}}</th>
                                        <th>{{__('order.txn_id')}}</th>
                                        <th>{{__('common.amount')}}</th>
                                        <th>{{__('common.type')}}</th>
                                        <th>{{__('common.payment_method')}}</th>
                                        <th>{{__('common.approval')}}</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="sign" class="sign" value="{{ app('general_setting')->currency_symbol }}">
        <input type="hidden" name="current_balance" class="current_balance" value="{{ auth()->user()->SellerCurrentWalletAmounts }}">
        <input type="hidden" name="pending_withdraw_balance" class="pending_withdraw_balance" value="{{ auth()->user()->SellerPendingWithdrawAmounts }}">
        <input type="hidden" name="remaining_balance" class="remaining_balance" value="{{ auth()->user()->SellerCurrentWalletAmounts - auth()->user()->SellerPendingWithdrawAmounts }}">
    </section>
@include('wallet::backend.seller.withdraw_requests.withdraw_modal')
@include('wallet::backend.seller.recharge_modal')
@endsection

@push('scripts')
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){
                let baseUrl = $('#url').val();
                let url = baseUrl + '/wallet/seller/my-wallet-index/get-data';
                $('#myWalletTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: url
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'date', name: 'date' },
                        { data: 'txn_id', name: 'txn_id' },
                        { data: 'amount', name: 'amount' },
                        { data: 'type', name: 'type' },
                        { data: 'payment_method', name: 'payment_method' },
                        { data: 'approval', name: 'approval' }

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

                $(document).on('click', '.getNewForm', function(event){
                    event.preventDefault();

                    $("#Withdraw_Modal").modal('show');
                    var sign = $('.sign').val();
                    var current_balance = $('.current_balance').val();
                    var pending_withdraw_balance = $('.pending_withdraw_balance').val();
                    var remaining_balance = $('.remaining_balance').val();
                    var amount = $('.remaining_balance').val();
                    $(".running_balance").text(sign +' '+ current_balance);
                    $(".pending_withdraw_balance").text(sign +' '+ pending_withdraw_balance);
                    $(".remaining_balance").text(sign +' '+ remaining_balance);
                    $(".amount").val(remaining_balance);

                });

                $(document).on('submit', '#withdraw_form', function(event){
                    $('#amount_error_create').text('');
                    var remaining_balance = $('.remaining_balance').val();
                    let withdarw_amount = $('#withdraw_amount_add').val();

                    if(withdarw_amount == '' || withdarw_amount < 1){
                        $('#amount_error_create').text('The Amount is Required.');
                        event.preventDefault();
                    }
                    else if(parseFloat(remaining_balance) < parseFloat(withdarw_amount)){
                        $('#amount_error_create').text('Withdraw Amount Must be Smaller Than Remaining Balance.');
                        event.preventDefault();
                    }
                });

                $(document).on('submit', '#recharge_form', function(event){
                    $('#recharge_amount_error').text('');
                    let recharge_amount = $('#recharge_amount').val();
                    if(recharge_amount == '' || recharge_amount < 1){
                        $('#recharge_amount_error').text('The Amount is Required.');
                        event.preventDefault();
                    }
                });


            });


        })(jQuery);

    </script>
@endpush
