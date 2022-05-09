<div class="modal fade" id="package_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('Refund State') }}
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body item_create_form">


                <div class="row">
                    <div class="col-lg-12 student-details">

                            @if (permissionCheck('order_manage.update_delivery_status'))
                                <form action="{{ route('refund.update_refund_detail_state_by_seller', $refund_detail->id) }}" method="post">
                                    @csrf
                                    <div class="row white_box p-25 ml-0 mr-0 box_shadow_white mb-100">
                                        <div class="col-lg-12 p-0">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for=""> <strong>{{ __('refund.processing_state') }}</strong> </label>
                                                <select required class="primary_select mb-25" name="processing_state" id="processing_state">
                                                    <option value="">{{ __('common.select')}}</option>
                                                    @foreach ($processes as $key => $process)
                                                        <option value="{{ $process->id }}" @if ($refund_detail->processing_state == $process->id) selected @endif>{{ $process->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p-0 text-center">
                                            <button class="primary_btn_2"><i class="ti-check"></i>{{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
