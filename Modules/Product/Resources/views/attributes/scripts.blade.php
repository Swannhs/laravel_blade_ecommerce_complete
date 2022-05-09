@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {
                $('.edit_div').hide();
                $(".basic").spectrum();

                $(document).on('click', '.remove', function () {
                    $(this).parents('.variant_row_lists').remove();
                });

                $(document).on('click','.add_single_variant_row',function () {
                    $('.variant_row_lists:last').after(`<tr class="variant_row_lists">
                            <td class="pl-0 pb-0 border-0">
                                    <input class="placeholder_input" placeholder="-" name="variant_values[]" type="text">
                            </td>
                            <td class="pl-0 pb-0 pr-0 remove border-0">
                                <div class="items_min_icon "><i class="ti-trash"></i></div>
                        </td></tr>`);
                });

                $(document).on('click', '.remove_edit', function () {
                    $(this).parents('.variant_edit_row_lists').remove();
                });
                $(document).on('click', '.add_single_variant_edit_row', function () {
                    $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                            <td class="pl-0 pb-0 border-0">
                                <input class="placeholder_input" placeholder="-" name="edit_variant_values[]" type="text">
                            </td>
                            <td class="pl-0 pb-0 pr-0 remove_edit border-0">
                                <div class="items_min_icon "><i class="ti-trash"></i></div>
                    </td></tr>`);
                });

                $(document).on('click', '.add_color_variant_edit_row', function () {
                    $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                            <td class="pl-0 pb-0 border-0">
                                <input type='text' class='basic placeholder_input' name="edit_variant_values[]" id='basic' value='' />
                            </td>
                            <td class="pl-0 pb-0 border-0">
                                <input type='text' class='placeholder_input' placeholder='{{__('product.color_name')}}' name="edit_variant_c_name[]" value='' />
                            </td>
                            <td class="pl-0 pb-0 pr-0 remove_edit border-0">
                                <div class="items_min_icon "><i class="ti-trash"></i></div>
                        </td></tr>`);
                    $(".basic").spectrum();
                });


                $(document).on("submit", "#variantForm", function (event) {
                    event.preventDefault();
                    $("#pre-loader").removeClass('d-none');
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        if (formData[key].name !== 'variant_values[]') {
                            $("#" + formData[key].name + "_error").html("");
                        }
                    });
                    $.ajax({
                        url: "{{ route('product.attribute.store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}");
                            $("#variantForm").trigger("reset");
                            $('.create_table tr').slice(1).remove();
                            variantList();
                            $("#pre-loader").addClass('d-none');
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
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });
                //
                $(document).on("submit", "#attributeEditForm", function (event) {
                    event.preventDefault();
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    
                    $("#pre-loader").removeClass('d-none');
                    $.ajax({
                        url: baseUrl + "/products/attribute-list/" + id + "/update",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('.form_div').html(response.createForm);
                            variantList();
                            $("#pre-loader").addClass('d-none');
                        },

                        error: function (response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            if (response) {
                                $.each(response.responseJSON.errors, function (key, message) {
                                    $("#edit_" + key + "_error").html(message[0]);
                                });
                            }
                            $("#pre-loader").addClass('d-none');
                        }
                    });
                });

                $(document).on("click", ".edit_variant", function () {
                    let id = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    $(".variant_edit_row_lists").html("");
                    $("#pre-loader").removeClass('d-none');
                    $.ajax({
                        url: baseUrl + "/products/attribute-list/" + id + "/edit",
                        type: "GET",
                        success: function (response) {
                            $(".form_div").html(response);

                            $("#pre-loader").addClass('d-none');
                        },
                        error: function (error) {

                            $("#pre-loader").addClass('d-none');
                        }
                    });

                });
                function variantList() {
                    $.ajax({
                        url: "{{route("product.attribute.get_list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#variant_list").html(response);
                            CRMTableThreeReactive();
                        },
                        error: function (error) {

                        }
                    });
                }

                $(document).on('click', '.show_attribute', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $("#pre-loader").removeClass('d-none');
                    $.post('{{ route('product.attribute.show') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                        $('.show_div').html(data);
                        $('#item_show').modal('show');
                        $("#pre-loader").addClass('d-none');
                    });

                });

                $(document).on('click', '.delete_attribute', function(event){
                    event.preventDefault();
                    let value = $(this).data('value');
                    confirm_modal(value);

                });



            });
        })(jQuery);

    </script>
@endpush
