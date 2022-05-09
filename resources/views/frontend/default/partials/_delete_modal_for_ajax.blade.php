
    <!-- Modal -->
    <div class="modal fade" id="{{ isset($modal_id) ? $modal_id : 'deleteItemModal' }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('common.delete') {{ $item_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn_2 w-100 mt-0 modal_btn_2" data-dismiss="modal" aria-label="Close">@lang('common.cancel')</button>
                        </div>
                        <div class="col-lg-6">
                            <form id="{{ isset($form_id) ? $form_id : 'item_delete_form' }}" class="p-0">
                                <input type="hidden" name="id" id="{{ isset($delete_item_id) ? $delete_item_id : 'delete_item_id' }}">
                                <button type="submit" class="btn_1 w-100 mt-0" id ="{{ isset($dataDeleteBtn) ? $dataDeleteBtn : 'dataDeleteBtn' }}">{{ __('common.delete') }}</button>
                            </form>
                        </div>
                    </div>
                        
                    
                </div>
                
            </div>
        </div>
