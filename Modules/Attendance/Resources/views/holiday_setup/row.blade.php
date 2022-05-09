@if($year)
    @foreach ($holidays as $key => $holiday)

        <tr class="add_row">
            <td>
                <div class="primary_input mb-15">
                    <label class="primary_input_label"
                           for="">{{__('holiday.Holiday Name')}}</label>
                    <input type="text" name="holiday_name[]" class="primary_input_field"
                           placeholder="{{__('hr.holiday_name')}}" value="{{$holiday->name}}">
                    <span class="text-danger">{{$errors->first('holiday_name')}}</span>
                </div>
            </td>
            <td>
                <div class="primary_input mb-15">
                    <label class="primary_input_label"
                           for="">{{__('common.select_type')}} *</label>
                    <select class="primary_select mb-15 type" name="type[]">
                        <option
                            value="0" {{$holiday->type == 0 ? 'selected' : ''}}>{{__('common.single_day')}}</option>
                        <option
                            value="1" {{$holiday->type == 1 ? 'selected' : ''}}>{{__('common.multiple_day')}}</option>
                    </select>
                    <span class="text-danger">{{$errors->first('type')}}</span>
                </div>
            </td>
            <td>
                <div class="single_date @if ($holiday->type == 1) d-none @endif">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for="">{{ __('common.date') }}
                            *</label>
                        <div class="primary_datepicker_input">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="">
                                        <input placeholder="{{ __('common.date') }}"
                                               class="primary_input_field primary-input date form-control"
                                               type="text" name="date[]"
                                               value="{{date('m/d/Y',strtotime($holiday->date))}}" autocomplete="off">
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
                @php
                    $start_date = '';
                    $end_date = '';
                    $date = [];
                    if ($holiday->type == 1)
                        {
                            $date = explode(',',$holiday->date);
                            $start_date = date('m/d/Y',strtotime($date[0]));
                            $end_date =  date('m/d/Y',strtotime($date[1]));
                        }
                @endphp
                <div class="multiple_date @if ($holiday->type == 0) d-none @endif">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for="">{{ __('common.start_date') }}
                            *</label>
                        <div class="primary_datepicker_input">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="">
                                        <input placeholder="{{ __('common.date') }}"
                                               class="primary_input_field primary-input date form-control"
                                               type="text" name="start_date[]"
                                               value="{{!empty($date) ? $start_date : date('m/d/y')}}"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <button class="" type="button">
                                    <i class="ti-calendar"></i>
                                </button>
                            </div>
                        </div>
                        <span class="text-danger">{{$errors->first('start_date')}}</span>
                    </div>
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for="">{{ __('common.end_date') }}
                            *</label>
                        <div class="primary_datepicker_input">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="">
                                        <input placeholder="{{ __('common.date') }}"
                                               class="primary_input_field primary-input date form-control"
                                               type="text" name="end_date[]"
                                               value="{{!empty($date) ? $end_date : date('m/d/y')}}"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <button class="" type="button">
                                    <i class="ti-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger">{{$errors->first('end_date')}}</span>
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
@if (!$year)
    <tr class="add_row">
        <td>
            <div class="primary_input mb-15">
                <label class="primary_input_label"
                       for="">{{__('hr.holiday_name')}}</label>
                <input type="text" name="holiday_name[]" class="primary_input_field"
                       placeholder="{{__('hr.holiday_name')}}">
                <span class="text-danger">{{$errors->first('holiday_name')}}</span>
            </div>
        </td>
        <td>
            <div class="primary_input mb-15">
                <label class="primary_input_label"
                       for="">{{__('common.select_type')}} *</label>
                <select class="primary_select mb-15 type" name="type[]">
                    <option value="0">{{__('common.single_day')}}</option>
                    <option value="1">{{__('common.multiple_day')}}</option>
                </select>
                <span class="text-danger">{{$errors->first('type')}}</span>
            </div>
        </td>
        <td>
            <div class="single_date">
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for="">{{ __('common.date') }}
                        *</label>
                    <div class="primary_datepicker_input">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="">
                                    <input placeholder="07/14/2021"
                                           class="primary_input_field primary-input date form-control"
                                           type="text" name="date[]"
                                           value="{{date('m/d/Y')}}" autocomplete="off">
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
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for="">{{ __('common.start_date') }}
                        *</label>
                    <div class="primary_datepicker_input">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="">
                                    <input placeholder="07/14/2021"
                                           class="primary_input_field primary-input date form-control"
                                           type="text" name="start_date[]"
                                           value="{{date('m/d/Y')}}"
                                           autocomplete="off">
                                </div>
                            </div>
                            <button class="" type="button">
                                <i class="ti-calendar"></i>
                            </button>
                        </div>
                    </div>
                    <span class="text-danger">{{$errors->first('start_date')}}</span>
                </div>
                <div class="primary_input mb-15">
                    <label class="primary_input_label" for="">{{ __('common.end_date') }}
                        *</label>
                    <div class="primary_datepicker_input">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="">
                                    <input placeholder="07/14/2021"
                                           class="primary_input_field primary-input date form-control"
                                           type="text" name="end_date[]"
                                           value="{{date('m/d/Y')}}"
                                           autocomplete="off">
                                </div>
                            </div>
                            <button class="" type="button">
                                <i class="ti-calendar"></i>
                            </button>
                        </div>
                    </div>
                    <span class="text-danger">{{$errors->first('end_date')}}</span>
                </div>
            </div>
        </td>
        <td>
            <a class="primary-btn primary-circle delete_row fix-gr-bg text-white"
               href="javascript:void(0)"> <i
                    class="ti-trash"></i></a>
        </td>
    </tr>
@endif
