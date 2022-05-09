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
                get_filter_data({
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                });
            });
            $(document).ready(function(){
                $('#start').val(moment().subtract(7, 'days').format('YYYY-MM-DD'))
                $('#end').val(moment().format('YYYY-MM-DD'))
            });

            $(document).on('submit', '#content_form', function(e){
                e.preventDefault();
                get_filter_data({
                    start: $('#start').val(),
                    end: $('#end').val()
                })
            })

            function get_filter_data(data) {
                var form = $('#content_form');
                showFormSubmitting(form);
                const submit_url = form.attr('action');
                const method = form.attr('method');
                $.ajax({
                    url: submit_url,
                    type: method,
                    data: data,
                    dataType: 'html',
                    success: function (data) {
                        $('#report_data').html(data);
                        startDatatable();
                        hideFormSubmitting(form);
                    },
                    error: function (data) {
                        ajax_error(data);
                        hideFormSubmitting(form);
                    }

                })
            }
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
                    <form method="GET" action="{{ route('account.profit') }}" id="content_form">

                        <div class="row">
                            <div class="col-lg-6">
                                <x-backEnd.date_range name="date_range" :required="true"
                                    :field="trans('common.select_criteria')" />
                            </div>
                            <input type="hidden" id="start">
                            <input type="hidden" id="end">
                            <div class="col-lg-6 mt-10">
                                <button type="submit" class="primary-btn small fix-gr-bg submit">
                                    <span class="ti-search pr-2"></span>
                                    {{ __('common.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="row mt-40">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Profit') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table" id="report_data">
                        @includeIf('account::report.profit.data')
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
