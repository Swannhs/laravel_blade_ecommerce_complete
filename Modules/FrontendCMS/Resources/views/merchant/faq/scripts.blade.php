<script>
    (function($){

        "use strict";

        $(document).ready(function() {

            $(document).on('submit', '#faq_create_form', function(event) {

                event.preventDefault();
                $("#create_faq_btn").prop('disabled', true);
                $('#create_faq_btn').text('{{ __("common.submitting") }}');
                $('#pre-loader').removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('frontendcms.faq.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeFaq(response.TableData)
                        resetValidationErrorsForBenefit('.faq_create_form')
                        toastr.success("{{__('common.created_successfully')}}","{{__('common.success')}}");
                        $('#faq_add').modal('hide');
                        $("#create_faq_btn").prop('disabled', false);
                        $('#create_faq_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        showValidationErrorsForBenefit('.faq_create_form', response.responseJSON
                            .errors);
                        $("#create_faq_btn").prop('disabled', false);
                        $('#create_faq_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('submit', '#faq_edit_form', function(event) {
                event.preventDefault();
                $("#edit_faq_btn").prop('disabled', true);
                $('#edit_faq_btn').text('{{ __("common.updating") }}');
                $('#pre-loader').removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#faq_id').val());
                $.ajax({
                    url: "{{ route('frontendcms.faq.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeFaq(response.TableData)
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        $('#faq_edit').modal('hide');
                        $("#edit_faq_btn").prop('disabled', false);
                        $('#edit_faq_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        showValidationErrorsForBenefit('.faq_edit_form', response.responseJSON
                            .errors);
                        $("#edit_faq_btn").prop('disabled', false);
                        $('#edit_faq_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            $(document).on('submit', '#faq_delete_form', function(event) {
                event.preventDefault();
                $("#delete_faq_btn").prop('disabled', true);
                $('#delete_faq_btn').text('{{ __("common.deleting") }}');
                $('#pre-loader').removeClass('d-none');
                $('#deleteFaqModal').modal('hide');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_faq_id').val());
                let id = $('#delete_faq_id').val();
                $.ajax({
                    url: "{{ route('frontendcms.faq.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeFaq(response.TableData)
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                        $("#delete_faq_btn").prop('disabled', false);
                        $('#delete_faq_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $("#delete_faq_btn").prop('disabled', false);
                        $('#delete_faq_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('click', '.add_faq_modal', function(event){
                event.preventDefault();
                $('#faq_add').modal('show');
            });

            $(document).on('click', '.edit_faq', function(event){
                event.preventDefault();
                let faq = $(this).data('value');
                $('#faq_edit').modal('show');
                resetValidationErrorsForBenefit('.faq_edit_form');
                resetFormFaq();
                $('#faq_id').val(faq.id);
                $(".faq_edit_form #title").val(faq.title);
                $('.faq_edit_form #description').val(faq.description);
                if (faq.status == 1) {
                    $('.faq_edit_form #status_active').prop("checked", true);
                    $('.faq_edit_form #status_inactive').prop("checked", false);
                } else {
                    $('.faq_edit_form #status_active').prop("checked", false);
                    $('.faq_edit_form #status_inactive').prop("checked", true);
                }
            });

            $(document).on('click', '.delete_faq', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_faq_id').val(id);
                $('#deleteFaqModal').modal('show');
            });

            function resetAfterChangeFaq(tableData) {
                $('#faq_table').empty();
                $('#faq_table').html(tableData);
                resetFormFaq();
            }

            function resetFormFaq(){
                $('#faq_create_form')[0].reset();
                $('#faq_edit_form')[0].reset();
            }

        });
    })(jQuery);

</script>
