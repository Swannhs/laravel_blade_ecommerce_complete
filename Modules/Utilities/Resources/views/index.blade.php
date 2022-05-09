@extends('backEnd.master')

@section('mainContent')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="main-title d-flex">
            <h3 class="mb-0 mr-3 text-nowrap">{{ __('utilities.utilities') }} </h3>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            @if(permissionCheck('utilities_clear_cache'))
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax"
                    href="{{ route('utilities.index', ['utilities' => 'optimize_clear']) }}">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="ti-cloud font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase">{{ __('utilities.clear_cache') }}</h1>
                    </div>
                </a>
            </div>
            @endif

            @if(permissionCheck('utilities_clear_log'))
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax"
                    href="{{ route('utilities.index', ['utilities' => 'clear_log']) }}">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="ti-receipt font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase">{{ __('utilities.clear_log') }}</h1>
                    </div>
                </a>
            </div>
            @endif

            @if(permissionCheck('utilities_change_debug_mode'))
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax"
                    href="{{ route('utilities.index', ['utilities' => 'change_debug']) }}">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="ti-blackboard font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase">@if(env('APP_DEBUG')) {{__('utilities.disable')}}
                            @else {{ __("utilities.enable") }} @endif {{__('utilities.app_debug')}}</h1>
                    </div>
                </a>
            </div>
            @endif

            @if(permissionCheck('utilities_change_force_https'))
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax"
                    href="{{ route('utilities.index', ['utilities' => 'force_https']) }}">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="ti-lock font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase">@if(env('FORCE_HTTPS')) {{__('utilities.disable')}}
                            @else {{ __("utilities.enable") }} @endif {{ __('utilities.force_https') }}</h1>
                    </div>
                </a>
            </div>
            @endif

            @if(auth()->id() == 1)
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax" id="reset_database_card" href="#">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="fas fa-database font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase"> {{ __('utilities.reset_database') }}</h1>
                    </div>
                </a>
            </div>
            @endif
            @if(auth()->id() == 1)
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a class="white-box single-summery d-block btn-ajax" id="import_database_card" href="#">
                        <div class="d-block mt-10 text-center ">
                            <h3><i class="fas fa-database font_30"></i></h3>
                            <h1 class="gradient-color2 total_purchase"> {{ __('Import Demo Database') }}</h1>
                        </div>
                    </a>
                </div>
            @endif

            @if(permissionCheck('utilities_xml_sitemap'))
            <div class="col-md-4 col-lg-3 col-sm-6">
                <a class="white-box single-summery d-block btn-ajax" href="#" id="xml_sitemap_card">
                    <div class="d-block mt-10 text-center ">
                        <h3><i class="fas fa-sitemap font_30"></i></h3>
                        <h1 class="gradient-color2 total_purchase"> {{ __('utilities.xml_sitemap') }}</h1>
                    </div>
                </a>
            </div>
            @endif

            <div class="col-lg-12">
                <div class="alert alert-warning mt-30 text-center">
                    {{__('utilities.It can take some times to execute operation. please wait until completed
                    operation')}}
                </div>
            </div>

            {{-- Reset Modal --}}
            <div class="modal fade admin-query" id="resetModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('utilities.reset_database')</h4>
                            <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <strong>{{__('utilities.reset_database_note')}}</strong>
                                <h4>@lang('utilities.are_you_sure_to_reset_database')</h4>
                            </div>
                            <div class="mt-40 justify-content-between">
                                <form id="activate_form" action="{{route('utilities.reset_database')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="title">{{__('common.enter_your_password')}} <span
                                                        class="text-danger">*</span></label>
                                                <input required type="password" id="password"
                                                    class="primary_input_field" name="password" autocomplete="off"
                                                    value="" placeholder="{{__('common.enter_your_password')}} ">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="primary_input">
                                            <button type="submit" class="primary-btn fix-gr-bg"
                                                id="save_button_parent">{{ __('utilities.reset_database') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- xml Modal --}}
            <div class="modal fade admin-query" id="xmlModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('utilities.xml_sitemap')</h4>
                            <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <h4>@lang('utilities.choose_sitemap_option')</h4>
                            </div>
                            <div class="mt-40 justify-content-between">
                                <form id="activate_form" action="{{route('utilities.xml_sitemap')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <div class="primary_input">

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <label data-id="bg_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" id="all" value="all"
                                                                    class="active" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('common.all') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="pages"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('common.page') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="products"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('common.product') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                            class="primary_checkbox d-flex mr-12">
                                                            <input name="sitemap[]" value="brands"
                                                                id="status_inactive" class="de_active"
                                                                type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.brand') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="tags"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('common.tag') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="flash_deal"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('marketing.flash_deal') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="new_user_zone"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('marketing.new_user_zone') }}</p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label data-id="color_option"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="sitemap[]" value="blogs"
                                                                    id="status_inactive" class="de_active"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p>{{ __('blog.blog') }}</p>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger" id="status_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="primary_input">
                                            <button type="submit" class="primary-btn fix-gr-bg"
                                                id="save_button_parent">{{ __('common.submit') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- import database modal --}}
            <div class="modal fade admin-query" id="ImportDatabaseModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('utilities.import_demo_database')</h4>
                            <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <strong>{{__('utilities.import_demo_note')}}</strong>
                                <h4>@lang('utilities.are_you_sure_to_import_demo_database')</h4>
                            </div>
                            
                            <div class="mt-40 justify-content-between">
                                <form id="activate_form" action="{{route('utilities.import_demo_database')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="title">{{__('common.enter_your_password')}} <span
                                                        class="text-danger">*</span></label>
                                                <input required type="password" id="password"
                                                    class="primary_input_field" name="password" autocomplete="off"
                                                    value="" placeholder="{{__('common.enter_your_password')}} ">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="primary_input">
                                            <button type="submit" class="primary-btn fix-gr-bg"
                                                id="save_button_parent">{{ __('utilities.import_database') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '#reset_database_card', function(event){
                    event.preventDefault();
                    $('#resetModal').modal('show');
                });
                $(document).on('click', '#import_database_card', function(event){
                    event.preventDefault();
                    $('#ImportDatabaseModal').modal('show');
                });
                $(document).on('click', '#xml_sitemap_card', function(event){
                    event.preventDefault();
                    $('#xmlModal').modal('show');
                });
                $(document).on('click', '#all', function(event){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
                $(document).on('click', '.de_active', function(event){
                    $('#all').prop('checked',false);
                });

            });
        })(jQuery);
</script>
@endpush
