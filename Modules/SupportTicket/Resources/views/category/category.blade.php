@extends('backEnd.master')
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
       @if(isset($editData))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('ticket.categories.index')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add_new')
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
                                    @lang('ticket.edit')
                                @else
                                    @lang('ticket.add')
                                @endif
                                @lang('ticket.ticket_category')
                            </h3>
                        </div>
                        @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('ticket.categories.update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['ticket.categories.store'],
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    @if(session()->has('message-success'))
                                    <div class="alert alert-success mb-20">
                                        {{ session()->get('message-success') }}
                                    </div>
                                    @elseif(session()->has('message-danger'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('message-danger') }}
                                    </div>
                                    @endif

                                    <div class="col-lg-12 mb-20">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            type="text" name="name" autocomplete="off" value="{{isset($editData)? $editData->name : '' }}">
                                            <label>@lang('ticket.category') @lang('ticket.name') <span>*</span> </label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                                </div>
                               @php

                                        if(permissionCheck('ticket.categories.store')){
                                            $tooltipAdd = "";
                                            $disable = "";
                                        }else{
                                            $tooltipAdd = "You have no permission to add";
                                            $disable = "disabled";
                                        }

                                        if(permissionCheck('ticket.categories.edit')){
                                            $tooltipUpdate = "";
                                            $disable = "";
                                        }else{
                                            $tooltipUpdate = "You have no permission to update";
                                            $disable = "disabled";
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        @if(isset($editData))
                                            <div class="col-lg-12 text-center tooltip-wrapper" data-title="{{ $tooltipUpdate}}">
                                            <button class="primary-btn fix-gr-bg tooltip-wrapper {{$disable }}" {{ @$disable }}>
                                                <span class="ti-check"></span>
                                                    @lang('ticket.update')
                                            </button>
                                        </div>

                                        @else

                                            <div class="col-lg-12 text-center tooltip-wrapper" data-title="{{ $tooltipAdd}}">
                                            <button class="primary-btn fix-gr-bg tooltip-wrapper {{$disable }}" {{ @$disable }}>
                                                <span class="ti-check"></span>
                                                    @lang('ticket.add')
                                            </button>
                                             </div>

                                        @endif

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
                    <h3 class="mb-0"> @lang('ticket.ticket_category')</h3>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="model_list">
                                    <table class="table Crm_table_active3">

                        <thead>
                            @if(session()->has('message-success-delete') != "" ||
                                    session()->get('message-danger-delete') != "")
                                    <tr>
                                        <td colspan="2">
                                             @if(session()->has('message-success-delete'))
                                              <div class="alert alert-success">
                                                  {{ session()->get('message-success-delete') }}
                                              </div>
                                            @elseif(session()->has('message-danger-delete'))
                                              <div class="alert alert-danger">
                                                  {{ session()->get('message-danger-delete') }}
                                              </div>
                                            @endif
                                        </td>
                                    </tr>
                                     @endif
                            <tr>
                                <th scope="col">
                                    <label class="primary_checkbox d-flex ">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th> @lang('ticket.category')  @lang('ticket.title')</th>
                                <th> @lang('ticket.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($itemCategories))
                            @foreach($itemCategories as $value)
                            <tr>
                                <th scope="col">
                                    <label class="primary_checkbox d-flex ">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <td>{{$value->name}}</td>
                                <td>
                                    <div class="dropdown CRM_dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('ticket.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a class="dropdown-item" href="{{ route('ticket.categories.edit',$value->id)}}"> @lang('ticket.edit')</a>

                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteItem_{{@$value->id}}">@lang('ticket.delete')</a>

                                        </div>
                                    </div>
                                </td>

                                <div class="modal fade admin-query" id="deleteItem_{{@$value->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('ticket.delete') @lang('ticket.support') @lang('ticket.category')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('ticket.are_you_sure_to_delete')</h4>
                                                </div>
                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('ticket.cancel')</button>
                                                    <form action="{{ route('ticket.categories.destroy',$value->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="primary-btn fix-gr-bg" value="Delete"/>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
</div>
</section>
@endsection
