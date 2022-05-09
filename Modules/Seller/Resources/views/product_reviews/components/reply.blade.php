<div id="reply_modal_div">
    <div class="modal fade" id="reply_modal">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{__('review.reply_to_customer')}}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body item_create_form">
                    <div class="customer_feedback mb_60">
                        <h4>{{__('review.customer_feedback')}}: </h4>
                        <p>
                            {{$review->review}}
                        </p>
                    </div>

                    <form enctype="multipart/form-data" id="ReplyForm">
                        <div class="row">
                            <input type="hidden" name="review_id" value="{{$review->id}}">
                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                        for="">{{ __('common.message') }} <span class="text-danger">*</span></label>
                                    <textarea id="review" name="review" cols="25" class="form-control primary_input" placeholder="{{ __('review.reply') }}"
                                    rows="8" required></textarea>
                                </div>
                                <span class="text-danger" id="error_review"></span>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                                            class="ti-check"></i>
                                        {{ __('review.reply') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
