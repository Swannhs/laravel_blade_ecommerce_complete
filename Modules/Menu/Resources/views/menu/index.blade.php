@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />
    <link rel="stylesheet" href="{{asset(asset_path('modules/menu/css/style.css'))}}" />
   
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                @if (permissionCheck('menu.store'))
                    <div class="col-lg-4 mb-20">
                        <div class="row">
                            <div id="formHtml" class="col-lg-12">
                                @include('menu::menu.components.create')
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-8">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('menu.menu_list')}}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div class="" id="item_table">
                                        @include('menu::menu.components.list')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
           </div>
        </div>
    </section>
    @if (permissionCheck('menu.delete'))
        @include('backEnd.partials._deleteModalForAjax',
        ['item_name' => __('menu.menu'),'modal_id' => 'deleteMenuModal',
        'form_id' => 'menu_delete_form','delete_item_id' => 'delete_menu_id','dataDeleteBtn' =>'menuDeleteBtn'])
    @endif
@endsection

@push('scripts')
    <script src="{{asset(asset_path('backend/vendors/js/icon-picker.js'))}}"></script>
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){

                $(document).on('mouseover', 'body', function(){
                    $('#icon').iconpicker({
                        animation:true
                    });
                });

                $(document).on('keyup', '#name', function(){
                    let value = $('#name').val();
                    processSlug(value, '#slug');
                });

                $(document).on('submit', '#create_form', function(event){
                    event.preventDefault();
                    $("#create_btn").prop('disabled', true);
                    $('#create_btn').text('{{ __('common.submitting') }}');
                    $('#pre-loader').removeClass('d-none');
                    resetValidationErrors('#create_form');

                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('menu.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);

                            resetForm();
                            toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text("{{ __('common.save') }}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            $("#create_btn").prop('disabled', false);
                            $('#create_btn').text("{{ __('common.save') }}");
                            $('#pre-loader').addClass('d-none');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            showValidationErrors('#create_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('submit', '#edit_form', function(event){
                    event.preventDefault();
                    $("#edit_btn").prop('disabled', true);
                    $('#edit_btn').text('{{ __('common.updating') }}');
                    $('#pre-loader').removeClass('d-none');
                    resetValidationErrors('#edit_form');

                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('menu.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            resetForm();
                            $('#formHtml').empty();
                            $('#formHtml').html(response.CreateForm);
                            $('#menu_type').niceSelect();
                            $('#menu_position').niceSelect();
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text("{{ __('common.update') }}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            $("#edit_btn").prop('disabled', false);
                            $('#edit_btn').text("{{ __('common.update') }}");
                            $('#pre-loader').addClass('d-none');
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                            toastr.error("{{ __('common.error_message') }}", "{{__('common.error')}}");
                            showValidationErrors('#edit_form', response.responseJSON.errors);
                        }
                    });
                });

                $(document).on('submit', '#menu_delete_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteMenuModal').modal('hide');
                    let id = $('#delete_menu_id').val();
                    let data = {
                        'id' : id,
                        '_token' : '{{ csrf_token() }}'
                    }
                    $.post("{{ route('menu.delete') }}",data, function(data){
                        $('#pre-loader').addClass('d-none');
                        if(data == 'not_posible'){
                            toastr.warning("{{__('apperance.warning_message')}}");
                            return false;
                        }

                        toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                        reloadWithData(data);

                    })
                    .fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                    });
                });

                $(document).on('change', '.menu_status_change', function(event) {
                    event.preventDefault();
                    let status = 0;
                    if($(this).prop('checked')){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('id');
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('menu.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                            toastr.error("{{__('common.error_message')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });

                });

                $(document).on('click', '.edit_menu', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(this).data('id');
                    let base_url = $('#url').val();
                    let url = base_url + '/menu/edit?id=' + id;
                    $.get(url, function(data){
                        $('#formHtml').empty();
                        $('#formHtml').html(data);
                        $('#menu_type').niceSelect();
                        $('#menu_position').niceSelect();

                        $('#pre-loader').addClass('d-none');
                    });

                });

                $(document).on('click', '.delete_menu', function(event) {
                    event.preventDefault();
                    let id = $(this).data('id');
                    if(id != null){
                        $('#delete_menu_id').val(id);
                        $('#deleteMenuModal').modal('show');

                    }else{
                        toastr.error("{{ __('common.error_message') }}")
                    }

                });

                function reloadWithData(response){
                    $('#item_table').empty();
                    $('#item_table').html(response.TableData);
                    CRMTableThreeReactive();
                }
                function showValidationErrors(formType, errors){
                    $(formType + ' #error_name').text(errors.name);
                    $(formType + ' #error_slug').text(errors.slug);
                    $(formType + ' #error_menu_type').text(errors.menu_type);
                    $(formType + ' #error_menu_position').text(errors.menu_position);
                }
                function resetValidationErrors(formType){
                    $(formType + ' #error_name').text('');
                    $(formType + ' #error_slug').text('');
                    $(formType + ' #error_menu_type').text('');
                    $(formType + ' #error_menu_position').text('');
                }
                function resetForm(){
                    $('form')[2].reset();
                    $('select').niceSelect('update');
                }

            });
        })(jQuery);


    </script>
@endpush
