@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/attendance/css/style.css'))}}" />

@endsection
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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('hr.attendance') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.select_role') }}</label>
                                    <select class="primary_select mb-15 role_type" name="role_id" id="role_id">
                                        <option selected disabled>{{__('common.choose_one')}}</option>
                                        <option value="0"> {{__('common.all')}}</option>
                                        @foreach ($roles as $key => $role)
                                            @if($role->id !== 1)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first('role_type')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.date') }} <span class="text-danger">*</span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="{{ __('common.date') }}"
                                                           class="primary_input_field primary-input date form-control"
                                                           id="date" type="text" name="date"
                                                           value="{{date('m/d/Y')}}" autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="primary-btn btn-sm fix-gr-bg pull-right" id="search_btn"><i class="ti-search"></i>{{ __('common.search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="create_form">

    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('change', '#date', function(){
                    get_user();
                });
                $(document).on('change', '#role_id', function(){
                    get_user();
                });

                function get_user()
                {
                    var role_id = $('#role_id').val();
                    var date = $('#date').val();
                    if (role_id && date)
                    {
                        $('#pre-loader').removeClass('d-none');
                        $.post("{{ route('get_user_by_role') }}",{_token:'{{ csrf_token() }}', role_id:role_id,date:date}, function(data){
                            $(".create_form").html(data);
                            $('select').niceSelect();
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                }

                $(document).on('click', '#search_btn', function(){
                    toastr.warning("{{__('hr.select_Role_date_from_list')}}", "{{__('common.warning')}}");
                });
            });
        })(jQuery);

    </script>
@endpush
