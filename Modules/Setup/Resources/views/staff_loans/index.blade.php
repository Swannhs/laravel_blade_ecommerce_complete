@extends('backEnd.master')
@push('styles')
    <link rel="stylesheet" href="{{asset(asset_path('backend/css/custom.css'))}}"/>
@endpush
@section('page-title', app('general_setting')->site_title .' | Loan List')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.loan') }}</h3>
                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"  data-toggle="modal" data-target="#ApplyLoan"><i class="ti-plus"></i>{{ __('common.apply_for_loan') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('common.sl') }}</th>
                                    <th scope="col">{{ __('common.user') }}</th>
                                    <th scope="col">{{ __('common.type') }}</th>
                                    <th scope="col">{{ __('common.amount') }}</th>
                                    <th scope="col">{{ __('common.monthly_installment') }}</th>
                                    <th scope="col">{{ __('common.due') }}</th>
                                    <th scope="col">{{ __('common.status') }}</th>
                                    <th scope="col">{{ __('common.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($loans as $key => $loan)
                                    @if ($loan->user != null)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ @$loan->user->first_name }}</td>
                                            <td>{{ $loan->loan_type }}</td>
                                            <td>{{ single_price($loan->amount) }}</td>
                                            <td>{{ single_price($loan->monthly_installment) }}</td>
                                            @php
                                                $due = $loan->amount - $loan->paid_loan_amount;
                                            @endphp
                                            <td>{{ single_price($due) }}</td>
                                            <td>
                                                @if ($loan->approval == 0)
                                                    <span class="badge_3">{{__('common.pending')}}</span>
                                                @elseif ($loan->approval == 1)
                                                    <span class="badge_1">{{__('common.approved')}}</span>
                                                @else
                                                    <span class="badge_4">{{__('common.cancelled')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        <a href="#" onclick="ApplyLoanView({{ $loan->id }})" class="dropdown-item">{{__('common.view')}}</a>
                                                        @if ($loan->approval != 1)
                                                            <a href="#" data-id={{ $loan->id }} class="dropdown-item apply_loan_edit">{{__('common.edit')}}</a>
                                                            <a onclick="confirm_modal('{{route('apply_loans.destroy', $loan->id)}}');" class="dropdown-item edit_brand">{{__('common.delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
@include('setup::staff_loans.create',['users' => $users])
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($) {
           "use strict";
            $("#ApplyLoan_addForm").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("apply_loans.store")}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#ApplyLoan").modal("hide");
                        $("#ApplyLoan_addForm").trigger("reset");
                        toastr.success("{{__('common.loan_has_been_applied_successfully')}}","{{__('common.success')}}")
                        location.reload();
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
                    }

                });
            });

            $(document).on('keyup', '.amount', function(){
                getMonthlyInstallment();
            });

            $(document).on('keyup', '.total_month', function(){
                getMonthlyInstallment();
            });

            function getMonthlyInstallment()
            {
                var loan_amount = $('#amount').val();
                var total_month = $('#total_month').val();
                var monthly_installment = 0;
                monthly_installment = parseInt(loan_amount) / parseInt(total_month);
                $("#monthly_installment").val(monthly_installment.toFixed(2));
                $("#monthly_installment").val(monthly_installment.toFixed(2));
            }
            function ApplyLoanEdit(el){
                $.post('{{ route('apply_loans.edit') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                    $('#edit_form').html(data);
                    $('#ApplyLoanEdit').modal('show');
                    $('select').niceSelect();
                });
            }
            $(document).on('click', '.apply_loan_edit', function(){
                ApplyLoanView($(this).attr("data-id"));
            });
            function ApplyLoanView(el){
                $.post('{{ route('apply_loans.show') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                    $('#edit_form').html(data);
                    $('#ApplyLoanview').modal('show');
                });
            }
        })(jQuery);
    </script>
@endpush
