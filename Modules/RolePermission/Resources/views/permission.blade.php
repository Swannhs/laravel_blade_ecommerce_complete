@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('backend/css/role_module_style.css'))}}">

<link rel="stylesheet" href="{{asset(asset_path('modules/rolepermission/css/style.css'))}}" />
    
@endsection
@section('mainContent')


    <div class="role_permission_wrap">
            <div class="permission_title">
                <h4>@lang('hr.assign_permission') ({{@$role->name}})</h4>
            </div>
    </div>
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'permission.permissions.store','method' => 'POST']) }}
    <div class="erp_role_permission_area ">
    <!-- single_permission  -->
    <input type="hidden" name="role_id" value="{{@$role->id}}">
    <div  class="mesonary_role_header">
        @foreach ($MainMenuList as $key => $Module)
            @if(!$Module->module or isModuleActive($Module->module))
                @if(!isModuleActive('Affiliate') && $Module->module == 'PageBuilder')
                @else
                    @include('rolepermission::page-components.permissionModule',[ 'key' =>$key, 'Module' =>$Module ])
                @endif
            @endif
        @endforeach
    </div>


        <div class="row mt-40">
            <div class="col-lg-12 text-center">
                <button class="primary-btn fix-gr-bg">
                    <span class="ti-check"></span>
                    @lang('common.submit')
                </button>
            </div>
        </div>

    </div>
{{ Form::close() }}
@endsection



@push('scripts')
<script type="text/javascript">
(function($) {
	"use strict";

    $('.permission-checkAll').on('click', function () {
       if($(this).is(":checked")){
            $( '.module_id_'+$(this).val() ).each(function() {
              $(this).prop('checked', true);
            });
       }else{
            $( '.module_id_'+$(this).val() ).each(function() {
              $(this).prop('checked', false);
            });
       }
    });

    $('.module_link').on('click', function () {
       var module_id = $(this).parents('.single_permission').attr("id");
       var module_link_id = $(this).val();
       if($(this).is(":checked")){
            $(".module_option_"+module_id+'_'+module_link_id).prop('checked', true);
        }else{
            $(".module_option_"+module_id+'_'+module_link_id).prop('checked', false);
        }
       var checked = 0;
       $( '.module_id_'+module_id ).each(function() {
          if($(this).is(":checked")){
            checked++;
          }
        });

        if(checked > 0){
            $(".main_module_id_"+module_id).prop('checked', true);
        }else{
            $(".main_module_id_"+module_id).prop('checked', false);
        }
     });

    $('.module_link_option').on('click', function () {
       var module_id = $(this).parents('.single_permission').attr("id");
       var module_link = $(this).parents('.module_link_option_div').attr("id");
       // module link check
        var link_checked = 0;
       $( '.module_option_'+module_id+'_'+ module_link).each(function() {
          if($(this).is(":checked")){
            link_checked++;
          }
        });

        if(link_checked > 0){
            $("#Sub_Module_"+module_link).prop('checked', true);
        }else{
            $("#Sub_Module_"+module_link).prop('checked', false);
        }

       // module check
       var checked = 0;

       $( '.module_id_'+module_id ).each(function() {
          if($(this).is(":checked")){
            checked++;
          }
        });

        if(checked > 0){
            $(".main_module_id_"+module_id).prop('checked', true);
        }else{
            $(".main_module_id_"+module_id).prop('checked', false);
        }
     });

 })(jQuery);
</script>

@endpush
