@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('formBuilder.forms')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="" id="lms_data_table">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                        <tr>
                                            <th>{{__('common.sl')}}</th>
                                            <th>{{__('formBuilder.form')}}</th>
                                            <th>{{__('common.view')}}</th>
                                            <th>{{__('common.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($forms as $row)
                                            @if(!isModuleActive('Affiliate') && $row->id == 1)
                                                @continue
                                            @endif
                                            @if(!isModuleActive('MultiVendor') && $row->id == 3)
                                                @continue
                                            @endif
                                            @if($row->id == 5)
                                                @continue
                                            @endif
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$row->name}}</td>
                                                <td> <a target="_blank" href="{{route('form_builder.forms.show',$row->id)}}" class="primary-btn fix-gr-bg btn text-white">{{ __('common.view') }}</a></td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                            @if(permissionCheck('form_builder.builder'))
                                                                <a href="{{route('form_builder.builder',$row->id)}}" class="dropdown-item">{{ __('formBuilder.form_builder') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
@endsection

