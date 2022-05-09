@push('scripts')
    <script>

        (function($){
            "use strict";

            $(document).ready(function() {

                $(document).on('submit', '#add_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);
                    resetValidateError();
                    $('#pre-loader').removeClass('d-none');

                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('ticket.category.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetForm();
                            reloadWithData(response.TableData);
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
                            toastr.error('{{ __("common.error_message") }}',"{{__('common.error')}}");
                            showValidationErrors('#add_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('submit', '#edit_form', function(event) {
                    event.preventDefault();
                    $("#submit_btn").prop('disabled', true);
                    $('#submit_btn').text('{{ __("common.updating") }}');
                    resetValidateError();
                    $('#pre-loader').removeClass('d-none');

                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('ticket.category.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#form_div').html(response.createForm);
                            reloadWithData(response.TableData);
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('{{ __("common.update") }}');
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            $("#submit_btn").prop('disabled', false);
                            $('#submit_btn').text('{{ __("common.update") }}');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
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
                        url: "{{ route('ticket.category.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response.TableData);
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

                $(document).on('click', '.edit_category', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(this).data('value');
                    let base_url = $('#url').val();
                    let url = base_url + '/admin/ticket/categories/edit?id=' + id;
                    $.get(url, function(data) {
                        $('#form_div').html(data);
                        $('#pre-loader').addClass('d-none');
                    });

                });

                $(document).on('click', '.delete_category', function(event){
                    event.preventDefault();
                    let id = $(this).data('value');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');

                });

                $(document).on('change', '.status_change', function(event){
                    event.preventDefault();
                    let status = 0;
                    if($(this).prop('checked')){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('value');
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('ticket.category.status') }}",
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
                            toastr.error("{{__('common.error_message')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });

                });


                function reloadWithData(response){
                    $('#item_table').html(response);
                    CRMTableThreeReactive();
                }
                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_name').text(errors.name);
                }
                function resetValidateError(){
                    $('#error_name').text('');
                }

                function resetForm(){
                    $('#add_form')[0].reset();
                }


            });
        })(jQuery);

    </script>
@endpush
