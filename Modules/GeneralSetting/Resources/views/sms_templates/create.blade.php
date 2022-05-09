@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.sms_template')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        <form action="{{route('sms_templates.store')}}" method="post">
                            @csrf
                            <!-- content  -->
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.Type')}} <span class="text-danger">*</span></label>
                                        <select class="primary_select mb-25" name="type_id" id="type_id">
                                            @foreach ($sms_template_types as $key => $type)
                                                @if(!$type->module or isModuleActive($type->module))
                                                    <option value="{{ $type->id }}">{{ strtoupper(str_replace("_"," ",$type->type)) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('type_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-6 delivery_process_div d-none">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.set_for')}} <span class="text-danger">*</span></label>
                                        <select class="primary_select mb-25" name="delivery_process_id" id="delivery_process_id">
                                            @foreach ($delivery_processes as $key => $delivery_process)
                                                <option value="{{ $delivery_process->id }}">{{ $delivery_process->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('delivery_process_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-6 refund_process_div d-none">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.set_for')}}</label>
                                        <select class="primary_select mb-25" name="refund_process_id" id="refund_process_id">
                                            @foreach ($refund_processes as $key => $refund_process)
                                                <option value="{{ $refund_process->id }}">{{ $refund_process->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('refund_process_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.subject')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="subject" class="primary_input_field" placeholder="{{__('general_settings.subject')}}">
                                        <span class="text-danger">{{$errors->first('subject')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.reciepent')}}</label>
                                        <select class="primary_select mb-25" name="reciepnt_type[]" id="reciepnt_type" multiple>
                                            <option value="customer">{{__('general_settings.customer')}}</option>
                                            @if(isModuleActive('MultiVendor'))
                                            <option value="seller">{{__('general_settings.seller')}}</option>
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('reciepnt_type')}}</span>
                                    </div>
                                </div>
                                
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.short_code')}} <small>({{__('general_settings.use_these_to_get_your_neccessary_info')}})</small> </label>
                                        <label class="primary_input_label red_text" for="">{GIFT_CARD_NAME}, {SECRET_CODE}, {USER_FIRST_NAME}, {USER_EMAIL}, {ORDER_TRACKING_NUMBER}, {WEBSITE_NAME}</label>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.template')}}</label>
                                        <textarea name="template" class="form-control primary_input_field" rows="10" placeholder="" >hello</textarea>
                                        <span class="text-danger">{{$errors->first('template')}}</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="submit_btn text-center mb-100 pt_15">
                                <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
                            </div>
                            <!-- content  -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            $(document).ready(function() {
                
                $(document).on('change', '#type_id', function(){
                    if (this.value == 7) {
                        $(".delivery_process_div").removeClass('d-none');
                        $(".refund_process_div").addClass('d-none');
                    }else if (this.value == 14) {
                        $(".refund_process_div").removeClass('d-none');
                        $(".delivery_process_div").addClass('d-none');
                    }else {
                        $(".delivery_process_div").addClass('d-none');
                        $(".refund_process_div").addClass('d-none');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
