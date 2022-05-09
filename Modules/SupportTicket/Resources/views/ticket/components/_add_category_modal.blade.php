<div class="modal fade admin-query" id="categoryCreateModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('ticket.add_new_category')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form method="POST" id="add_category_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="form_type" value="2">
                            <div class="primary_input mb-25">
                               <label class="primary_input_label"
                                for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field name" type="text" name="name" placeholder="{{__('common.name')}}" autocomplete="off" value="">
                            </div>
                            
                            <span class="text-danger" id="error_category_name"></span>
                            
                        </div>

                        <div class="col-lg-12 mt-40 text-center">
                            <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper "
                                data-original-title="" title="">
                                <span class="ti-check"></span>
                                {{__('common.save')}} </button>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
