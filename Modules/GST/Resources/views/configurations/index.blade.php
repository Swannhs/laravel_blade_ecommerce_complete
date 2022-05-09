@extends('backEnd.master')
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0 mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('gst.gst_configuration') }} /TAX/VAT</h3>
                        </div>
                    </div>
                    <form action="{{route("gst_tax.configuration_update")}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="permission_list sms_list">
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="enable_gst" type="radio" id="enable_gst_1" value="gst" @if (app('gst_config')['enable_gst'] == "gst") checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('gst.is_active_gst') }}</p>
                                    </li>
                                    <li>
                                        <label class="primary_checkbox d-flex mr-12 ">
                                            <input name="enable_gst" type="radio" id="enable_gst_2" value="flat_tax" @if (app('gst_config')['enable_gst'] == "flat_tax") checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('gst.is_active_flat_tax') }}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-12 inside_state_div @if (app('gst_config')['enable_gst'] != "gst") d-none @endif">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('gst.place_of_delivery_inside_state') }}</label>
                                    <select class="primary_select mb-25" name="within_a_single_state[]" id="within_a_single_state" multiple>
                                        <option value="0" disabled>{{ __('gst.select_one_or_multiple') }}</option>
                                        @foreach ($gst_lists as $key => $gst)
                                            <option value="{{ $gst->id }}" @if (in_array ($gst->id, app('gst_config')['within_a_single_state'])) selected @endif>{{ $gst->name }} ({{ $gst->tax_percentage }} %)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 outside_state_div @if (app('gst_config')['enable_gst'] != "gst") d-none @endif">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('gst.place_of_delivery_outside_state') }}</label>
                                    <select class="primary_select mb-25" name="between_two_different_states_or_a_state_and_a_Union_Territory[]" id="between_two_different_states_or_a_state_and_a_Union_Territory" multiple>
                                        <option value="0" disabled>{{ __('gst.select_one_or_multiple') }}</option>
                                        @foreach ($gst_lists as $key => $gst)
                                            <option value="{{ $gst->id }}" @if (in_array ($gst->id, app('gst_config')['between_two_different_states_or_a_state_and_a_Union_Territory'])) selected @endif>{{ $gst->name }} ({{ $gst->tax_percentage }} %)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 flat_div @if (app('gst_config')['enable_gst'] == "gst") d-none @endif">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('gst.flat_tax_percentage') }}</label>
                                    <select class="primary_select mb-25" name="flat_tax_id" id="flat_tax_id">
                                        <option value="0" disabled>{{ __('gst.select_one_or_multiple') }}</option>
                                        @foreach ($gst_lists as $key => $gst)
                                            <option value="{{ $gst->id }}" @if (app('gst_config')['flat_tax_id'] == $gst->id) selected @endif>{{ $gst->name }} ({{ $gst->tax_percentage }} %)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (permissionCheck('gst_tax.configuration_update'))
                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i> {{ __('common.update') }} </button>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-12 text-center mt-2">
                                    <span class="alert alert-warning" role="alert">
                                        <strong>
                                            {{ __('common.you_don_t_have_this_permission') }}
                                        </strong>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </form>
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
                $(document).on('change', 'input[type=radio][name=enable_gst]', function(){
                    if (this.value == 'gst') {
                        $(".flat_div").addClass('d-none');
                        $(".outside_state_div").removeClass('d-none');
                        $(".inside_state_div").removeClass('d-none');
                    }
                    else if (this.value == 'flat_tax') {
                        $(".flat_div").removeClass('d-none');
                        $(".outside_state_div").addClass('d-none');
                        $(".inside_state_div").addClass('d-none');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
