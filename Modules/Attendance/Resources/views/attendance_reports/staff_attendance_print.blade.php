<!DOCTYPE html>
<html lang="en">
   <head>
      <title>@lang('lang.staff') @lang('lang.attendance')  </title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="{{asset(asset_path('modules/appearance/css/staff_attendance.css'))}}" />
   </head>
   <style>

      table,th,tr,td{
      font-size: 11px !important;
      padding: 0px !important;
      text-align: center !important;
      }
      #attendance.th,#attendance.tr,#attendance.td{
      font-size: 10px !important;
      padding: 0px !important;
      text-align: center !important;
      border:1px solid #ddd;
      vertical-align: middle !important;
      }
      #attendance th{
      background: #ddd;
      text-align: center;
      }
      #attendance{
      border: 1px solid black;
      border-collapse: collapse;
      }
      #attendance tr{
      border: 1px solid black;
      border-collapse: collapse;
      }
      #attendance th{
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center !important;
      font-size: 11px;
      }
      #attendance td{
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center;
      font-size: 10px;
      }
   </style>
   <body>
      @php
      $generalSetting= \Modules\GeneralSetting\Entities\GeneralSetting::first();
      if(!empty($generalSetting)){
      $site_title =$generalSetting->site_title;
      $address =$generalSetting->address;
      }
      @endphp
      <div class="container-fluid">
         <table  cellspacing="0" width="100%">
            <tr>
               <td>
                  <img class="logo-img" src="{{ url('/')}}/{{$generalSetting->logo }}" alt="">
               </td>
               <td>
                  <h3 style="font-size:22px !important" class="text-white"> {{isset($site_title)?$site_title:'Infix Trading ERP'}} </h3>
                  <p style="font-size:18px !important" class="text-white mb-0"> {{isset($address)?$address:'Infix School Address'}} </p>
               </td>
               <td style="text-aligh:center">
                  <p style="font-size:14px !important; border-bottom:1px solid gray" align="left" class="text-white">@lang('hr.role'): {{ isset($role)?$role->name:__('common.all')}} </p>
                  <p style="font-size:14px !important; border-bottom:1px solid gray" align="left" class="text-white">@lang('common.month'): {{ $m }} </p>
                  <p style="font-size:14px !important; border-bottom:1px solid gray" align="left" class="text-white">@lang('common.year'): {{ $y }} </p>
               </td>
            </tr>
         </table>
         <h3 style="text-align:center">@lang('hr.staff') @lang('hr.attendance_report')</h3>
         <table id="attendance" style="width: 100%; table-layout: fixed">
            <tr>
               <th width="7%">{{ __('hr.staff') }}</th>
               <th width="7%">{{ __('hr.staff_id') }}</th>
               <th>{{ __('hr.P') }}</th>
               <th>{{ __('hr.L') }}</th>
               <th>{{ __('hr.A') }}</th>
               <th>{{ __('hr.H') }}</th>
               <th width="7%">{{ __('hr.present') }}</th>
               @foreach ($report_dates as $report_date)
                   <th>
                      {{ $report_date->date }}
                   </th>
               @endforeach
            </tr>
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
                   <td>{{ $user->first_name }}</td>
                   <td>
                      @if ($user->staff)
                      {{ $user->staff->employee_id }}
                      @endif
                   </td>
                   <td>{{ count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'P')) }}</td>
                   <td>{{ count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'L')) }}</td>
                   <td>{{ count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'A')) }}</td>
                   <td>{{ count($user->attendances->where('month', $m)->where('year', $y)->where('attendance', 'H')) }}</td>
                   <td>{{ number_format($total_attendance, 2) }} %</td>
                   @foreach($user->attendances->where('month', $m)->where('year', $y) as $attendance)
                   <td>{{ $attendance->attendance }}</td>
                   @endforeach
                </tr>
            @endforeach
         </table>
      </div>
   </body>
</html>
