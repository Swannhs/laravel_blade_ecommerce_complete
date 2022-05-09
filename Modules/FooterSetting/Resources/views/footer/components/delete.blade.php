<div class="modal fade" id="deleteItemModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.delete')}} {{__('frontendCms.widget')}} </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>{{__('common.are_you_sure_to_delete_?')}}</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.cancel')}}</button>
                    <form id="item_delete_form">
                        <input type="hidden" name="id" id="delete_item_id">
                        <a id="deleteBtn" href="#" class="primary-btn fix-gr-bg">{{__('common.delete')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>