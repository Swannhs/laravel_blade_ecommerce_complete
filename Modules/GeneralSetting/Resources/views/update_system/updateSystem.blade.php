
@extends('backEnd.master')
@section('mainContent')


    <section class="admin-visitor-area up_admin_visitor empty_table_tab">
        <div class="container-fluid p-0">


            <div class="row">
                <div class="col-lg-4 mb-20">
                    <div class="row">
                        <div class="col-lg-12">

                            @if (permissionCheck('generalsetting.updatesystem.submit'))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'generalsetting.updatesystem.submit', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @endif

                            <div class="white-box sm_mb_20 sm2_mb_20 md_mb_20 ">
                                <div class="main-title">
                                    <h3 class="mb-30">{{__('general_settings.upload_from_local_directory')}}</h3>
                                </div>
                                <div class="add-visitor">

                                    <div class="row no-gutters input-right-icon mb-20">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input
                                                    class="primary-input form-control {{ $errors->has('content_file') ? ' is-invalid' : '' }}"
                                                    readonly="true" type="text"
                                                    placeholder="{{isset($editData->file) && @$editData->file != ""? getFilePath3(@$editData->file):trans('common.browse')}} "
                                                    id="placeholderUploadContent" name="content_file">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('content_file'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('content_file') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">

                                            <div class="primary_input mb-15">

                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text"
                                                        id="upload_content_file_place"
                                                        placeholder="{{ __('common.browse_file') }}"
                                                        readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="upload_content_file">{{ __('product.Browse') }}
                                                        </label>
                                                        <input type="file" class="d-none" name="updateFile"
                                                            id="upload_content_file">
                                                    </button>
                                                </div>
                                                @error('updateFile')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                    @php
                                        $tooltip = "";

                                    if (permissionCheck('setting.updateSystem.submit')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                    @endphp

                                @if(permissionCheck('generalsetting.updatesystem.submit'))
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                    title="{{@$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($session))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.save')
                                                @endif

                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-danger"> {{__('common.no_action_permitted')}}</span>
                                @endif
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-30">{{__('general_settings.about_system')}}</h3>
                                </div>
                                <div class="add-visitor">
                                    <table class="display school-table school-table-style update_system_table">

                                        <tr>
                                            <td>{{__('general_settings.software_version')}}</td>
                                            <td>{{app('general_setting')->system_version}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('general_settings.check_update')}}</td>
                                            <td><a href="https://codecanyon.net/user/codethemes/portfolio"
                                                   target="_blank"> <i
                                                        class="ti-new-window"> </i> {{__('common.update')}} </a></td>
                                        </tr>
                                        <tr>
                                            <td> {{__('general_settings.php_version')}}</td>
                                            <td>{{phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('general_settings.curl_enable')}}</td>
                                            <td>@php
                                                    if  (in_array  ('curl', get_loaded_extensions())) {
                                                        echo 'enable';
                                                    }
                                                    else {
                                                        echo 'disable';
                                                    }
                                                @endphp</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('general_settings.purchase_code')}}</td>
                                            <td>
                                                {{__('Verified')}}
                                                @if(\Illuminate\Support\Facades\Auth::user()->role->type == 'superadmin')
                                                    @if(!env('APP_SYNC'))
                                                        @includeIf('service::license.revoke')
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>{{__('general_settings.install_domain')}}</td>
                                            <td>{{env('APP_URL')}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('general_settings.system_activated_date')}}</td>
                                            <td>{{app('general_setting')->system_activated_date}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('general_settings.last_update_at')}}</td>
                                            <td>
                                                @if($last_update)
                                                    {{$last_update->created_at}}

                                                @else

                                                @endif
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
    <script>
        (function($){
            'use strict';
            $(document).ready(function(){
                $(document).on('change', '#upload_content_file', function(event){
                    getFileName($(this).val(),'#upload_content_file_place');
                });
            });
        })(jQuery);
    </script>
@endpush




