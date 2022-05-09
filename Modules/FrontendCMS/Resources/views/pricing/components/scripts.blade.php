@push('scripts')

    <script>
        (function($){
            "use strict";

            $(document).ready(function() {

                $(document).on('submit', '#item_delete_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    let id = $('#delete_item_id').val();
                    $('#deleteItemModal').modal('hide');
                    $.ajax({
                        url: "{{ route('admin.pricing.delete') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');

                            $.ajax({
                                url: "{{ route('admin.pricing.create') }}",
                                type: "GET",
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#formHtml').empty();
                                    $('#formHtml').html(response.editHtml);
                                    $('#monthly_cost').addClass(
                                        'has-content');
                                    $('#yearly_cost').addClass(
                                        'has-content');
                                    $('#team_size').addClass(
                                        'has-content');
                                    $('#stock_limit').addClass(
                                        'has-content');
                                    $('#commission').addClass(
                                        'has-content');
                                    $('#transaction_fee')
                                        .addClass('has-content');
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


                $(document).on('submit','#pricing_edit_form', function(event) {
                    event.preventDefault();
                    $("#edit_btn").prop('disabled', true);
                    $('#edit_btn').text('{{ __("common.updating") }}');
                    $('#pre-loader').removeClass('d-none');
                    removeValidationError();
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#item_id').val());

                    $.ajax({
                        url: "{{ route('admin.pricing.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text('{{ __("common.update") }}');

                            $.ajax({
                                url: "{{ route('admin.pricing.create') }}",
                                type: "GET",
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#formHtml').empty();
                                    $('#formHtml').html(response.editHtml);
                                    $('#monthly_cost').addClass(
                                        'has-content');
                                    $('#yearly_cost').addClass(
                                        'has-content');
                                    $('#team_size').addClass(
                                        'has-content');
                                    $('#stock_limit').addClass(
                                        'has-content');
                                    $('#commission').addClass(
                                        'has-content');
                                    $('#transaction_fee')
                                        .addClass('has-content');
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

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                            }
                            showValidationErrors('#pricing_edit_form', response.responseJSON
                                .errors);
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text('{{ __("common.update") }}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit','#add_pricing_form' , function(event) {
                    event.preventDefault();
                    $("#create_btn").prop('disabled', true);
                    $('#create_btn').text('{{ __("common.submitting") }}');

                    $('#pre-loader').removeClass('d-none');
                    removeValidationError();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('admin.pricing.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.created_successfully')}}","{{__('common.success')}}");
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text('{{ __("common.save") }}');
                            resetForm();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                            }
                            toastr.error("{{__('common.error_message')}}");
                            showValidationErrors('#add_pricing_form', response.responseJSON.errors);
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text('{{ __("common.save") }}');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('change', '.statusChange', function(event){
                    let item = $(this).data('value');
                    $('#pre-loader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', item.id);
                    formData.append('status', item.status);
                    $.ajax({
                        url: "{{ route('admin.pricing.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
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

                $(document).on('click', '.show_pricing', function(event){
                    event.preventDefault();
                    let item = $(this).data('value');
                    $('#item_show').modal('show');
                    $('#show_name').text(item.name);
                    $('#show_monthly_cost').text(item.monthly_cost);
                    $('#show_yearly_cost').text(item.yearly_cost);
                    $('#show_team_size').text(item.team_size);
                    $('#show_stock_limit').text(item.stock_limit);
                    $('#show_pricing_type').text(item.pricing_type);
                    $('#show_transaction_fee').text(item.transaction_fee);
                });

                $(document).on('click', '.delete_pricing', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });

                $(document).on('click', '.edit_pricing', function(event){
                    event.preventDefault();
                    let item = $(this).data('value');
                    $('#pre-loader').removeClass('d-none');
                    let baseUrl = $('#url').val();
                    let url = baseUrl + '/admin/pricing/' + item.id + '/edit'
                    $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#formHtml').empty();
                            $('#formHtml').append(response.editHtml);

                            $('#pre-loader').addClass('d-none');

                            $('#item_id').val(item.id);
                            $('#name').val(item.name).addClass('has-content');
                            $('#monthly_cost').val(item.monthly_cost).addClass('has-content');
                            $('#yearly_cost').val(item.yearly_cost).addClass('has-content');
                            $('#team_size').val(item.team_size).addClass('has-content');
                            $('#stock_limit').val(item.stock_limit).addClass('has-content');
                            $('#transaction_fee').val(item.transaction_fee).addClass('has-content');
                            $('#best_for').val(item.best_for).addClass('has-content');
                            if (item.status == 1) {
                                $('#pricing_edit_form #status_active').prop("checked", true);
                                $('#pricing_edit_form #status_inactive').prop("checked", false);
                            } else {
                                $('#pricing_edit_form #status_active').prop("checked", false);
                                $('#pricing_edit_form #status_inactive').prop("checked", true);
                            }
                            if(item.is_featured == 1){

                                $('#pricing_edit_form #is_featured').prop("checked", true);
                            }else{
                                $('#pricing_edit_form #is_featured').prop("checked", false);
                            }
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });

                });

                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_name').text(errors.name);
                    $(formType + ' #error_monthly_cost').text(errors.monthly_cost);
                    $(formType + ' #error_yearly_cost').text(errors.yearly_cost);
                    $(formType + ' #error_team_size').text(errors.team_size);
                    $(formType + ' #error_stock_limit').text(errors.stock_limit);
                    $(formType + ' #error_commission').text(errors.commission);
                    $(formType + ' #error_transaction_fee').text(errors.transaction_fee);
                    $(formType + ' #error_buyer_fee').text(errors.buyer_fee);
                    $(formType + ' #status_error').text(errors.status);
                }

                function resetAfterChange(tableData) {
                    $('#item_table').empty();
                    $('#item_table').html(tableData);
                    CRMTableThreeReactive();
                }

                function resetForm() {
                    $('#add_pricing_form')[0].reset();
                }

                function removeValidationError(){
                    $('#error_name').text('');
                    $('#error_monthly_cost').text('');
                    $('#error_yearly_cost').text('');
                    $('#error_team_size').text('');
                    $('#error_stock_limit').text('');
                    $('#error_commission').text('');
                    $('#error_transaction_fee').text('');
                    $('#error_buyer_fee').text('');
                    $('#status_error').text('');
                }

            });

        })(jQuery);



    </script>

@endpush
