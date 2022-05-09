@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('hr.select_criteria') }}</h3>
                            <div class="mr-3">{{__('hr.present')}}: <span class="text-success">{{ __('hr.P') }}</span></div>
                            <div class="mr-3">{{__('hr.late')}}: <span class="text-warning">{{ __('hr.L') }}</span></div>
                            <div class="mr-3">{{__('hr.absent')}}: <span class="text-danger">{{ __('hr.A') }}</span></div>
                            <div class="mr-3">{{__('hr.holiday')}}: <span class="text-dark">{{ __('hr.H') }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white">
                        <form class="" action="{{ route('attendance_report.search') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('common.select_role') }}</label>
                                        <select class="primary_select mb-15" name="role_id" id="role_id">
                                            <option selected disabled>{{__('common.choose_one')}}</option>
                                            @isset($r)
                                            <option value="0" @if ($r == 0) selected @endif>{{__('common.all')}}</option>
                                            @else
                                            <option value="0">{{__('common.all')}}</option>
                                            @endisset
                                            @foreach ($roles as $key => $role)
                                                @isset($r)
                                                    <option value="{{ $role->id }}"@if ($r == $role->id) selected @endif>{{ $role->name }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endisset
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('role_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('hr.select_month') }}</label>
                                        <select class="primary_select mb-15" name="month" id="month">
                                            @foreach ($months as $month)
                                                @isset($m)
                                                    <option value="{{ $month }}"@if ($m == $month) selected @endif>{{ $month }}</option>
                                                @else
                                                    <option value="{{ $month }}" {{$month == \Carbon\Carbon::now()->monthName ? 'selected' : ''}}>{{ $month }}</option>
                                                @endisset
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('month')}}</span>
                                    </div>
                                </div>
                                

                                <div class="col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="year">{{ __('common.year') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="{{ __('common.year') }}"
                                                               class="primary_input_field primary-input datepicker form-control"
                                                               type="text" id="year"
                                                               name="year" value="@if(isset($y)) {{$y}} @else {{ date('Y') }} @endif"
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
                                    <button type="submit" class="primary-btn btn-sm fix-gr-bg pull-right" id="save_button_parent"><i class="ti-search"></i>{{ __('common.search') }}</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                @php
                    $max_col = 0;
                @endphp
                @isset($report_dates)
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('attendance_report_print', [$r, $m, $y]) }}">
                                    <i class="ti-printer"></i>{{ __('hr.attendance_report') }} {{ __('common.print') }}</a></li>
                                </ul>
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
                                                <th scope="col">{{ __('common.id') }}</th>
                                                <th scope="col">{{ __('hr.staff') }}</th>
                                                <th scope="col">{{ __('hr.staff_id') }}</th>
                                                <th scope="col">{{ __('hr.P') }}</th>
                                                <th scope="col">{{ __('hr.L') }}</th>
                                                <th scope="col">{{ __('hr.A') }}</th>
                                                <th scope="col">{{ __('hr.H') }}</th>
                                                <th scope="col">{{ __('hr.present') }}</th>
                                                @foreach ($report_dates as $key => $report_date)
                                                <th scope="col">{{ $report_date->date }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                @php
                                                    $total_attendance = 0;
                                                    $total_days_of_month = count($report_dates);
                                                    $absent = count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'A'));
                                                    $late = count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'L'));
                                                    $half_day = count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'F'));
                                                    $present = count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'P'));
                                                    $Totalpresent = ($late + $half_day + $present);
                                                    if ($total_days_of_month > 0) {
                                                        $total_attendance = ($Totalpresent * 100) / $total_days_of_month;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $user->getFullNameAttribute() }}</td>
                                                    <td>
                                                        @if ($user->staff)
                                                            {{ $user->staff->employee_id }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $present }}</td>
                                                    <td>{{ $late }}</td>
                                                    <td>{{ $absent }}</td>
                                                    <td>{{ $half_day }}</td>
                                                    <td>
                                                        @if($user->attendances)
                                                            {{ number_format($total_attendance, 2) }} %
                                                        @else
                                                            00
                                                        @endif
                                                    </td>
                                                    @php
                                                    $attendances = $user->attendances->where('month', $m)->where('year', $y);
                                                    $max_col_1 = count($attendances);
                                                    if ($max_col < $max_col_1) {
                                                        $max_col = $max_col_1;
                                                    }else {
                                                        $max_diff = $max_col - $max_col_1;
                                                    }
                                                    @endphp

                                                    @if (sizeof($attendances) > 0 && sizeof($attendances) == $max_col)
                                                        @foreach ($user->attendances->where('month', $m)->where('year', $y) as $attendance)
                                                            <td>{{ $attendance->attendance }}</td>
                                                        @endforeach
                                                    @elseif (sizeof($attendances) > 0 && sizeof($attendances) < $max_col)
                                                        @foreach ($user->attendances->where('month', $m)->where('year', $y) as $attendance)
                                                            <td>{{ $attendance->attendance }}</td>
                                                        @endforeach
                                                        @for ($i=$max_col_1; $i < $max_col; $i++)
                                                            <td></td>
                                                        @endfor
                                                    @else
                                                        @for ($i=0; $i < $max_diff; $i++)
                                                            <td></td>
                                                        @endfor
                                                    @endif
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
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
            });
        })(jQuery);
    </script>
@endpush
