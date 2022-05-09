@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.Email Template')}}</h3>
                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('email_templates.create') }}">{{ __('general_settings.add_new_template') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="common_QA_section QA_section_heading_custom">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="table_div">
                                @include('generalsetting::email_templates.components.list',['email_templates' => $email_templates])
                            </div>
                        </div>
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
                $(document).on('click',".checkbox", function(){
                    if (this.checked == false) {
                        var status = 0;
                    }else {
                        var status = 1;
                    }
                    $.post('{{ route('email_templates.update_status') }}', {_token:'{{ csrf_token() }}',id:this.value,status:status}, function(data){
                        if(data.msg == 'not_possible'){
                            toastr.warning("{{__('You hove to keep Active Atleast 1 Template for same type.')}}","{{__('common.warning')}}");
                            $('.table_div').html(data.list);
                            CRMTableThreeReactive();
                        }
                        else if(data.msg == 1){
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('.table_div').html(data.list);
                            CRMTableThreeReactive();
                        }
                        else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }

                    }).fail(function(response) {
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
