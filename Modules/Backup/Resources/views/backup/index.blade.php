@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    {{__('general_settings.upload_sql_file')}}
                                </h3>
                            </div>
                            <div class="mt-40 pt-30">
                                <form method="POST" action="{{ route('backup.import') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="row  mt-25">
                                                <div class="col-lg-12">

                                                    <div class="primary_input mb-15">
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text"
                                                                   id="placeholderFileOneName" placeholder="{{__('common.browse_file')}}"
                                                                   readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                       for="document_file_1">{{__("common.browse")}} </label>
                                                                <input type="file" class="d-none" name="db_file"
                                                                       id="document_file_1">

                                                            </button>
                                                            @error('db_file')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(permissionCheck('backup.import'))
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                            title="">
                                                        <span class="ti-check"></span>
                                                        {{ __('common.update') }}
                                                    </button>
                                                </div>
                                            </div>
                                            @else
                                             <span class="text-danger"> {{__('common.no_action_permitted')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 ">
                    <div class="row">
                        <div class="col-lg-12 no-gutters">

                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">@lang('general_settings.database_backup_list')</h3>

                                <ul class="pull-right">
                                    @if(permissionCheck('backup.create'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="{{route('backup.create')}}"><i
                                                class="ti-plus"></i>{{__('general_settings.generate_new_backup')}}</a></li>
                                    @endif
                                </ul>


                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mt-10">
                        <div class="col-lg-12 mt-10">

                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="mt-30">
                                        <table class="table Crm_table_active3">
                                            <thead>

                                            <tr>
                                                <th width="30%">@lang('common.sl')</th>
                                                <th width="30%">@lang('common.date')</th>
                                                <th width="40%">@lang('common.file_name')</th>
                                                <th width="40%">@lang('common.download')</th>
                                                <th width="40%">@lang('common.action')</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($allBackup as $key => $value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td class="">{{substr($value, 0, 10)}}</td>
                                                    <td>{{str_replace(' ', '-',app('general_setting')->site_title)."_db_$value".'.sql'}}</td>
                                                    <td class="text-center">
                                                       @if(!config('app.sync'))
                                                         <a href="{{ asset('public/database-backup/'.$value.'/'.$value.'-dump.sql') }}"
                                                            download="{{ str_replace(' ', '-',app('general_setting')->site_title)."_db_$value".'.sql' }}"><i
                                                                class="fa fa-download"></i></a>
                                                       @else

                                                        <span class="cs-pointer" data-toggle="tooltip" title="Restricted in demo mode"><i
                                                                class="fa fa-download"></i>

                                                        </span></a>

                                                       @endif

                                                            </td>

                                                    <td>

                                                        @if(permissionCheck('backup.delete'))
                                                           <span>
                                                                <a data-value="{{ route('backup.delete', $value) }}" href=""
                                                                   class="primary-btn radius_30px mr-10 fix-gr-bg delete_data"
                                                                    >@lang('common.delete')</a>
                                                           </span>
                                                        @endif

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
                $(document).on('change', '#document_file_1', function(){
                    getFileName($(this).val(),'#placeholderFileOneName');
                });

                $(document).on('click', '.delete_data', function(event){
                    event.preventDefault();
                    let value = $(this).data('value');
                    confirm_modal(value);
                });
            });
        })(jQuery);
    </script>
@endpush
