<div class="modal fade admin-query" id="edit_page_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('page-builder.Update Page')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="row">
                        @method('PUT')
                        <input type="hidden" value="{{$row->id}}" name="id" id="rowId">
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="title"> {{__('page-builder.Title')}} <span class="required_mark_theme">*</span></label>
                                <input class="primary_input_field page_title" id="title" name="title" placeholder="{{__('page-builder.Title')}}" type="text" value="{{$row->title}}">
                                <span class="text-danger" id="error_title"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="slug"> {{__('page-builder.Slug')}} <span class="required_mark_theme">*</span></label>
                                <input class="primary_input_field page_slug" id="slug" name="slug" placeholder="{{__('page-builder.Slug')}}" type="text" value="{{$row->slug}}">
                                <span class="text-danger" id="error_slug"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg mr-10"  type="submit"><i class="ti-check"></i>{{__('common.update') }}</button>
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button"><i class="ti-check"></i>{{__('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

