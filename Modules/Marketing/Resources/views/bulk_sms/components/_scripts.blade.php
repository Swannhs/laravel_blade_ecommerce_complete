@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function() {

                smsDataTable();

                $(document).on('change', '#send_to', function(event) {
                    let value = $('#send_to').val();
                    if (value == 1) {
                        $('#all_user_div').removeClass('d-none');
                    } else {
                        $('#all_user_div').addClass('d-none');
                    }
                    if (value == 2) {
                        $('#select_role_div').removeClass('d-none');
                        $('#select_role_user_div').removeClass('d-none');
                    } else {
                        $('#select_role_div').addClass('d-none');
                        $('#select_role_user_div').addClass('d-none');
                    }
                    if (value == 3) {
                        $('#multiple_role_div').removeClass('d-none');
                    } else {
                        $('#multiple_role_div').addClass('d-none');
                    }
                });
                $(document).on('change', '#role', function(event) {
                    $('#role_user').empty();
                    $('#pre-loader').removeClass('d-none');
                    let role = $('#role').val();
                    let base_url = $('#url').val();
                    let url = base_url + '/marketing/bulk-sms/role-user?id=' + role;
                    $.get(url, function(data) {
                        $('#role_user').empty();
                        $('#role_user').html(data);
                        $('#role_user').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                });

                $(document).on('submit', '#add_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);

                    $('#pre-loader').removeClass('d-none');
                    removeValidateError();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('marketing.bulk-sms.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            $('#testSMSDiv').empty();
                            $('#testSMSDiv').html(response.testSMSModal);
                            $('#testModal').modal('show');
                            resetForm();
                            toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                            $("#submit_btn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $("#submit_btn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}', "{{__('common.error')}}");
                            showValidationErrors('#add_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('submit', '#edit_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);
                    $('#submit_btn').text('{{ __("common.updating") }}');

                    $('#pre-loader').removeClass('d-none');
                    removeValidateError();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('marketing.bulk-sms.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#form_div').empty();
                            $('#form_div').html(response.createForm);
                            $('#all_user').niceSelect();
                            $('#send_to').niceSelect();
                            $('#role').niceSelect();
                            $('#role_user').niceSelect();
                            $('#publish_date').datepicker();
                            reloadWithData(response);
                            resetForm();
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('{{ __("common.save") }}');
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('{{ __("common.save") }}');
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}', "{{__('common.error')}}");
                            showValidationErrors('#edit_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteItemModal').modal('hide');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('marketing.bulk-sms.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            $('#form_div').html(response.createForm);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit', '#testSMSForm', function(event) {
                    event.preventDefault();
                    let phone = $('#phone').val();
                    if(phone != ''){

                        $("#sms_send_btn").prop('disabled', true);
                        $('#sms_send_btn').text('{{ __("marketing.sending") }}');
                        $('#error_phone').text('');

                        $('#pre-loader').removeClass('d-none');

                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('marketing.bulk-sms.test-sms') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                $('#form_div').empty();
                                $('#form_div').html(response.createForm);
                                $('#all_user').niceSelect();
                                $('#send_to').niceSelect();
                                $('#role').niceSelect();
                                $('#role_user').niceSelect();
                                $('#publish_date').datepicker();
                                toastr.success("{{__('marketing.test_sms_has_been_send_successfully')}}", "{{__('common.success')}}")
                                $("#sms_send_btn").prop('disabled', false);
                                $('#sms_send_btn').text('{{ __("common.send") }}');
                                $('#pre-loader').addClass('d-none');
                                $('#testModal').modal('hide');
                            },
                            error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                                $("#sms_send_btn").prop('disabled', false);
                                $('#sms_send_btn').text('{{__("common.send") }}');
                                $('#pre-loader').addClass('d-none');
                                toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            }
                        });
                    }else{
                        $('#error_phone').text('The Phone is Required.');
                    }
                });

                $(document).on('click', '.edit_sms', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    showEditForm(id);
                });

                $(document).on('click', '.delete_sms', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    showDeleteModal(id);
                });

                $(document).on('change', '#role_all', function(){
                    role_all_check($(this)[0]);
                });

                function showEditForm(id){
                    $('#pre-loader').removeClass('d-none');
                    let base_url = $('#url').val();
                    let url = base_url + '/marketing/bulk-sms/edit?id=' + id;
                    $.get(url, function(data) {
                        $('#form_div').empty();
                        $('#form_div').html(data);
                        $('#all_user').niceSelect();
                        $('#send_to').niceSelect();
                        $('#role').niceSelect();
                        $('#role_user').niceSelect();
                        $('#publish_date').datepicker();
                        $('#pre-loader').addClass('d-none');
                    });
                }

                function showDeleteModal(id){
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                }
                function role_all_check(el) {
                    if (el.checked) {
                        $('.multi_check').prop('checked', true);
                    } else {
                        $('.multi_check').prop('checked', false);
                    }
                }

                function reloadWithData(response){
                    $('#item_table').empty();
                    $('#item_table').html(response.TableData);
                    smsDataTable();
                }
                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_title').text(errors.title);
                    $(formType + ' #error_message').text(errors.message);
                    $(formType + ' #error_send_to').text(errors.send_to);
                    $(formType + ' #error_publish_date').text(errors.publish_date);
                    $(formType + ' #error_all_user').text(errors.all_user);
                    $(formType + ' #error_role').text(errors.role);
                    $(formType + ' #error_role_user').text(errors.role_user);
                    $(formType + ' #error_role_list').text(errors.role_list);
                }
                function resetForm() {
                    $('#add_form')[0].reset();
                    $('#all_user_div').addClass('d-none');
                    $('#select_role_div').addClass('d-none');
                    $('#select_role_user_div').addClass('d-none');
                    $('#multiple_role_div').addClass('d-none');
                    $('#send_to').niceSelect('update');
                }
                function removeValidateError(){
                    $('#error_title').text('');
                    $('#error_message').text('');
                    $('#error_send_to').text('');
                    $('#error_publish_date').text('');
                    $('#error_send_to').text('');
                    $('#error_all_user').text('');
                    $('#error_role').text('');
                    $('#error_role_user').text('');
                    $('#error_role_list').text('');
                }
                $(document).on('click', '#test_sms_btn', function(event){
                    $('#testModal').modal('show');
                });

                function smsDataTable(){
                    $('#bulkSmsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: "{{ route('marketing.bulk-sms.get-data') }}"
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'title', name: 'title' },
                            { data: 'message', name: 'message' },
                            { data: 'publish_date', name: 'publish_date' },
                            { data: 'status', name: 'status' },
                            { data: 'created_by', name: 'created_by' },
                            { data: 'message_to', name: 'message_to' },
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
                }

            });
        })(jQuery);

    </script>
@endpush
