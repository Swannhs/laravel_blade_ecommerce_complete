@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/modulemanager/css/style.css'))}}" />

@endsection
@section('mainContent')
    <link rel="stylesheet" href="{{(asset(asset_path('modules/modulemanager/sass/manage_module.css')))}}">
    <link rel="stylesheet" href="{{ asset(asset_path('vendor/spondonit/css/parsley.css')) }}">

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9 col-xs-6 col-md-6 col-sm-12 no-gutters ">
                            <div class="main-title sm_mb_20 sm2_mb_20 md_mb_20 mb-30 ">
                                <h3 class="mb-0"> {{__('general_settings.module')}} {{__('general_settings.manage')}}</h3>
                            </div>
                        </div>
                        @if(permissionCheck('modulemanager.uploadModule'))
                        <div class="col-lg-3 col-xs-6 col-md-6 col-sm-12 no-gutters list_div">
                            <a data-toggle="modal"
                               data-target="#add_module" href="#"
                               class="primary-btn fix-gr-bg small">  {{__('common.add')}} / {{__('common.update')}} {{__('general_settings.module')}}</a>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <table class="display school-table school-table-style" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{__('common.sl')}}</th>
                                    <th>{{__('general_settings.module')}}{{__('common.name')}}</th>
                                    <th>{{__('common.description')}}</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>

                                <tbody>
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                @php $count=1;
                                $manage =\Modules\ModuleManager\Entities\InfixModuleManager::all();
                                @endphp
                                @foreach($is_module_available as $row)

                                    @php
                                        $is_module_available = base_path().'/'.'Modules/' . $row->name. '/Providers/' .$row->name. 'ServiceProvider.php';
                                        $configFile = 'Modules/' . $row->name. '/' .$row->name. '.json';
                                         $is_data =  $manage->where('name', $row->name)->first();

                                    try {
                                        $config =file_get_contents(base_path().'/'.$configFile);

                                    }catch (\Exception $exception){
                                    $config =null;
                                    }


                                    @endphp
                                    <tr>
                                        <td>{{@$count++}}</td>
                                        <td>
                                            @if(@$row->name == 'Otp') {{strtoupper(@$row->name)}} @else {{@$row->name}} @endif
                                            @if(!empty($is_data->purchase_code)) <p class="text-success">
                                                {{__('general_settings.verified')}}
                                                on {{date("F jS, Y", strtotime(@$is_data->activated_date))}}</p>
                                            <a href="#" class="module_switch" data-id="{{@$row->name}}"
                                               id="module_switch_label{{@$row->name}}"
                                               data-item="{{$row}}">
                                                {{isModuleActive($row->name )  == false? 'Activate':'Deactivate'}}


                                            </a>
                                            <div id="waiting_loader"
                                                 class="waiting_loader{{@$row->name}}">
                                                <img
                                                    src="{{showImage('backend/img/loader.gif')}}"
                                                    width="40" height="40"/><br>

                                            </div>

                                            @else<p class="text-danger">
                                                @if (! file_exists($is_module_available))
                                                @else

                                                    <a class=" verifyBtn"
                                                       data-toggle="modal" data-id="{{@$row->name}}"
                                                       data-target="#Verify"
                                                       href="#">   {{__('general_settings.verify')}}</a>
                                                @endif
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            @if(isset($config))
                                                @php

                                                    $name=$row->name;
                                                    $config= json_decode($config);
                                                    if (isset($config->$name->notes[0])){
                                                    echo $config->$name->notes[0];
                                                    echo '<br>';
                                                    echo 'Version: '.$config->$name->versions[0].' | Developed By <a href="https://spondonit.com/">SpondonIT</a>';

                                                    }
                                                @endphp
                                            @else
                                                @php
                                                    if (isset($row->details)){
                                                        echo $row->details;
                                                    }
                                                @endphp
                                            @endif
                                        </td>

                                        <td class="text-right">
                                            @if (! file_exists($is_module_available))
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <a class="primary-btn fix-gr-bg text-nowrap"
                                                           href="mailto:support@spondonit.com">   {{__('general_settings.buy_now')}}</a>

                                                    </div>
                                                </div>
                                            @endif
                                            @if (file_exists($is_module_available))
                                                @php
                                                    $system_settings= \Modules\GeneralSetting\Entities\GeneralSetting::first();

                                                     $is_moduleV= $is_data;
                                                     $configName = $row->name;
                                                     $availableConfig=$system_settings->$configName;


                                                @endphp

                                                @if(@$availableConfig==0 || @@$is_moduleV->purchase_code== null)
                                                    <input type="hidden" name="name" value="{{@$configName}}">


                                                @else
                                                    <div class="row">
                                                        <div class="col-lg-12 ">
                                                            @if('RolePermission' != $row->name && 'TemplateSettings' != $row->name )
                                                                <div id="waiting_loader"
                                                                     class="waiting_loader{{@$row->name}}">


                                                                </div>
                                                                    @endif

                                                        </div>
                                                @endif
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
    </section>

    <div class="modal fade admin-query" id="add_module">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('general_settings.add_new_update_module')}}</h4>
                    <button type="button" class="close " data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="add_form" action="{{route('modulemanager.uploadModule')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="primary_input mb-35">

                                    <div class="primary_file_uploader">
                                        <input class="primary-input filePlaceholder" type="text"
                                               id="document_file_place"
                                               placeholder="{{__('general_settings.select_module_file')}}"
                                               readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg"
                                                   for="document_file">{{__('common.browse')}}</label>
                                            <input type="file" class="d-none fileUpload" name="module" accept="application/zip" id="document_file">
                                        </button>
                                    </div>
                                    @error('module')
                                        <span class="text-danger" id="module_error">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                        type="submit"><i
                                        class="ti-check"></i> {{__('common.save')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade admin-query" id="Verify">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Module Verification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>

                <div class="modal-body">
                    {{ Form::open(['id'=>"content_form",'class' => 'form-horizontal', 'files' => true, 'route' => 'ManageAddOnsValidation', 'method' => 'POST']) }}
                    <input type="hidden" name="name" value="" id="moduleName">

                    @csrf
                    <div class="form-group">
                        <label for="user">Envato Email Address :</label>
                        <input type="text" class="form-control " name="envatouser"
                               required="required"
                               placeholder="Enter Your Envato Email Address"
                               value="{{old('envatouser')}}">
                    </div>
                    <div class="form-group">
                        <label for="purchasecode">Envato Purchase Code:</label>
                        <input type="text" class="form-control" name="purchase_code"
                               required="required"
                               placeholder="Enter Your Envato Purchase Code"
                               value="{{old('purchasecode')}}">
                    </div>
                    <div class="form-group">
                        <label for="domain">Installation Path:</label>
                        <input type="text" class="form-control"
                               name="installationdomain" required="required"
                               placeholder="Enter Your Installation Domain"
                               value="{{url('/')}}" readonly>
                    </div>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg submit">
                                <span class="ti-check"></span>
                                {{__('general_settings.verify')}}
                            </button>
                            <button type="button" class="primary-btn fix-gr-bg submitting" style="display: none">
                                <i class="fas fa-spinner fa-pulse"></i>
                                Verifying
                            </button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset(asset_path('backend/js/module.js'))}}"></script>
    <script type="text/javascript" src="{{ asset(asset_path('vendor/spondonit/js/parsley.min.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(asset_path('vendor/spondonit/js/function.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(asset_path('vendor/spondonit/js/common.js')) }}"></script>
    <script type="text/javascript">
        _formValidation('content_form');
    </script>

    <script>
        (function($){
            "use strict";

            $(document).ready(function(){
                $(document).on('submit', '#add_form', function(event){
                    let fileCheck = $('#document_file').val();
                    $('#module_error').text("");
                    if(fileCheck == ''){
                        $('#module_error').text("{{__('validation.this_field_is_required')}}");
                        event.preventDefault();
                    }
                });

                $(document).on('change', '#document_file', function(event){
                    getFileName($(this).val(),'#document_file_place');
                });
            });
        })(jQuery);
    </script>
@endpush
