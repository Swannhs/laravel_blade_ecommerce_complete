@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('refund.configuration') }}</h3>
                        </div>
                    </div>
                    @php
                    $refund_time = app('business_settings')->where('type', 'refund_times')->first();
                    $approval = app('business_settings')->where('type', 'refund_status')->first();
                    @endphp
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="">{{ strtoupper(str_replace("_"," ",($approval->type))) }}</label>
                                <label class="switch_toggle" for="checkbox{{ $approval->id }}">
                                    <input type="checkbox" id="checkbox{{ $approval->id }}" @if ($approval->status == 1)
                                    checked @endif value="{{ $approval->id }}" class="refund_status">
                                    <div class="slider round"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('refund.refund_config_store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="id" value="{{ $refund_time->id }}">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">
                                        {{ strtoupper(str_replace("_"," ",($refund_time->type))) }} {{ __('refund.in_days') }} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field" name="status" id="status" placeholder=""
                                        type="text" value="{{$refund_time->status}}" required="1">
                                    <span class="text-danger">{{$errors->first('status')}}</span>
                                </div>
                            </div>
                            @if (permissionCheck('refund.refund_config_store'))
                            <div class="col-lg-12 text-center">
                                <button class="primary_btn_2 mt-2"><i class="ti-check"></i>{{__("common.save")}}
                                </button>
                            </div>
                            @else
                            <div class="col-lg-12 text-center mt-2">
                                <span class="alert alert-warning" role="alert">
                                    <strong>{{ __('common.you_don_t_have_this_permission') }}</strong>
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
    (function($){
        "use Strict";
        $(document).ready(function(){
            $(document).on('change', '.refund_status', function(event){
                update_active_status($(this)[0]);
            });

            function update_active_status(el){
                $('#pre-loader').removeClass('d-none');
                if(el.checked){
                    var status = 1;
                }
                else{
                    var status = 0;
                }
                $.post('{{ route('update_activation_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                        $('#pre-loader').addClass('d-none');
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                }).fail(function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }

                });
            }

        });
    })(jQuery);

</script>
@endpush
