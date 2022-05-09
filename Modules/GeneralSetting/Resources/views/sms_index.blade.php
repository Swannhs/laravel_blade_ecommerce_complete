@extends('backEnd.master')

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white_box_30px">
                            @include('generalsetting::page_components.sms_settings')
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
                gatewayData();

                $(document).on('change','.sms_gateway', function(){
                    gatewayData();
                });
                function gatewayData(){
                    let gateway_type = $('.sms_gateway:checked').data("type");
                    let twilioData = $('#Twilio_Settings');
                    let textLocalData = $('#TexttoLocal_Settings');
                    let otherData = $('#other_Settings');
                    twilioData.hide();
                    textLocalData.hide();
                    otherData.hide();
                    if (gateway_type === 'Twillo') {
                        twilioData.show();
                    }else if(gateway_type === 'TextLocal'){
                        textLocalData.show();
                    }
                    else{
                        otherData.show();
                    }
                }
            });
        })(jQuery);

    </script>
@endpush
