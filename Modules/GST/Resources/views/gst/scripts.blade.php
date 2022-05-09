@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            var baseUrl = $('#url').val();
            $(document).ready(function () {

                $(document).on("submit", "#gstForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('gst_tax.store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}");
                            $("#gstForm").trigger("reset");
                            gstList();
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
                                    $("#" + key + "_error").html(message[0]);
                                });
                            }
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
                //
                $(document).on("submit", "#gstEditForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/gst-setup/gst/update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#gstEditForm").trigger("reset");
                            $('.edit_div').hide();
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('.create_div').show();
                            gstList();
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

                $(document).on("click", ".edit_gst", function () {
                    let gst = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    $(".name").val(gst.name);
                    $(".rate").val(gst.tax_percentage);
                    $(".edit_id").val(gst.id);
                    if(gst.is_active == 1){
                        $('#status_active').prop("checked", true);
                        $('#status_inactive').prop("checked", false);
                    }else{
                        $('#status_active').prop("checked", false);
                        $('#status_inactive').prop("checked", true);
                    }
                });

                $(document).on('click', '.delete_gst', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    let url = baseUrl + '/gst-setup/gst/delete/' + id;
                    confirm_modal(url);
                });

                function gstList() {
                    $.ajax({
                        url: "{{route("gst_tax.list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#gst_list").html(response);
                            CRMTableThreeReactive();
                        },
                        error: function (response) {

                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    });
                }

            });
        })(jQuery);
    </script>
@endpush
