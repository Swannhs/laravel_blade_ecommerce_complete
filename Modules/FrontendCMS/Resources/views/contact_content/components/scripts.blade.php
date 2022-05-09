@push('scripts')

    <script>
        (function($){
            "use strict";

            $(document).ready(function() {
                $('#formData').on('submit', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $("#mainSubmit").prop('disabled', true);
                    $('#mainSubmit').text('{{ __("common.updating") }}');
                    resetValidationErrors()
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('frontendcms.contact-content.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {

                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            resetValidationErrors('#formData')
                            $('#mainSubmit').text('{{ __("common.update") }}');
                            $("#mainSubmit").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                            showValidationErrors('#formData', response.responseJSON.errors);
                            $('#mainSubmit').text('{{ __("common.update") }}');
                            $("#mainSubmit").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $('#item_delete_form').on('submit', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteItemModal').modal('hide');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('frontendcms.query.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                            $('#deleteItemModal').modal('hide');
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit','#add_query_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $("#create_btn").prop('disabled', true);
                    $('#create_btn').text('{{ __("common.submitting") }}');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('frontendcms.query.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData)
                            resetForm();
                            // resetValidationErrors('.item_create_form')
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}");
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text('{{ __("common.save") }}');
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                            toastr.error('{{__("common.error_message")}}')
                            showValidationErrorsForQuery('#add_query_form', response.responseJSON.errors);
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text('{{ __("common.save") }}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit','#query_edit_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $("#edit_btn").prop('disabled', true);
                    $('#edit_btn').text('{{ __("common.updating") }}');
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#item_id').val());

                    $.ajax({
                        url: "{{ route('frontendcms.query.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text('{{ __("common.update") }}');

                            $.ajax({
                                url: "{{ route('frontendcms.query.create') }}",
                                type: "GET",
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#formHtml').empty();
                                    $('#formHtml').html(response.editHtml);
                                    $('#pre-loader').addClass('d-none');

                                },
                                error: function(response) {
                                    if(response.responseJSON.error){
                                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                        $('#pre-loader').addClass('d-none');
                                        return false;
                                    }

                                    toastr.error('{{__("common.error_message")}}')
                                    $('#pre-loader').addClass('d-none');
                                }
                            });

                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                            showValidationErrorsForQuery('#query_edit_form', response.responseJSON
                                .errors);
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text('{{ __("common.update") }}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('keyup', '#mainTitle', function(event){
                    processSlug($(this).val(), '#slug');
                });

                $(document).on('change', '.statusChange', function(event){
                    let item = $(this).data('value');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', item.id);
                    formData.append('status', item.status);
                    $.ajax({
                        url: "{{ route('frontendcms.query.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData);
                            toastr.success('{{__("common.status_change_message")}}')
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        }
                    });
                });

                $(document).on('click', '.edit_query', function(event){
                    event.preventDefault();
                    let item = $(this).data('value');
                    let url = '/frontendcms/query/' + item.id + '/edit'
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#formHtml').empty();
                            $('#formHtml').html(response.editHtml);
                            $('#pre-loader').addClass('d-none');

                            $('#item_id').val(item.id);
                            $('#name').val(item.name).addClass('has-content');
                            if (item.status == 1) {
                                $('#query_edit_form #status_active').prop("checked", true);
                                $('#query_edit_form #status_inactive').prop("checked", false);
                            } else {
                                $('#query_edit_form #status_active').prop("checked", false);
                                $('#query_edit_form #status_inactive').prop("checked", true);
                            }
                        },
                        error: function(response) {
                            toastr.error('{{__("common.error_message")}}')
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.delete_query', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });

                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_mainTitle').text(errors.mainTitle);
                    $(formType + ' #error_subTitle').text(errors.subTitle);
                    $(formType + ' #error_slug').text(errors.slug);
                    $(formType + ' #error_description').text(errors.description);
                    $(formType + ' #error_email').text(errors.email);
                }

                function resetValidationErrors(formType) {
                    $(formType + ' #error_mainTitle').text('');
                    $(formType + ' #error_subTitle').text('');
                    $(formType + ' #error_slug').text('');
                    $(formType + ' #error_description').text('');
                    $(formType + ' #error_email').text('');
                }

                function resetAfterChange(tableData) {
                    $('#item_table').empty();
                    $('#item_table').html(tableData);
                    CRMTableThreeReactive();
                    // resetForm();
                }
                function resetForm() {
                    $('#add_query_form')[0].reset();
                    $('#error_name').text('');
                }

                function showValidationErrorsForQuery(formType, errors){
                    $(formType + ' #error_name').text(errors.name);
                }



            });
        })(jQuery);

    </script>

@endpush
