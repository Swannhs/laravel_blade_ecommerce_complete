<div class="modal fade" id="deleteBenefitModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete') @lang('frontendcms.benefit') </h4>
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
                    <form id="benefit_delete_form">
                        <input type="hidden" name="id" id="delete_benefit_id">
                    <button id="delete_benefit_btn" type="submit" class="primary-btn fix-gr-bg">{{__('common.delete')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="deleteWorkModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete') @lang('frontendCms.how_it_work') </h4>
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
                    <form id="work_delete_form">
                        <input type="hidden" name="id" id="delete_work_id">
                        <button id="delete_work_btn" type="submit" class="primary-btn fix-gr-bg">{{__('common.delete')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="deleteFaqModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete') @lang('frontendcms.faq') </h4>
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
                    <form id="faq_delete_form">
                        <input type="hidden" name="id" id="delete_faq_id">
                        <button id="delete_faq_btn" type="submit" class="primary-btn fix-gr-bg">{{__('common.delete')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>