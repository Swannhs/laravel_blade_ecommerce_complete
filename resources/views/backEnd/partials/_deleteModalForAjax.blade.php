<div class="modal fade" id="{{isset($modal_id)?$modal_id:'deleteItemModal'}}" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete') {{ $item_name }} </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                    <form id="{{isset($form_id)?$form_id:'item_delete_form'}}">
                        <input type="hidden" name="id" id="{{isset($delete_item_id)?$delete_item_id:'delete_item_id'}}">
                        <input id="{{isset($dataDeleteBtn)?$dataDeleteBtn:'dataDeleteBtn'}}" type="submit" class="primary-btn fix-gr-bg" value="@lang('common.delete')"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
