@extends('backEnd.master')
@section('styles')
        <link rel="stylesheet" href="{{asset(asset_path('backend/css/role_module_style.css'))}}">

<link rel="stylesheet" href="{{asset(asset_path('modules/sidebarmanager/css/style.css'))}}" />
       
    @endsection
@section('mainContent')

    <div class="role_permission_wrap">
        <div class="permission_title">
            <h4>{{ trans('common.sidebar_manager') }} {{ trans('common.for') }} ({{auth()->user()->first_name}})</h4>
        </div>
    </div>

    @if(count($PermissionList) > 0)
        {{ Form::open(['class' => 'form-horizontal menu-form', 'files' => true, 'route' => 'sidebar-manager.store','method' => 'POST']) }}
        <div class="erp_role_permission_area ">
            <!-- single_permission  -->
            <div class="mesonary_role_header" id="sortable">
                @foreach ($PermissionList->where('type',1) as $key => $Module)
                    @if(!$Module->module or isModuleActive($Module->module))
                        @if(!isModuleActive('Affiliate') && $Module->module == 'PageBuilder')
                        
                        @else
                            @include('sidebarmanager::components',[ 'key' =>$key, 'Module' =>$Module ])
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="row mt-40">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="primary-btn fix-gr-bg submitter">
                        <span class="ti-check"></span>
                        {{ trans('common.submit') }}
                    </button>
                </div>
            </div>

        </div>
        {{ Form::close() }}
    @endif
@endsection



@push('scripts')

    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $('.permission-checkAll').on('click', function () {
                    let status = $(this).closest('.permission_header').find('.status')
                    if ($(this).is(":checked")) {
                        status.val(1);
                        $('.module_id_' + $(this).val()).each(function () {
                            $(this).prop('checked', true);
                        });
                    } else {
                        status.val(0);
                        $('.module_id_' + $(this).val()).each(function () {
                            $(this).prop('checked', false);
                        });
                    }

                });

                $('.module_link').on('click', function () {
                    var module_id = $(this).parents('.single_permission').attr("id");
                    var module_link_id = $(this).val();

                    var status = $(this).closest('.submodule').find('.sub_status');

                    if ($(this).is(":checked")) {
                        status.val(1);
                        $(".module_option_" + module_id + '_' + module_link_id).prop('checked', true);
                    } else {
                        status.val(0);
                        $(".module_option_" + module_id + '_' + module_link_id).prop('checked', false);
                    }

                    var checked = 0;
                    $('.module_id_' + module_id).each(function () {
                        if ($(this).is(":checked")) {
                            checked++;
                        }
                    });

                    if (checked > 0) {
                        $(".main_module_id_" + module_id).prop('checked', true);
                    } else {
                        $(".main_module_id_" + module_id).prop('checked', false);
                    }
                });

                $('.module_link_option').on('click', function () {
                    var module_id = $(this).parents('.single_permission').attr("id");
                    var module_link = $(this).parents('.module_link_option_div').attr("id");
                    var status = $(this).closest('.module_link_option_div').find('.action_status');
                    // module link check
                    var link_checked = 0;
                    $('.module_option_' + module_id + '_' + module_link).each(function () {
                        if ($(this).is(":checked")) {
                            link_checked++;
                        }
                    });

                    if (link_checked > 0) {
                        $("#Sub_Module_" + module_link).prop('checked', true);
                    } else {
                        $("#Sub_Module_" + module_link).prop('checked', false);
                    }
                    if ($(this).is(":checked")) {
                        status.val(1);
                    } else {
                        status.val(0);
                    }

                    // module check
                    var checked = 0;

                    $('.module_id_' + module_id).each(function () {
                        if ($(this).is(":checked")) {
                            checked++;
                        }
                    });

                    if (checked > 0) {
                        $(".main_module_id_" + module_id).prop('checked', true);
                    } else {
                        $(".main_module_id_" + module_id).prop('checked', false);
                    }
                });
                $("#sortable").sortable().disableSelection();
                $(".submenuSort").sortable().disableSelection();
                $(".option").sortable().disableSelection();

                $('.single_role_blocks .arrow').mousemove(function () {
                    menuArrange(this);
                });

                $('.permission_body .sub_menu_li').mousemove(function () {
                    subMenuArrange(this);
                });

                $(document).on('submit', '.menu-form', function () {
                    let menus = $(this).find('.single_role_blocks .arrow');
                    let sub_menus = $(this).find('.permission_body .sub_menu_li');
                    let action_menus = $(this).find('.option li');

                    $.each(menus, function () {
                        menuArrange(this);
                    });

                    $.each(sub_menus, function () {
                        subMenuArrange((this));
                    });

                    $.each(action_menus, function () {
                        actionMenuArrange((this));
                    });
                });
            });

            function menuArrange(el) {
                var idx = $(el).index('.arrow') + 1;
                let selector = $(el).parent().find('.menu_positions');
                selector.val(idx);
            }

            function subMenuArrange(el) {
                var idx = $(el).index() + 1;
                let selector = $(el).find('.sub_positions');
                selector.val(idx)
            }

            function actionMenuArrange(el) {
                var idx = $(el).index() + 1;
                let selector = $(el).find('.action_position');
                selector.val(idx)
            }
        })(jQuery);

    </script>

@endpush
