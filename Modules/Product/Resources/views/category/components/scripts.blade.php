@push('scripts')
    <script src="{{asset(asset_path('backend/vendors/js/icon-picker.js'))}}"></script>
    <script>
        (function($){
            "use strict";

            $(document).ready(function() {

                $(document).on('mouseover', 'body', function(){
                    $('#icon').iconpicker({
                        animation:true
                    });
                });

                $(document).on('click','.in_sub_cat', function(event){
                    $(".in_parent_div").toggleClass('d-none');
                });

                $(document).on('change', '#image', function(event){
                    getFileName($('#image').val(),'#image_file');
                    imageChangeWithFile($(this)[0],'#catImgShow');
                });

                $(document).on('keyup', '#name', function(event){
                    processSlug($('#name').val(), '#slug');
                });

                $(document).on('submit', '#add_category_form',  function(event) {
                    event.preventDefault();
                    $("#pre-loader").removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    //image validaiton
                    var validFileExtensions = ['jpeg', 'jpg', 'png'];
                    var single_image=document.getElementById('image').files.length;
                    if(single_image ==1){
                        var size = (document.getElementById('image').files[0].size / 1024 / 1024).toFixed(2);
                        if (size > 1) {
                        alert("File must be less than 1MB");
                        return false;
                        }
                        var value=$('#image').val();
                        var type=value.split('.').pop().toLowerCase();
                        if ($.inArray(type, validFileExtensions) == -1) {
                        toastr.error("{{__('product.invalid_type_type_should_be_jpeg_jpg_png')}}","{{__('common.error')}}");
                        return false;
                        }
                        formData.append('image', document.getElementById('image').files[0]);

                    }

                    formData.append('_token', "{{ csrf_token() }}");

                    resetValidationErrors();

                    $.ajax({
                        url: "{{ route('product.category.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData)
                            $('#formHtml').html(response.createForm);
                            toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                            $("#pre-loader").addClass('d-none');
                            $('#parent_id').niceSelect();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            showValidationErrors('#add_category_form', response.responseJSON.errors);
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text('{{ __("common.save") }}');
                            $('#parent_id').niceSelect();
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.edit_category', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');

                    $("#pre-loader").removeClass('d-none');
                    let base_url = $('#url').val();
                    let url = base_url + '/products/category/' + id + '/edit'
                    $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            $('#formHtml').html(response.editHtml);
                            $("#pre-loader").addClass('d-none');
                            $('#parent_id').niceSelect();

                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            $("#pre-loader").addClass('d-none');
                        }
                    });

                });

                $(document).on('submit', '#category_edit_form', function(event) {
                    event.preventDefault();
                    $("#pre-loader").removeClass('d-none');

                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");

                    var validFileExtensions = ['jpeg', 'jpg', 'png'];
                    var single_image=document.getElementById('image').files.length;
                    if(single_image ==1){
                        var size = (document.getElementById('image').files[0].size / 1024 / 1024).toFixed(2);
                        if (size > 1) {
                        toastr.error("{{__('product.file_size_must_be_less_than_1mb')}}", "{{__('common.error')}}")
                        return false;
                        }
                        var value=$('#image').val();
                        var type=value.split('.').pop().toLowerCase();
                        if ($.inArray(type, validFileExtensions) == -1) {
                        toastr.error("{{__('product.type_should_be_jpg_jpeg_png')}}", "{{__('common.error')}}")
                        return false;
                        }
                        formData.append('image', document.getElementById('image').files[0]);

                    }


                    $.ajax({
                        url: "{{ route('product.category.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {

                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $('#formHtml').html(response.createForm);
                            $("#pre-loader").addClass('d-none');
                            $('#parent_id').niceSelect();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            showValidationErrors('#category_edit_form', response.responseJSON.errors);
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });


                $(document).on('click', '.delete_brand', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });


                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#deleteItemModal').modal('hide');
                    $("#pre-loader").removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('product.category.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if(response.parent_msg){
                                toastr.warning(response.parent_msg);
                                $("#pre-loader").addClass('d-none');
                            }
                            else{
                                resetAfterChange(response.TableData);
                                toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                                $("#pre-loader").addClass('d-none');
                                $('#formHtml').html(response.createForm);

                            }

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.show_category', function(event){
                    event.preventDefault();
                    let item = $(this).data('value');
                    showDetails(item);

                });

                function showDetails(item) {
                    $('#item_show').modal('show');
                    $('#show_name').text(item.name);
                    $('#show_slug').text(item.slug);
                    $('#show_searchable').text(item.searchable? 'Active':'Inactive');
                    $('#show_parent_category').text(item.parent_category? item.parent_category.name : 'Parent');
                    $('#show_icon').text(item.icon);
                    $('#show_status').text(item.status? 'Active':'Inactive');

                    if(item.category_image.image) {
                        $('#single_image_div').removeClass('d-none');
                        var imag= item.category_image.image;
                        var image_path = "{{asset(asset_path(''))}}" + "/"+imag;
                        document.getElementById('view_image').src=image_path;
                    }else{
                        $('#single_image_div').addClass('d-none');
                    }

                }

                function showValidationErrors(formType, errors) {
                    $(formType +' #error_name').text(errors.name);
                    $(formType +' #error_slug').text(errors.slug);
                    $(formType +' #error_searchable').text(errors.searchable);
                    $(formType +' #error_icon').text(errors.icon);
                    $(formType +' #error_status').text(errors.status);
                    $(formType +' #error_image').text(errors.image);
                }

                function resetValidationErrors(){
                    $('#error_name').text('');
                    $('#error_slug').text('');
                    $('#error_searchable').text('');
                    $('#error_icon').text('');
                    $('#error_status').text('');
                    $('#error_image').text('');
                }


                function resetAfterChange(tableData) {
                    $('#item_table').empty();
                    $('#item_table').html(tableData);
                    CRMTableThreeReactive();

                }

            });
        })(jQuery);

    </script>

@endpush
