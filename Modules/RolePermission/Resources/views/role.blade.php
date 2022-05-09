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
                                @if(isset($role))
                                    @lang('common.edit')
                                @else
                                    @lang('common.add')
                                @endif
                                    @lang('hr.role')
                            </h3>
                        </div>
                        @if(isset($role))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('permission.roles.update',$role->id),'method' => 'PUT']) }}
                        @else
                            
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'permission.roles.store', 'method' => 'POST']) }}
                            
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row  mt-25">
                                    <div class="col-lg-12">
                                        @if(session()->has('message-success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success') }}
                                        </div>
                                        @elseif(session()->has('message-danger'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger') }}
                                        </div>
                                        @endif
                                        <div class="input-effect">
                                            <label>@lang('common.name') <span><span class="text-danger">*</span></span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                                type="text" name="name" autocomplete="off" value="{{isset($role)? @$role->name: ''}}">
                                            <input type="hidden" name="id" value="{{isset($role)? @$role->id: ''}}">
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        @if(permissionCheck('permission.roles.edit') || permissionCheck('permission.roles.store'))
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            {{!isset($role)? __('common.save') : __('common.update')}}

                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('hr.role') @lang('common.list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="mt-30">
                                <table class="table Crm_table_active3">
                                        <thead>
                                           @include('backEnd.partials._alertMessagePageLevelAll')
                                            <tr>
                                                <th width="20%">@lang('common.sl')</th>
                                                <th width="20%">@lang('hr.role')</th>
                                                <th width="40%">@lang('common.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($RoleList as $key => $role)
                                                @if(!$role->module or isModuleActive($role->module))
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{@$role->name}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('permission.permissions.index', [ 'id' => @$role->id])}}" class=""   >
                                                                <button type="button" class="primary-btn small fix-gr-bg"> @lang('hr.assign_permission') </button>
                                                            </a> --}}
                                                            <div class="dropdown CRM_dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{__('common.select')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                                    <a class="dropdown-item" type="button" href="{{ route('permission.permissions.index', [ 'id' => @$role->id])}}">{{__('hr.assign_permission')}}</a>
                                                                    
                                                                        
                                                                    @if(permissionCheck('permission.roles.edit'))
                                                                        <a href="{{ route('permission.roles.edit',$role->id) }}" class="dropdown-item" type="button">@lang('common.edit')</a>
                                                                    @endif

                                                                    @if(permissionCheck('permission.roles.destroy'))
                                                                        <a href=""  class="dropdown-item delete_role"  type="button" data-value="{{route('permission.roles.destroy',$role->id)}}" >@lang('common.delete')</a>
                                                                    @endif
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
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
    {{-- Error modal message --}}
    @include('backEnd.partials.delete_modal',['item_name' => __('hr.role')])
</section>
@endsection

@push('scripts')
    <script>
        (function($){
            "use script";
            $(document).ready(function(){
                $(document).on('click', '.delete_role', function(event){
                    event.preventDefault();
                    let route = $(this).data('value');
                    confirm_modal(route);
                });
            });

        })(jQuery);
    </script>
    
@endpush
