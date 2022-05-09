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
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('hr.staff_list') }}</h3>
                            @if(permissionCheck('staffs.store'))
                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('staffs.create') }}"><i class="ti-plus"></i>{{ __('common.add_new') }} {{ __('hr.staff') }}</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.name') }}</th>
                                        <th scope="col">{{ __('common.username') }}</th>
                                        <th scope="col">{{ __('common.email') }}</th>
                                        <th scope="col">{{ __('common.phone') }}</th>
                                        <th scope="col">{{ __('hr.role') }}</th>
                                        <th scope="col">{{ __('common.status') }}</th>
                                        <th scope="col">{{ __('hr.department') }}</th>
                                        <th scope="col">{{ __('common.registered_date') }}</th>
                                        <th scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($staffs as $key => $staff)
                                        @if ($staff->user != null)
                                            <tr>
                                                <th>{{ $key+1 }}</th>
                                                <td><a href="{{ route('staffs.view', $staff->id) }}">{{ucwords( @$staff->user->getFullNameAttribute() ) }}</a></td>
                                                
                                                <td>{{ @$staff->user->username }}</td>
                                                <td><a href="mailto:{{ @$staff->user->email }}">{{ @$staff->user->email }}</a></td>
                                                <td><a href="tel:{{ @$staff->phone }}">{{ @$staff->phone }}</a></td>
                                                <td>{{ @$staff->user->role->name }}</td>
                                                <td>
                                                    @if (@$staff->user->role_id != 1)
                                                        <label class="switch_toggle" for="active_checkbox{{ $staff->id }}">
                                                        <input class="update_status_staff" type="checkbox" id="active_checkbox{{ $staff->id }}" {{ permissionCheck('staffs.edit') ? '' : 'disabled' }} {{$staff->user->is_active == 1 ? 'checked' : ''}}
                                                        value="{{ $staff->id }}" data-id="{{$staff->user->id}}">
                                                        <div class="slider round"></div>
                                                    </label>
                                                    @endif

                                                </td>
                                                <td>{{ @$staff->department->name }}</td>
                                               <td>{{ date(app('general_setting')->dateFormat->format, strtotime($staff->created_at)) }}</td>

                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                            @if(permissionCheck('staffs.view'))
                                                            <a href="{{ route('staffs.view', $staff->id) }}" class="dropdown-item">{{__('common.view')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.edit'))
                                                            <a href="{{ route('staffs.edit', $staff->id) }}" class="dropdown-item">{{__('common.edit')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.destroy'))
                                                            <a data-value="{{route('staffs.destroy', $staff->user->id)}}" class="dropdown-item delete_staff">{{__('common.delete')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($) {
        	"use strict";
            $(document).ready(function(){
                $(document).on('change','.payrollPayment', function(){
                    if(this.checked){
                        var status = 1;
                    }
                    else{
                        var status = 0;
                    }
                    $.post('{{ route('staffs.update_active_status') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                        if(data.success){
                            toastr.success(data.success);
                        }
                        else{
                            toastr.error(data.error);
                        }
                    }).fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

            });
                });

                $(document).on('click', '.delete_staff', function(event){
                    event.preventDefault();
                    let value = $(this).data('value');
                    confirm_modal(value);
                });

                $(document).on('change', '.update_status_staff', function(){
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
                        url: "{{ route('staffs.update_active_status') }}",
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
            });
        })(jQuery);
    </script>
@endpush
