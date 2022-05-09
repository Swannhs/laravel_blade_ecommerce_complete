@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('wallet.offline_recharge') }}</h3>
                            @if (permissionCheck('wallet_recharge.offline'))
                                <ul class="d-flex">
                                    <li><a data-toggle="modal" data-target="#Recharge_Modal_Offline" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"><i class="ti-plus"></i>{{ __('wallet.offline_recharge') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table" id="offlineRechargeTable">
                                <thead>
                                    <tr>
                                        <th>{{__('common.sl')}}</th>
                                        <th width="10%">{{__('common.date')}}</th>
                                        <th>{{__('common.email')}}</th>
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
    </section>
@include('wallet::backend.admin.recharge_modal')
@include('wallet::backend.admin.recharge_modal_edit')
@endsection

@push('scripts')
<script type="text/javascript">

    (function($){
        "use strict";

        $(document).ready(function(){

            $(document).on('click', '.edit_modal', function(event){
                event.preventDefault();
                let el = $(this).data('value');

                $("#Item_Edit").modal('show');
                $("#id").val(el.id);
                $("#edit_recharge_amount").val(el.amount);
                $("#edit_payment_method").val(el.payment_method);
                $('#edit_user_id').val(el.user.id);
                $('#edit_role_id').val(el.user.role_id);

                $('#edit_user_id').niceSelect('update');
                $('#edit_role_id').niceSelect('update');
            });

            $(document).on('change', '#role_id', function(event){
                $('#pre-loader').removeClass('d-none');
                let role_id = $(this).val();
                let url = "{{route('wallet_recharge.get-user-by-role')}}" +'?role_id=' + role_id; 
                $('#user_id').empty();
                $('#user_id').append(
                    `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                );
                $.get(url, function(data){
                    $('#pre-loader').addClass('d-none');
                    $.each(data, function(index, userObj) {
                        $('#user_id').append('<option value="'+ userObj.id +'">'+ userObj.first_name +'</option>');
                    });

                    $('#user_id').niceSelect('update');
                });
            });

            $(document).on('change', '#edit_role_id', function(event){
                $('#pre-loader').removeClass('d-none');
                let role_id = $(this).val();
                let url = "{{route('wallet_recharge.get-user-by-role')}}" +'?role_id=' + role_id; 
                $('#edit_user_id').empty();
                $('#edit_user_id').append(
                    `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                );
                $.get(url, function(data){
                    $('#pre-loader').addClass('d-none');
                    $.each(data, function(index, userObj) {
                        $('#edit_user_id').append('<option value="'+ userObj.id +'">'+ userObj.first_name +'</option>');
                    });

                    $('#edit_user_id').niceSelect('update');
                });
            });

            $(document).on('submit', '#recharge_form', function(event){

                $('#user_id_error').text('');
                $('#recharge_amount_error').text('');
                $('#comment_error').text('');

                let user_id = $('#user_id').val();
                let amount_id = $('#amount_id').val();
                let comment_id = $('#comment_id').val();
                let input_check = 0;
                if(user_id == null){
                    $('#user_id_error').text("{{__('validation.this_field_is_required')}}");
                    input_check = 1;
                }
                if(amount_id < 1){
                    $('#recharge_amount_error').text("{{__('validation.the_amount_is_must_be_gretter_than_0')}}");
                    input_check = 1;
                }
                if(amount_id == ''){
                    $('#recharge_amount_error').text("{{__('validation.this_field_is_required')}}");
                    input_check = 1;
                }
                if(comment_id ==  ''){
                    $('#comment_error').text("{{__('validation.this_field_is_required')}}");
                    input_check = 1;
                }

                if(input_check == 1){
                    event.preventDefault();
                }


            });

            $('#offlineRechargeTable').DataTable({
                processing: true,
                serverSide: true,
                "ajax": ( {
                    url: "{{ route('wallet_recharge.offline_index_get_data') }}"
                }),
                "initComplete":function(json){

                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'date', name: 'date' },
                    { data: 'email', name: 'user.email' },
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
        });
    })(jQuery);

</script>
@endpush
