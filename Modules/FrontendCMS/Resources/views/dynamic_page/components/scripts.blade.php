@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function() {
                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteItemModal').modal('hide');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('frontendcms.dynamic-page.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if(response.parent_msg){
                                toastr.warning(response.parent_msg);
                                $("#pre-loader").addClass('d-none');
                            }else{
                                resetAfterChange(response.TableData);
                                toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                                $('#pre-loader').addClass('d-none');
                            }

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

                $(document).on('change', '.statusChange', function(event){
                    let item = $(this).data('value');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', item.id);
                    formData.append('status', item.status);
                    $.ajax({
                        url: "{{ route('frontendcms.dynamic-page.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        },
                        error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });
                });

                $(document).on('click', '.delete_page', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });

                function resetAfterChange(tableData) {
                    $('#item_table').empty();
                    $('#item_table').html(tableData);
                    CRMTableThreeReactive();
                }

            });

        })(jQuery);

    </script>
@endpush
