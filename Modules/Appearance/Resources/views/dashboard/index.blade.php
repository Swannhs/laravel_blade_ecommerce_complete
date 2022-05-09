@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title)
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.dashboard_setup') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.make_widget_card_colorful') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach (app('dashboard_setup')->whereBetween('id', [1,12]) as $key => $config)
                            @if(!isModuleActive('MultiVendor') && $config->id == 2)

                            @else
                            <div class="col-4">
                                <label class="primary_input_label">{{ str_replace('_',' ', $config->type) }}</label>
                                <ul id="" class="permission_list sms_list">
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="{{$config->type}}" class="config_type" type="radio" id="{{$config->type}}_1" value="0" @if ($config->is_active == 0) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('dashboard.normal') }}</p>
                                    </li>
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="{{$config->type}}" class="config_type" type="radio" id="{{$config->type}}_1" value="1" @if ($config->is_active == 1) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('dashboard.color') }}</p>
                                    </li>
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="{{$config->type}}" class="config_type" type="radio" id="{{$config->type}}_1" value="2" @if ($config->is_active == 2) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('dashboard.reverse') }}</p>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="box_header common_table_header mt-5">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.make_visible_in_dashboard') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach (app('dashboard_setup')->whereBetween('id', [13,41]) as $key => $config_d)
                            @if(!isModuleActive('MultiVendor') && $config_d->id == 14 || $config_d->id == 27 || $config_d->id == 31)
                            @else
                            <div class="col-4">
                                <label class="primary_input_label">{{ str_replace('_',' ', $config_d->type) }}</label>
                                <ul id="" class="permission_list sms_list">
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="{{$config_d->type}}" class="config_type" type="radio" id="{{$config_d->type}}_1" value="1" @if ($config_d->is_active == 1) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('dashboard.visible') }}</p>
                                    </li>
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="{{$config_d->type}}" class="config_type" type="radio" id="{{$config_d->type}}_1" value="0" @if ($config_d->is_active == 0) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('dashboard.hide') }}</p>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
        (function($) {
        "use strict";
            $(document).ready(function(){
                $(document).on('change', '.config_type', function(){
                    $.post("{{ route('appearance.dashoboard.status_update') }}", {_token:'{{ csrf_token() }}', type:this.name, is_active:this.value}, function(data){
                        console.log(data);
                        if(data == 1){
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        }
                        else{
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    })
                    .fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                    });
                });
            });
        })(jQuery);
    </script>
@endpush
