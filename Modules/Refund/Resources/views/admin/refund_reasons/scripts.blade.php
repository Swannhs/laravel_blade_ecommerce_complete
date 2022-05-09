@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {

                $(document).on("submit", "#reasonForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#reason_create_error').html('');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('refund.reasons_store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}")
                            $("#reasonForm").trigger("reset");
                            refund_list();
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
                $(document).on("submit", "#reasonEditForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(".edit_id").val();
                    $('#edit_reason_error').html('');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/refund/refund-reason-update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#reasonEditForm").trigger("reset");
                            $('.edit_div').hide();
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                            $('.create_div').show();
                            $('#reason_create_error').html('');
                            refund_list();
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

                $(document).on('click', '.delete-item', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                })

                $("#refund_list").on("click", ".edit_reason", function () {
                    let item = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    $(".reason").val(item.reason);
                    $(".edit_id").val(item.id);
                });
                function refund_list() {
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: "{{route("refund.index")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#refund_list").html(response);
                            CRMTableThreeReactive();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

            });
        })(jQuery);
    </script>
@endpush
