<div class="modal fade admin-query" id="testModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('marketing.test_sms')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form method="POST" action="" id="testSMSForm">
                <input type="hidden" name="id" value="{{$id}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="primary_input mb-25">
                               <label class="primary_input_label"
                                for="phone">{{__('common.phone_number')}}<span class="text-danger">*</span></label>
                                <input class="primary_input_field name" type="text" placeholder="{{__('common.phone_number')}}" name="phone" id="phone" autocomplete="off" value="">
                            </div>
                            
                            <span class="text-danger" id="error_phone"></span>
                            
                        </div>

                        <div class="col-md-12">
                            <div class="mt-40 text-center">
                                <button type="button" class="primary-btn tr-bg mr-10 modal_cancel_btn" data-dismiss="modal">{{__('common.cancel')}}</button>
                                <button type="submit" id="sms_send_btn" class="primary-btn fix-gr-bg tooltip-wrapper "
                                        data-original-title="" title="">
                                        <span class="ti-check"></span>
                                        {{__('common.send')}} </button>
    
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
