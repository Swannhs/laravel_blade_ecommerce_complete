@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('submit','#edit_form', function(event){
                    event.preventDefault();
                    let amount = $('#amount').val();
                    let maximum_limit = $('#maximum_limit').val();
                    if(amount>maximum_limit){
                        $('#error_amount').text("{{__('marketing.amount_is_getter_than_maximum_limit')}}");
                    }
                    else{
                        resetForm();
                        $("#submit_btn").prop('disabled', true);
                        $('#submit_btn').text("{{ __('common.updating') }}");

                        $('#pre-loader').removeClass('d-none');

                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('marketing.referral-code.update-setup') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.update") }}');
                                $('#pre-loader').addClass('d-none');
                            },
                            error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.update") }}');
                                $('#pre-loader').addClass('d-none');
                                toastr.error('{{ __("common.error_message") }}', '{{__("common.error")}}');
                                showValidationErrors('#edit_form', response.responseJSON.errors);
                            }
                        });
                    }
                });

                $(document).on('change', '.status_change_referral', function(){
                    changeStatus($(this)[0]);
                });

                function changeStatus(el){
                    let status = 0;
                    if(el.checked){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', el.value);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('marketing.referral-code.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error('{{ __("common.error_message") }}', '{{__("common.error")}}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                }

                $('#referralCodeTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('marketing.referral-code.get-data') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'referral_code', name: 'referral_code' },
                        { data: 'name', name: 'name' },
                        { data: 'date', name: 'date' },
                        { data: 'status', name: 'status' }

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

                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_amount').text(errors.amount);
                    $(formType + ' #error_maximum_limit').text(errors.maximum_limit);
                    $(formType + ' #error_status').text(errors.status);
                }
                function resetForm() {
                    $('#error_amount').text('');
                    $('#error_maximum_limit').text('');
                    $('#error_status').text('');
                }

            });
        })(jQuery);

    </script>
@endpush
