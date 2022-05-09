@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/attendance/css/style.css'))}}" />
@endsection
@section('mainContent')

    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($editData))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{url('/events')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@if(isset($editData))
                                        @lang('common.edit')
                                    @else
                                        @lang('common.add')
                                    @endif
                                    @lang('hr.event')
                                </h3>
                            </div>
                            @if(isset($editData))
                                @if (permissionCheck('events.update'))
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['events.update', $editData], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                                @endif
                            @else
                                @if (permissionCheck('events.store'))
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'events.store','method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        @if(session()->has('message-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('message-success') }}
                                            </div>
                                        @elseif(session()->has('message-danger'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('message-danger') }}
                                            </div>
                                        @endif
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.title') }}
                                                    <span class="text-danger">*</span></label>
                                                <input name="title" id="title"
                                                       class="primary_input_field"
                                                       value="{{isset($editData) ? $editData->title : old('title') }}"
                                                       placeholder="{{ __('common.title') }}" type="text">
                                                <span class="text-danger">{{$errors->first('title')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('hr.for_whom') }}
                                                    <span class="text-danger">*</span></label>
                                                <select class="primary_select mb-25" name="for_whom"
                                                        id="employment_type">
                                                    <option
                                                        value="all" {{isset($editData) && $editData->for_whom == 'all' ? 'selected' : ''}}>{{__('common.all')}}</option>
                                                    @foreach($roles as $role)
                                                        <option
                                                            value="{{$role->name}}" {{isset($editData) && $editData->for_whom == $role->name ? 'selected' : ''}}>{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first('for_whom')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.location') }}
                                                    <span class="text-danger">*</span></label>
                                                <input name="location" id="current_address"
                                                       class="primary_input_field name"
                                                       placeholder="{{ __('common.location') }}"
                                                       value="{{isset($editData) ? $editData->location : old('location') }}" type="text">
                                                <span class="text-danger">{{$errors->first('location')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 date_of_joining_div">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.start_date') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="07/14/2021"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="start_date" type="text"
                                                                       name="from_date"
                                                                       value="{{isset($editData)? date('m/d/Y', strtotime($editData->from_date)): date('m/d/Y')}}"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{$errors->first('from_date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 date_of_joining_div">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('common.to_date') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="07/14/2021"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       type="text" name="to_date"
                                                                       value="{{isset($editData)? date('m/d/Y', strtotime($editData->to_date)): date('m/d/Y')}}"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{$errors->first('to_date')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.description') }}</label>

                                                       <textarea name="description" id="description1" class="primary_textarea height_112" name="description" maxlength="300">{{isset($editData) ? $editData->description : old('description') }}</textarea>
                                                <span class="text-danger">{{$errors->first('description')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.image')}} (1920x500)PX</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text"
                                                           id="placeholderFileOneName"
                                                           placeholder="{{__('common.browse_file')}}" readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file_1">{{__("common.browse")}} </label>
                                                        <input type="file" class="d-none" name="image" accept="image/*"
                                                               id="document_file_1">
                                                    </button>
                                                </div>
                                                <span class="text-danger">{{$errors->first('image')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="img_div">
                                                <img id="img" src="
                                                    @if(isset($editData))
                                                        @if($editData->image != null)
                                                            {{showImage($editData->image)}}
                                                        @else
                                                            {{showImage('backend/img/default.png')}}
                                                        @endif
                                                    @else
                                                        {{showImage('backend/img/default.png')}}
                                                    @endif
                                                " alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip">
                                                <span class="ti-check"></span>
                                                @if(isset($editData))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.save')
                                                @endif
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                @if (permissionCheck('events.store') || permissionCheck('events.update'))
                                    {{ Form::close() }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        @if(session()->has('message-success-delete'))
                            <div class="alert alert-success">
                                {{ session()->get('message-success-delete') }}
                            </div>
                        @elseif(session()->has('message-danger-delete'))
                            <div class="alert alert-danger">
                                {{ session()->get('message-danger-delete') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">@lang('hr.event_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-40">

                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table class="table Crm_table_active3">

                                                <thead>
                                                <tr>
                                                    <th>@lang('common.title')</th>
                                                    <th>@lang('hr.for_whom')</th>
                                                    <th>@lang('common.start_date')</th>
                                                    <th>@lang('common.to_date')</th>
                                                    <th>@lang('common.location')</th>
                                                    <th>@lang('common.action')</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @if(isset($events))
                                                    @foreach($events as $event)
                                                        <tr>

                                                            <td>{{ @$event->title}}</td>
                                                            <td>{{ @$event->for_whom}}</td>

                                                            <td>{{ $event->from_date }}</td>


                                                            <td>{{$event->to_date}}</td>

                                                            <td>{{ @$event->location}}</td>

                                                            <td>
                                                                <div class="dropdown CRM_dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        {{__('common.select')}}
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                                        @if (permissionCheck('events.update'))
                                                                            <a class="dropdown-item" href="{{route('events.edit',$event->id)}}">@lang('common.edit')</a>
                                                                        @endif
                                                                        @if (permissionCheck('events.delete'))
                                                                            <a data-value="{{route('events.delete', $event->id)}}" class="dropdown-item delete_event">{{__('common.delete')}}</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '.delete_event', function(event){
                    let url = $(this).data('value');
                    confirm_modal(url);
                });
                $(document).on('change', '#document_file_1', function(event){
                    getFileName($(this).val(),'#placeholderFileOneName');
                    imageChangeWithFile($(this)[0],'#img');
                });
            });
        })(jQuery);
    </script>
@endpush
