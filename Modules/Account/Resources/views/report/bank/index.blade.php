@extends('account::layouts.app')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ trans('transaction.Bank Account Details') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mt-10 bank_name">{{ $bank->bank_name }} ({{ $bank->account_number }})</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="mt-10">{{ trans('transaction.Current Balance') }} {{
                                    single_price($transactions->where('type','in')->sum('amount')) }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-40">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('transaction.Transactions') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table" id="report_data">
                        @includeIf('account::report.bank.data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
