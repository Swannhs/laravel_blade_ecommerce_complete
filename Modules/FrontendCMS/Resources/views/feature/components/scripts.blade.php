
@push('scripts')
<script src="{{asset(asset_path('backend/vendors/js/icon-picker.js'))}}"></script>

<script>


    (function($){
        "use strict";


        $(document).ready(function() {

            var baseUrl = $('#app_base_url').val();

            $(document).on('mouseover', 'body', function(){
                $('#icon').iconpicker({
                    animation:true
                });
            });

            $(document).on('submit', '#item_create_form', function(event){
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',"{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('frontendcms.features.store')}}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        resetAfterChange(response.TableData)
                        toastr.success("{{__('common.created_successfully')}}","{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                        $('#item_create_form')[0].reset();

                    },
                    error:function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        showValidationErrors('#item_create_form',response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('submit', '#item_edit_form', function(event){
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',"{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('frontendcms.features.update')}}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        resetAfterChange(response.TableData)
                        $('#formHtml').html(response.createForm);
                        $('#pre-loader').addClass('d-none');
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");

                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        $('#pre-loader').addClass('d-none');
                        showValidationErrors('#item_edit_form',response.responseJSON.errors);
                    }
                });
            });

            $(document).on('submit', '#deleteItemModal',function(event){
                event.preventDefault();
                $('#deleteItemModal').modal('hide');
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('id',$('#delete_item_id').val());
                $.ajax({
                    url: "{{ route('frontendcms.features.delete')}}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        resetAfterChange(response.TableData);
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
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

            $(document).on('click', '.edit_feature', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                if(id){
                    $('#pre-loader').removeClass('d-none');

                    let base_url = $('#url').val();
                    let url = base_url + '/frontendcms/features/edit/' +id;
                    $.get(url, function(response){
                        if(response){
                            $('#formHtml').html(response);
                        }
                        $('#pre-loader').addClass('d-none');
                    });
                }

            });

            $(document).on('click', '.delete_feature', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                if(id){
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                }

            });

            $(document).on('keyup', '#title', function(event){
                event.preventDefault();
                processSlug($(this).val(), '#slug')

            });


            function resetForm(){
                $('#title_error').text('');
                $('#slug_error').text('');
                $('#icon_error').text('');
            }

            function resetAfterChange(tableData){
                $('#item_table').html(tableData);
                CRMTableThreeReactive();
                resetForm();
            }

            function showValidationErrors(formType, errors){
                $(formType +' #title_error').text(errors.title);
                $(formType +' #slug_error').text(errors.slug);
                $(formType +' #icon_error').text(errors.icon);
                $(formType +' #status_error').text(errors.status);
            }



        });
    })(jQuery);

</script>
@endpush
