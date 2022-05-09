@push('scripts')
    <script>
        (function($){
            "use strict";
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = mm + '/' + dd + '/' + yyyy;

            $(document).ready(function(){
                couponDataTable();
                $('#date').daterangepicker({
                    "timePicker": false,
                    "linkedCalendars": false,
                    "autoUpdateInput": false,
                    "showCustomRangeLabel": false,
                    "startDate": today,
                    "endDate": today
                }, function(start, end, label) {
                    $('#date').val(start.format('DD-MM-YYYY')+' to ' + end.format('DD-MM-YYYY'));
                    $('#start_date').val(start.format('DD-MM-YYYY'));
                    $('#end_date').val(end.format('DD-MM-YYYY'));
                });

                $(document).on('change','#coupon_type', function(event){
                    $('#error_coupon_type').text('');
                    $('#formDataDiv').empty();
                    removeValidateError();
                    $('#pre-loader').removeClass('d-none');
                    let id = $('#coupon_type').val();
                    let base_url = $('#url').val();
                    let url = base_url + '/marketing/coupon/get-form?id=' + id;
                    $.get(url, function(data) {
                        $('#formDataDiv').html(data);
                        $('#product_list').niceSelect();
                        $('#discount_type').niceSelect();
                        $('#date').daterangepicker({
                            "timePicker": false,
                            "linkedCalendars": false,
                            "autoUpdateInput": false,
                            "showCustomRangeLabel": false,
                            "startDate": today,
                            "endDate": today
                        }, function(start, end, label) {
                            $('#date').val(start.format('DD-MM-YYYY')+' to ' + end.format('DD-MM-YYYY'));
                            $('#start_date').val(start.format('DD-MM-YYYY'));
                            $('#end_date').val(end.format('DD-MM-YYYY'));
                        });
                        $('#pre-loader').addClass('d-none');
                    });
                });

                $(document).on('submit','#add_form', function(event){
                    event.preventDefault();
                    let coupon_type = $('#coupon_type').val();
                    removeValidateError();
                    if(coupon_type == null){
                        $('#error_coupon_type').text("{{__('marketing.select_coupon_type_first')}}");
                    }else{
                        $('#error_coupon_type').text('');
                        $("#submit_btn").prop('disabled', true);
                        $('#submit_btn').text('{{ __("common.submitting") }}');

                        $('#pre-loader').removeClass('d-none');

                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('marketing.coupon.store') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                reloadWithData(response);
                                resetForm('#add_form');
                                toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.save") }}');
                                $('#pre-loader').addClass('d-none');
                            },
                            error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.save") }}');
                                $('#pre-loader').addClass('d-none');
                                toastr.error('{{ __("common.error_message") }}', "{{__('common.error')}}");
                                showValidationErrors('#add_form', response.responseJSON.errors);
                            }
                        });
                    }
                });

                $(document).on('submit','#edit_form', function(event){
                    event.preventDefault();
                    let coupon_type = $('#coupon_type').val();
                    removeValidateError();
                    if(coupon_type == null){
                        $('#error_coupon_type').text("{{__('marketing.select_coupon_type_first')}}");
                    }else{
                        $('#error_coupon_type').text('');
                        $("#submit_btn").prop('disabled', true);
                        $('#submit_btn').text('{{ __("common.updating") }}');

                        $('#pre-loader').removeClass('d-none');

                        var formElement = $(this).serializeArray()
                        var formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });

                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ route('marketing.coupon.update') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                reloadWithData(response);
                                $('#form_div').empty();
                                $('#form_div').html(response.createForm);
                                $('#coupon_type').niceSelect();
                                toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.update") }}');
                                $('#pre-loader').addClass('d-none');
                            },
                            error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                                $("#submit_btn").prop('disabled', false);
                                $('#submit_btn').text('{{ __("common.update") }}');
                                $('#pre-loader').addClass('d-none');
                                toastr.error('{{ __("common.error_message") }}', "{{__('common.error')}}");
                                showValidationErrors('#edit_form', response.responseJSON.errors);
                            }
                        });
                    }
                });


                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteItemModal').modal('hide');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $.ajax({
                        url: "{{ route('marketing.coupon.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            $('#form_div').html(response.createForm);
                            $('#coupon_type').niceSelect();
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error('{{ __("common.error_message") }}', "{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.edit_coupon', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    let start_date = $(this).data('start_date');
                    let end_date = $(this).data('end_date');
                    editCoupon(id, start_date, end_date);
                });
                $(document).on('click', '.delete_coupon', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });



                function editCoupon(id,start_date,end_date){
                    $('#pre-loader').removeClass('d-none');
                    let base_url = $('#url').val();
                    let url = base_url + '/marketing/coupon/edit?id=' + id;

                    $.get(url, function(data) {
                        $('#form_div').empty();
                        $('#form_div').html(data);
                        $('#product_list').niceSelect();
                        $('#discount_type').niceSelect();
                        $('#coupon_type').niceSelect();
                        $('#date').daterangepicker({
                            "timePicker": false,
                            "linkedCalendars": false,
                            "autoUpdateInput": false,
                            "showCustomRangeLabel": false,
                            "startDate": start_date,
                            "endDate": end_date
                        }, function(start, end, label) {
                            $('#date').val(start.format('DD-MM-YYYY')+' to ' + end.format('DD-MM-YYYY'));
                            $('#start_date').val(start.format('DD-MM-YYYY'));
                            $('#end_date').val(end.format('DD-MM-YYYY'));
                        });
                        $('#pre-loader').addClass('d-none');
                    });
                }

                function couponDataTable(){
                    $('#couponTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: "{{ route('marketing.coupon.get-data') }}"
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'title', name: 'title' },
                            { data: 'coupon_code', name: 'coupon_code' },
                            { data: 'type', name: 'type' },
                            { data: 'start_date', name: 'start_date' },
                            { data: 'end_date', name: 'end_date' },
                            { data: 'action', name: 'action' }

                        ],

                        bLengthChange: false,
                        "bDestroy": true,
                        language: {
                            search: "<i class='ti-search'></i>",
                            searchPlaceholder: trans('common.quick_search'),
                            paginate: {
                                next: "<i class='ti-arrow-right'></i>",
                                previous: "<i class='ti-arrow-left'></i>"
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'copyHtml5',
                                text: '<i class="fa fa-files-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'Copy',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel',
                                title: $("#logo_title").val(),
                                margin: [10, 10, 10, 0],
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },

                            },
                            {
                                extend: 'csvHtml5',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                title: $("#logo_title").val(),
                                titleAttr: 'PDF',
                                exportOptions: {
                                    columns: ':visible',
                                    columns: ':not(:last-child)',
                                },
                                orientation: 'landscape',
                                pageSize: 'A4',
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                header: true,
                                customize: function (doc) {
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: "data:image/png;base64," + $("#logo_img").val()
                                    });
                                }

                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Print',
                                title: $("#logo_title").val(),
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                }
                            },
                            {
                                extend: 'colvis',
                                text: '<i class="fa fa-columns"></i>',
                                postfixButtons: ['colvisRestore']
                            }
                        ],
                        columnDefs: [{
                            visible: false
                        }],
                        responsive: true,
                    });
                }

                function reloadWithData(response){
                    $('#item_table').empty();
                    $('#item_table').html(response.TableData);
                    couponDataTable();
                }

                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_coupon_code').text(errors.coupon_code);
                    $(formType + ' #error_coupon_type').text(errors.coupon_type);
                    $(formType + ' #error_coupon_title').text(errors.coupon_title);
                    $(formType + ' #error_date').text(errors.date);
                    $(formType + ' #error_products').text(errors.product_list);
                    $(formType + ' #error_discount').text(errors.discount);
                    $(formType + ' #error_discount_type').text(errors.discount_type);
                    $(formType + ' #error_minimum_shopping').text(errors.minimum_shopping);
                    $(formType + ' #error_maximum_discount').text(errors.maximum_discount);
                }
                function resetForm(form) {
                    $('#add_form')[0].reset();
                    $('#formDataDiv').empty();
                    $('#coupon_type').niceSelect('update');
                }

                function removeValidateError(){
                    $('#error_coupon_code').text('');
                    $('#error_coupon_type').text('');
                    $('#error_coupon_title').text('');
                    $('#error_date').text('');
                    $('#error_products').text('');
                    $('#error_discount').text('');
                    $('#error_discount_type').text('');
                    $('#error_minimum_shopping').text('');
                    $('#error_maximum_discount').text('');
                }

            });
        })(jQuery);

    </script>
@endpush
