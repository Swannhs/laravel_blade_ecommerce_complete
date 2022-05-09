@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/attendance/css/style.css'))}}" />

@endsection
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white">
                        <form class="" action="{{ route('holidays.store') }}" method="POST">@csrf
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('common.year') }} <span class="text-danger">*</span></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="{{ __('common.year') }}"
                                                               class="primary_input_field primary-input datepicker form-control"
                                                               type="text" id="year"
                                                               name="year" value="{{ date('Y') }}"
                                                               autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('date')}}</span>
                                    </div>
                                </div>
                            </div>
                            @if (permissionCheck('last.year.data'))
                                <div class="row">
                                    <div class="col-lg-12 text-right mb-2 mt-3">
                                        <a id="copy_previous_year_btn" href="{{route('last.year.data', date('Y'))}}"
                                           class="primary-btn btn-sm fix-gr-bg">{{__('hr.copy_previous_year_settings')}}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">

                                    <!-- table-responsivaae -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody class="holiday_table">
                                            <tr>
                                                <td>
                                                    <div class="primary_input mb-15 min-width-150">
                                                        <label class="primary_input_label"
                                                               for="">{{__('hr.holiday_name')}}</label>
                                                        <input type="text" name="holiday_name[]" id="holiday_row_1_name"
                                                               class="primary_input_field"
                                                               placeholder="{{__('hr.holiday_name')}}" value="" required>
                                                        <span
                                                            class="text-danger">{{$errors->first('holiday_name')}}</span>
                                                    </div>
                                                </td>
                                                <td id="holiday_row_1_type">
                                                    <div class="primary_input mb-15 min-width-150">
                                                        <label class="primary_input_label"
                                                               for="">{{__('common.select_type')}} <span class="text-danger">*</span></label>
                                                        <select class="primary_select mb-15 type"
                                                                name="type[]">
                                                            <option value="0">{{__('common.single_day')}}</option>
                                                            <option value="1">{{__('common.multiple_day')}}</option>
                                                        </select>
                                                        <span class="text-danger">{{$errors->first('type')}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="single_date">
                                                        <div class="primary_input mb-15 min-width-150">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.date') }}
                                                                <span class="text-danger">*</span></label>
                                                            <div class="primary_datepicker_input">
                                                                <div class="no-gutters input-right-icon">
                                                                    <div class="col">
                                                                        <div class="">
                                                                            <input placeholder="{{ __('common.date') }}" id="single_date"
                                                                                   class="primary_input_field primary-input date form-control"
                                                                                   type="text"
                                                                                   name="date[]"
                                                                                   value="{{date('m/d/Y')}}"
                                                                                   autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <button class="" type="button">
                                                                        <i class="ti-calendar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger">{{$errors->first('date')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="multiple_date d-none">
                                                        <div class="primary_input mb-15 min-width-150">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.start_date') }}
                                                                <span class="text-danger">*</span></label>
                                                            <div class="primary_datepicker_input">
                                                                <div class="no-gutters input-right-icon">
                                                                    <div class="col">
                                                                        <div class="">
                                                                            <input placeholder="{{ __('common.date') }}" id="first_row_start_date"
                                                                                   class="primary_input_field primary-input date form-control"
                                                                                   type="text"
                                                                                   name="start_date[]"
                                                                                   value="{{date('m/d/Y')}}"
                                                                                   autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <button class="" type="button">
                                                                        <i class="ti-calendar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="text-danger">{{$errors->first('start_date')}}</span>
                                                        </div>
                                                        <div class="primary_input mb-15 min-width-150">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('common.end_date') }}
                                                                <span class="text-danger">*</span></label>
                                                            <div class="primary_datepicker_input">
                                                                <div class="no-gutters input-right-icon">
                                                                    <div class="col">
                                                                        <div class="">
                                                                            <input placeholder="{{ __('common.date') }}" id="end_row_start_date"
                                                                                   class="primary_input_field primary-input date form-control"
                                                                                   type="text"
                                                                                   name="end_date[]"
                                                                                   value="{{date('m/d/Y')}}"
                                                                                   autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <button class="" type="button">
                                                                        <i class="ti-calendar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="text-danger">{{$errors->first('end_date')}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <a class="primary-btn primary-circle fix-gr-bg text-white" id="add_row_btn"
                                                           href=""> <i
                                                                class="ti-plus"></i></a>

                                                </td>
                                            </tr>
                                            @if (session()->has('holidays'))
                                                @php
                                                    $data = session()->get('holidays');
                                                @endphp
                                                @foreach ($data['holiday_name'] as $key=> $holiday)
                                                    <tr class="add_row">
                                                        <td>
                                                            <div class="primary_input mb-15 min-width-150">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('hr.holiday_name')}}</label>
                                                                <input type="text" name="holiday_name[]"
                                                                       class="primary_input_field"
                                                                       placeholder="{{__('hr.holiday_name')}}"
                                                                       value="{{$data['holiday_name'][$key]}}" required>
                                                                <span
                                                                    class="text-danger">{{$errors->first('holiday_name')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="primary_input mb-15 min-width-150">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('common.select_type')}} <span class="text-danger">*</span></label>
                                                                <select class="primary_select mb-15 type" name="type[]">
                                                                    <option
                                                                        value="0" {{$data['type'][$key] == 0 ? 'selected' : ''}}>{{__('common.single_day')}}</option>
                                                                    <option
                                                                        value="1" {{$data['type'][$key] == 1 ? 'selected' : ''}}>{{__('common.multiple_day')}}</option>
                                                                </select>
                                                                <span
                                                                    class="text-danger">{{$errors->first('type')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="single_date @if ($data['type'][$key] == 1) d-none @endif">
                                                                <div class="primary_input mb-15 min-width-150">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text" name="date[]"
                                                                                           value="{{$data['date'][$key]}}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="text-danger">{{$errors->first('date')}}</span>
                                                                </div>
                                                            </div>

                                                            <div class="multiple_date @if ($data['type'][$key] == 0) d-none @endif">
                                                                <div class="primary_input mb-15 min-width-150">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.start_date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text"
                                                                                           name="start_date[]"
                                                                                           value="{{$data['start_date'][$key]}}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="text-danger">{{$errors->first('start_date')}}</span>
                                                                </div>
                                                                <div class="primary_input mb-15 min-width-150">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.end_date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text" name="end_date[]"
                                                                                           value="{{$data['end_date'][$key]}}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <span
                                                                    class="text-danger">{{$errors->first('end_date')}}</span>
                                                            </div>
                                                        </td>
                                                        <td><a href="javascript:void(0)" class="delete_row"><i class="ti-trash"></i></a></td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                @foreach ($holidays as $key => $holiday)

                                                    <tr class="add_row">
                                                        <td>
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('hr.holiday_name')}}</label>
                                                                <input type="text" name="holiday_name[]"
                                                                       class="primary_input_field"
                                                                       placeholder="{{__('hr.holiday_name')}}"
                                                                       value="{{$holiday->name}}" required>
                                                                <span
                                                                    class="text-danger">{{$errors->first('holiday_name')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('common.select_type')}} <span class="text-danger">*</span></label>
                                                                <select class="primary_select mb-15 type" name="type[]">
                                                                    <option
                                                                        value="0" {{$holiday->type == 0 ? 'selected' : ''}}>{{__('common.single_day')}}</option>
                                                                    <option
                                                                        value="1" {{$holiday->type == 1 ? 'selected' : ''}}>{{__('common.multiple_day')}}</option>
                                                                </select>
                                                                <span
                                                                    class="text-danger">{{$errors->first('type')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="single_date @if ($holiday->type == 1) d-none @endif">
                                                                <div class="primary_input mb-15">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text" name="date[]"
                                                                                           value="{{date('m/d/Y',strtotime($holiday->date)) }}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="text-danger">{{$errors->first('date')}}</span>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $start_date = '';
                                                                $end_date = '';
                                                                $date = [];
                                                                if ($holiday->type == 1)
                                                                    {
                                                                        $date = explode(',',$holiday->date);
                                                                        $start_date = $date[0];
                                                                        $end_date = $date[1];
                                                                    }
                                                            @endphp
                                                            <div class="multiple_date @if ($holiday->type == 0) d-none @endif">
                                                                <div class="primary_input mb-15">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.start_date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text"
                                                                                           name="start_date[]"
                                                                                           value="{{!empty($date) ? date('m/d/Y',strtotime($date[0]))  : date('m/d/y')}}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="text-danger">{{$errors->first('start_date')}}</span>
                                                                </div>
                                                                <div class="primary_input mb-15">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('common.end_date') }}
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="primary_datepicker_input">
                                                                        <div class="no-gutters input-right-icon">
                                                                            <div class="col">
                                                                                <div class="">
                                                                                    <input placeholder="{{ __('common.date') }}"
                                                                                           class="primary_input_field primary-input date form-control"
                                                                                           type="text" name="end_date[]"
                                                                                           value="{{!empty($date) ? date('m/d/Y',strtotime($date[1])) : date('m/d/y')}}"
                                                                                           autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <button class="" type="button">
                                                                                <i class="ti-calendar"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <span
                                                                    class="text-danger">{{$errors->first('end_date')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="primary-btn primary-circle delete_row fix-gr-bg text-white"
                                                                   href="javascript:void(0)"> <i
                                                                        class="ti-trash"></i></a>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if (permissionCheck('holidays.store'))
                                <div class="row justify-content-center mt-2">
                                    <button type="submit"
                                            class="primary-btn btn-sm fix-gr-bg">{{__('common.submit')}}</button>
                                </div>
                            @endif
                        </form>
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

            $(document).ready(function(){
                $(".primary-input.datepicker").datepicker({
                    autoclose: true,
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                });
                $(document).on('change', '#year', function(){
                    changeYear();
                });

                $(document).on('click', '#add_row_btn', function(event){
                    event.preventDefault();
                    addRow();
                });

                $(document).on('change', '.type', function () {
                    let value = $(this).val();
                    var whichtr = $(this).closest("tr");
                    if (value == 0) {
                        whichtr.find($('.single_date')).removeClass('d-none');
                        whichtr.find($('.multiple_date')).addClass('d-none');
                    } else {
                        whichtr.find($('.single_date')).addClass('d-none');
                        whichtr.find($('.multiple_date')).removeClass('d-none');
                    }
                });

                $(document).on('click', '.delete_row', function () {
                    var whichtr = $(this).closest("tr");
                    whichtr.remove();
                });

                function changeYear() {
                    let year = $('#year').val();
                    $('#pre-loader').removeClass('d-none');
                    let baseUrl = $('#url').val();
                    let pre_year_route = baseUrl + "/attendance/last-year-data/" + year;
                    $('#copy_previous_year_btn').attr('href', pre_year_route);
                    $.ajax({
                        url: "{{route('add.row')}}",
                        method: "POST",
                        data: {
                            year: year,
                            _token: "{{csrf_token()}}",
                        },
                        success: function (result) {
                            $(".add_row").each(function (index, element) {
                                element.remove();
                            });
                            $(".holiday_table").append(result);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}');
                        }
                    });
                }

                function addRow() {
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: "{{route('add.row')}}",
                        method: 'POST',
                        data: {
                            _token: "{{csrf_token()}}",
                        },
                        success: function (data) {
                            $(".holiday_table").append(data);
                            $('select').niceSelect();
                            $(".date").datepicker();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}');
                        }
                    })
                }

            });
        })(jQuery);


    </script>
@endpush
