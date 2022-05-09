@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function () {
                var baseUrl = $('#app_base_url').val();
                $(document).on("submit", "#processForm", function (event) {
                    event.preventDefault();
                    $('#name_create_error').html('');
                    $('#description_create_error').html('');
                    $('#pre-loader').removeClass('d-none');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('order_manage.cancel_reason_store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}")
                            $("#processForm").trigger("reset");
                            refund_process_list();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            if (response) {
                                $.each(response.responseJSON.errors, function (key, message) {
                                    $("#" + key + "_create_error").html(message[0]);
                                });
                            }
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
                //
                $(document).on("submit", "#processEditForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#edit_name_error').html('');
                    $('#edit_description_error').html('');
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/ordermanage/cancel-reason-update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#processEditForm").trigger("reset");
                            $('.edit_div').hide();
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                            $('.create_div').show();
                            $('#name_create_error').html('');
                            $('#description_create_error').html('');
                            refund_process_list();
                            $('#pre-loader').addClass('d-none');
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
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $("#refund_process_list").on("click", ".edit_reason", function () {
                    let item = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    $(".name").val(item.name);
                    $(".description").val(item.description);
                    $(".edit_id").val(item.id);
                });

                $(document).on('click', '.delete_item', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                });

                function refund_process_list() {
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: "{{route("order_manage.cancel_reason_list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#refund_process_list").html(response);
                            CRMTableThreeReactive();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (error) {

                        }
                    });
                }

            });
        })(jQuery);
    </script>
@endpush
