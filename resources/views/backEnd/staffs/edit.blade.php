@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/staff_edit.css'))}}" />


@endsection
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ __('hr.edit_staff_info') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{ route('staffs.update', $staff->user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="user_id" value="{{$staff->user_id}}">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('common.basic_info') }}</h3>
                                </div>
                            </div>
                            <hr>

                            <div class="col-xl-4 employee_id_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.staff_id') }} <span
                                            class="text-danger">*</span></label>
                                    <input name="employee_id" id="employee_id" class="primary_input_field name"
                                        placeholder="{{ __('hr.staff_id') }}" value="{{ $staff->employee_id }}"
                                        type="text" readonly>
                                    <span class="text-danger">{{$errors->first('employee_id')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.first_name') }} <span
                                            class="text-danger">*</span></label>
                                    <input name="first_name" class="primary_input_field name"
                                        placeholder="{{ __('common.first_name') }}"
                                        value="{{ old('first_name')?old('first_name'):@$staff->user->first_name }}"
                                        type="text">
                                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.last_name') }}</label>
                                    <input name="last_name" class="primary_input_field name"
                                        placeholder="{{ __('common.last_name') }}"
                                        value="{{ old('last_name')?old('last_name'):@$staff->user->last_name }}"
                                        type="text">
                                    <span class="text-danger">{{$errors->first('last_name')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.email')
                                        }}({{__('common.use_as_username')}})<span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field name"
                                        placeholder="{{ __('common.email') }}"
                                        value="{{ old('email')?old('email'):@$staff->user->email }}" type="email">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.phone_number') }}</label>
                                    <input name="phone" class="primary_input_field name"
                                        placeholder="{{ __('common.phone_number') }}"
                                        value="{{ old('phone')?old('phone'):@$staff->phone }}" type="text">
                                    <span class="text-danger">{{$errors->first('phone')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.password') }}
                                        ({{__('common.minimum_8_charecter')}})<span class="text-danger">*</span></label>
                                    <input name="password" class="primary_input_field name" value="{{old('password')}}"
                                        type="password" placeholder="*********">
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                </div>
                            </div>


                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.department') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="primary_select mb-25" name="department_id" id="department_id">
                                        @foreach ($departments as $key => $department)
                                        <option value="{{ $department->id }}" @if ($department->id ==
                                            $staff->department_id) selected @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first('department_id')}}</span>
                                </div>
                            </div>



                            <div class="col-xl-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.role') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="primary_select mb-25" name="role_id" id="role_id" required>
                                        @foreach ($roles as $key => $role)
                                        <option value="{{ $role->id }}-{{ $role->type }}" @if ($role->id ==
                                            $staff->user->role_id) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first('role_id')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4 current_address_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.address') }}</label>
                                    <input name="address" id="address" class="primary_input_field name"
                                        placeholder="{{ __('common.address') }}"
                                        value="{{ old('address')?old('address'):$staff->address }}" type="text">
                                    <span class="text-danger">{{$errors->first('address')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4 date_of_birth_div">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.date_of_birth') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{ __('common.date') }}"
                                                        class="primary_input_field primary-input date form-control"
                                                        id="date_of_birth" type="text" name="date_of_birth"
                                                        value="{{ old('date_of_birth')?old('date_of_birth'):date('m/d/Y', strtotime($staff->date_of_birth)) }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{$errors->first('date_of_birth')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('hr.date_of_joining') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{ __('common.date') }}"
                                                        class="primary_input_field primary-input date form-control"
                                                        type="text" name="date_of_joining"
                                                        value="{{old('date_of_joining')?old('date_of_joining'):date('m/d/Y', strtotime($staff->date_of_joining))}}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{$errors->first('date_of_joining')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('hr.applicable_for_leave') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{ __('common.date') }}"
                                                        class="primary_input_field primary-input date form-control"
                                                        type="text" name="leave_applicable_date"
                                                        value="{{old('leave_applicable_date')?old('leave_applicable_date'):date('m/d/Y', strtotime($staff->leave_applicable_date))}}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{$errors->first('leave_applicable_date')}}</span>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.avatar') }}
                                        (165x165)PX</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="placeholderFileOneName"
                                            placeholder="{{ __('common.browse_file') }}" readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_1">{{
                                                __('common.browse') }}</label>
                                            <input type="file" class="d-none" name="photo" id="document_file_1"
                                                accept="image/*">
                                        </button>


                                    </div>
                                    <span class="text-danger">{{$errors->first('photo')}}</span>


                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div id="businessImgDiv" class="logo_img">
                                    @if ($staff->user->avatar)
                                    <p id="documentCross" aria-disabled="true"><i class="fas fa-times img_cross"
                                            data-id="{{$staff->user->id}}"></i></p>
                                    @endif
                                    <div class="avatar_div">
                                        <img id="StaffImgShow"
                                            src="{{ showImage($staff->user->avatar?$staff->user->avatar:'backend/img/default.png') }}"
                                            alt="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-12 mt-5 bank_info_div">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('hr.bank_info') }}</h3>
                                </div>
                            </div>

                            <hr>

                            <div class="col-xl-6 bank_name_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.bank_name') }}</label>
                                    <input name="bank_name" id="bank_name" class="primary_input_field name"
                                        placeholder="{{ __('common.bank_name') }}"
                                        value="{{ old('bank_name')?old('bank_name'):$staff->bank_name }}" type="text">
                                    <span class="text-danger">{{$errors->first('bank_name')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-6 bank_branch_name_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.branch_name') }}</label>
                                    <input name="bank_branch_name" id="bank_branch_name"
                                        class="primary_input_field name" placeholder="{{ __('hr.branch_name') }}"
                                        value="{{ old('bank_branch_name')?old('bank_branch_name'):$staff->bank_branch_name }}"
                                        type="text">
                                    <span class="text-danger">{{$errors->first('bank_branch_name')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-6 bank_account_name_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.account_name') }}</label>
                                    <input name="bank_account_name" id="bank_account_name"
                                        class="primary_input_field name" placeholder="{{ __('hr.account_name') }}"
                                        value="{{ old('bank_account_name')?old('bank_account_name'):$staff->bank_account_name }}"
                                        type="text">
                                    <span class="text-danger">{{$errors->first('bank_account_name')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-6 bank_account_no_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('hr.account_number') }}</label>
                                    <input name="bank_account_number" id="bank_account_no"
                                        class="primary_input_field name" placeholder="{{ __('hr.account_number') }}"
                                        value="{{ old('bank_account_number')?old('bank_account_number'):$staff->bank_account_no }}"
                                        type="text">
                                    <span class="text-danger">{{$errors->first('bank_account_number')}}</span>
                                </div>
                            </div>


                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                        id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('common.avatar'),'modal_id' => 'imgModal','form_id' => 'imgForm','delete_item_id' =>
    'delete_document_id','dataDeleteBtn'=>'document_delete_btn'])
</section>

@endsection
@push('scripts')
<script type="text/javascript">
    (function($){
        "use script";
        $(document).ready(function(){
            $(document).on('change', '#document_file_1', function(){
                getFileName($(this).val(),'#placeholderFileOneName');
                imageChangeWithFile($(this)[0],'#StaffImgShow');
                $('#documentCross').addClass('d-none');
            });

            $(document).on('click', '.img_cross', function(){
                let id = $(this).data('id');
                $('#delete_document_id').val(id);
                $('#imgModal').modal('show');
            });

            $(document).on('submit','#imgForm',function(event){
                event.preventDefault();

                $("#document_delete_btn").prop('disabled', true);
                $('#document_delete_btn').val("{{ __('common.deleting') }}");
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_document_id').val());
                $.ajax({
                    url: "{{ route('staff.img.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response ==1){
                            $('#businessImgDiv').empty();
                            $('#businessImgDiv').append(`'<img
                            id="StaffImgShow" src="{{showImage('backend/img/default.png')}}" alt="">'`);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $("#document_delete_btn").prop('disabled', false);
                            $('#document_delete_btn').val('{{ __('common.delete') }}');
                            $('#imgModal').modal('hide');
                        }else{
                            toastr.error("{{__('common.not_deleted')}}","{{__('common.error')}}");
                            $("#document_delete_btn").prop('disabled', false);
                            $('#document_delete_btn').val("{{ __('common.delete') }}");
                            $('#imgModal').modal('hide');
                        }
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        $('#imgModal').modal('hide');
                        $("#document_delete_btn").prop('disabled', false);
                        $('#document_delete_btn').val('{{ __('common.delete') }}');
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            toastr.error("{{__('common.not_deleted')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
        });
    })(jQuery);

</script>
@endpush
