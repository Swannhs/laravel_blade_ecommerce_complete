@push('scripts')
    <script>

        (function($){
            "use strict";
            @if($errors->any())
                $('#CreateModal').modal('show');
            @endif

            $(document).ready(function(){

                $('#copyright_form').on('submit', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $("#copyrightBtn").prop('disabled', true);
                    $('#copyrightBtn').text('{{ __('common.updating') }}');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('footerSetting.footer.content-update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#copyrightBtn').text('{{__('common.update')}}');
                            $("#copyrightBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#copyrightBtn').text('{{__('common.update')}}');
                            $("#copyrightBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $('#aboutForm').on('submit', function(event) {
                    event.preventDefault();
                    var about_title = $('#about_title').val();
                    if(about_title != ''){
                        $("#aboutSectionBtn").prop('disabled', true);
                        $('#aboutSectionBtn').text('{{ __('common.updating') }}');
                        $('#pre-loader').removeClass('d-none');
                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });
                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('footerSetting.footer.content-update') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                                $('#aboutSectionBtn').text('{{__('common.update')}}');
                                $("#aboutSectionBtn").prop('disabled', false);
                                $('#pre-loader').addClass('d-none');
                            },
                            error: function(response) {
                                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                $('#aboutSectionBtn').text('{{__('common.update')}}');
                                $("#aboutSectionBtn").prop('disabled', false);
                                $('#pre-loader').addClass('d-none');

                                if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }

                            }
                        });
                    }else{
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                });

                $('#aboutDescriptionForm').on('submit', function(event) {
                    event.preventDefault();
                    $("#aboutDescriptionBtn").prop('disabled', true);
                    $('#aboutDescriptionBtn').text('{{ __('common.updating') }}');
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('footerSetting.footer.content-update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#aboutDescriptionBtn').text('{{__('common.update')}}');
                            $("#aboutDescriptionBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#aboutDescriptionBtn').text('{{__('common.update')}}');
                            $("#aboutDescriptionBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');

                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                        }
                    });
                });

                $('#companyForm').on('submit', function(event) {
                    event.preventDefault();
                    $("#companyBtn").prop('disabled', true);
                    $('#companyBtn').text('{{ __('common.updating') }}');
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('footerSetting.footer.content-update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#companyBtn').text('{{__('common.update')}}');
                            $("#companyBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#companyBtn').text('{{__('common.update')}}');
                            $("#companyBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                        }
                    });
                });

                $('#accountForm').on('submit', function(event) {
                    event.preventDefault();
                    $("#accountBtn").prop('disabled', true);
                    $('#accountBtn').text('{{ __('common.updating') }}');
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('footerSetting.footer.content-update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#accountBtn').text('{{__('common.update')}}');
                            $("#accountBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#accountBtn').text('{{__('common.update')}}');
                            $("#accountBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                        }
                    });
                });

                $('#serviceForm').on('submit', function(event) {
                    event.preventDefault();
                    $("#serviceBtn").prop('disabled', true);
                    $('#serviceBtn').text('{{ __('common.updating') }}');
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('footerSetting.footer.content-update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#serviceBtn').text('{{__('common.update')}}');
                            $("#serviceBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $('#serviceBtn').text('{{__('common.update')}}');
                            $("#serviceBtn").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                        }
                    });
                });

                $(document).on('click', '.active_section_class', function(event){
                    let id = $(this).data('id');
                    let url = "/footer/footer-setting/tab/" + id;
                    $.ajax({
                            url: url,
                            type: "GET",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {

                            },
                            error: function(response) {

                        }
                    });
                });

                $(document).on('click', '.create_page_btn', function(event){
                    event.preventDefault();
                    let section_id = $(this).data('id');
                    $('#CreateModal').modal('show');
                    $('#section_id').val(section_id);
                });

                $(document).on('change', '.statusChange', function(event){
                    let item = $(this).data('value');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', item.id);
                    formData.append('status', item.status);
                    $.ajax({
                        url: "{{ route('footerSetting.footer.widget-status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
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

                $(document).on('click', '.edit_page', function(event){
                    event.preventDefault();
                    let page = $(this).data('value');
                    $('#editModal').modal('show');
                    $('#widget_name').val(page.name).addClass('has-content');
                    $('#widgetEditId').val(page.id);
                    $("#editCategory").val(page.category);
                    $('#editCategory').niceSelect('update');

                    $("#editPage").val(page.page);
                    $('#editPage').niceSelect('update');

                    if(page.is_static == 1){
                        $('#editPageFieldDiv').css("display","none");
                        $('#editCategoryFieldDiv').removeClass("col-lg-6").addClass("col-lg-12");
                    }else{
                        $('#editPageFieldDiv').css("display","inherit");
                        $('#editCategoryFieldDiv').removeClass("col-lg-12").addClass("col-lg-6");
                    }
                });

                $(document).on('click', '.delete_page', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#deleteItemModal').modal('show');
                    let base_url = "{{url('/')}}";
                    let route = base_url + '/footer/footer-widget-delete/' +id;
                    $('#deleteBtn').attr('href',route);
                });


            });
        })(jQuery);


    </script>
@endpush

