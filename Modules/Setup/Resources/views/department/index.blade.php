@extends('backEnd.master')
@section('mainContent')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="admin-visitor-area up_st_admin_visitor">

        @include('setup::department.components.create')
        @include('setup::department.components.edit')
        @include('backEnd.partials._deleteModalForAjax',['item_name' => 'Department'])

        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('hr.department') }} {{ __('common.list')  }}</h3>
                        @if(permissionCheck('departments.store'))
                            <ul class="d-flex">
                                <li><button class="primary-btn radius_30px mr-10 fix-gr-bg" id="add_new_btn"><i class="ti-plus"></i>{{ __('common.add_new') }} {{ __('hr.department') }}</button></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">
                                {{-- Department List --}}
                                @include('setup::department.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@push('scripts')
    <script>

        (function($){
            "use strict";
            var baseUrl = $('#app_base_url').val();

            $(document).ready(function() {
                $('#item_create_form').on('submit',function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    resetForm('.item_create_form');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });
                    formData.append('_token',"{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('departments.store')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                            $('#item_add').modal('hide');
                            $('#pre-loader').addClass('d-none');
                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            showValidationErrors('.item_create_form',response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $('#item_edit_form').on('submit',function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    resetForm('.item_edit_form');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });
                    formData.append('_token',"{{ csrf_token() }}");
                    formData.append('id',$('#item_id').val());
                    $.ajax({
                        url: "{{ route('departments.update')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            resetAfterChange(response.TableData)
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $('#item_edit').modal('hide');
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            showValidationErrors('.item_edit_form',response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $('#deleteItemModal').on('submit',function(event){
                    event.preventDefault();
                    $('#deleteItemModal').modal('hide');
                    $('#pre-loader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token',"{{ csrf_token() }}");
                    formData.append('id',$('#delete_item_id').val());
                    $.ajax({
                        url: "{{ route('departments.delete')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                            $('#pre-loader').removeClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.edit_department', function(event){
                    event.preventDefault();
                    let item = $(this).data('value');
                    editItem(item);
                });

                $(document).on('click', '.delete_department', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });

                $(document).on('click', '#add_new_btn', function(event){
                    event.preventDefault();
                    $('#item_add').modal('show');
                    $('#item_create_form')[0].reset();
                    resetForm('.item_create_form');
                });


                function editItem(item){
                    resetForm('.item_edit_form');
                    $('#item_edit').modal('show');
                    $('#item_id').val(item.id);
                    $(".item_edit_form #name").val(item.name);
                    $('.item_edit_form #details').val(item.details);
                    if(item.status == 1){
                            $('.item_edit_form #status_active').prop("checked", true);
                            $('.item_edit_form #status_inactive').prop("checked", false);
                    }else{
                            $('.item_edit_form #status_active').prop("checked", false);
                            $('.item_edit_form #status_inactive').prop("checked", true);
                    }
                }

                function showValidationErrors(formType, errors){
                    $(formType +' #name_error').text(errors.name);
                    $(formType +' #details_error').text(errors.percentage);
                    $(formType +' #status_error').text(errors.quantity);
                }

                function resetForm(form){
                    $(form +' #name_error').text('');
                    $(form +' #percentage_error').text('');
                }

                function resetAfterChange(tableData){
                    $('#item_table').empty();
                    $('#item_table').html(tableData);
                    CRMTableThreeReactive();
                }


            });
        })(jQuery);

    </script>
@endpush
