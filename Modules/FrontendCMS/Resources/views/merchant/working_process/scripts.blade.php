<script>

    (function($){

        "use strict";

        $(document).ready(function() {
            $(document).on('submit', '#work_create_form', function(event) {
                event.preventDefault();
                $("#create_work_btn").prop('disabled', true);
                $('#create_work_btn').text('{{ __("common.submitting") }}');
                $('#pre-loader').removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });

                let photo = $('#work_create_form_image')[0].files[0];
                formData.append('_token', "{{ csrf_token() }}");
                if (photo) {
                    formData.append('image', photo)
                }
                $.ajax({
                    url: "{{ route('frontendcms.how-it-work.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeWork(response.TableData)
                        resetValidationErrorsForBenefit('.work_create_form')
                        toastr.success("{{__('common.created_successfully')}}","{{__('common.success')}}")
                        $('#work_add').modal('hide');
                        $("#create_work_btn").prop('disabled', false);
                        $('#create_work_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        showValidationErrorsForBenefit('.work_create_form', response.responseJSON.errors);
                        $("#create_work_btn").prop('disabled', false);
                        $('#create_work_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('submit', '#work_edit_form', function(event) {
                event.preventDefault();
                $("#edit_work_btn").prop('disabled', true);
                $('#edit_work_btn').text('{{ __("common.updating") }}');
                $('#pre-loader').removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#work_id').val());
                let photo = $('#work_edit_form_image')[0].files[0];
                if (photo) {
                    formData.append('image', photo)
                }
                $.ajax({
                    url: "{{ route('frontendcms.working-process.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeWork(response.TableData)
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                        $('#work_edit').modal('hide');
                        $("#edit_work_btn").prop('disabled', false);
                        $('#edit_work_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        toastr.error("{{__('common.error_message')}}")
                        showValidationErrorsForBenefit('.work_edit_form', response.responseJSON
                            .errors);
                        $("#edit_work_btn").prop('disabled', false);
                        $('#edit_work_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('submit', '#work_delete_form', function(event) {
                event.preventDefault();
                $("#delete_work_btn").prop('disabled', true);
                $('#delete_work_btn').text('{{ __("common.deleting") }}');
                $('#pre-loader').removeClass('d-none');
                $('#deleteWorkModal').modal('hide');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_work_id').val());
                let id = $('#delete_work_id').val();
                $.ajax({
                    url: "{{ route('frontendcms.working-process.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChangeWork(response.TableData);
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                        $("#delete_work_btn").prop('disabled', false);
                        $('#delete_work_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        toastr.error("{{__('common.error_message')}}")
                        $("#delete_work_btn").prop('disabled', false);
                        $('#delete_work_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');

                    }
                });
            });

            $(document).on('change', '.working_process_img', function(event){
                let name_show_id = $(this).data('show_name_id');
                let img_show_id = $(this).data('img_id');
                getFileName($(this).val(), name_show_id);
                imageChangeWithFile($(this)[0], img_show_id);
            });

            $(document).on('click', '.add_working_process_modal', function(event){
                event.preventDefault();
                $('#work_add').modal('show');
            });

            $(document).on('click', '.delete_working_process', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_work_id').val(id);
                $('#deleteWorkModal').modal('show');
            });

            $(document).on('click', '.edit_working_process', function(event){

                event.preventDefault();
                $('#work_edit').modal('show');
                let work = $(this).data('value');
                resetValidationErrorsForBenefit('.work_edit_form');
                resetFormWork();
                $('#work_id').val(work.id);
                $(".work_edit_form #title").val(work.title);
                $('.work_edit_form #description').val(work.description);
                if (work.position == 1) {
                    $('.work_edit_form #position_left').prop("checked", true);
                    $('.work_edit_form #position_right').prop("checked", false);
                } else {
                    $('.work_edit_form #position_left').prop("checked", false);
                    $('.work_edit_form #position_right').prop("checked", true);
                }
                if (work.status == 1) {
                    $('.work_edit_form #status_active').prop("checked", true);
                    $('.work_edit_form #status_inactive').prop("checked", false);
                } else {
                    $('.work_edit_form #status_active').prop("checked", false);
                    $('.work_edit_form #status_inactive').prop("checked", true);
                }
                var workImage="{{asset(asset_path(''))}}" + "/"+work.image;
                $('.work_edit_form #workImgShow_work_edit_form').prop("src", workImage);
            });

            function resetFormWork(){
                $('#work_create_form')[0].reset();
                $('#work_edit_form')[0].reset();

                $('#img_div_for_work').html(`
                    <div class="primary_input mb-35">
                    <label class="primary_input_label" for="">{{__('common.image')}} <small class="ml-1">(60x60)px</small> <span class="text-danger">*</span></label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="working_process_work_create_form"
                            placeholder="{{__('common.browse_image_file')}}" readonly="">
                        <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="work_create_form_image"><span
                                    class="ripple rippleEffect browse_file_label"></span>{{__('common.browse')}}</label>
                            <input name="image" type="file" class="d-none working_process_img" id="work_create_form_image" data-show_name_id="#working_process_work_create_form" data-img_id="#workImgShow_work_create_form">
                        </button>
                        <span class="text-danger" id="create_error_image"></span><br>
                        <img id="workImgShow_work_create_form" class="workProcessImg"
                        src="{{showImage('backend/img/default.png')}}" alt="">
                    </div>
                </div>
                `);

            }

            function resetAfterChangeWork(tableData) {
                $('#work_table').html(tableData);
                resetFormWork();
            }


        });

    })(jQuery);

</script>
