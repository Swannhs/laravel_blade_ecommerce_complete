<div class="modal fade" id="package_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('review.reply_to_customer') }}
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body item_create_form">


                <div class="row">
                    <div class="col-lg-12 student-details">

                        @if ($package->order->is_cancelled != 1 && $package->is_cancelled != 1)
                            @if (permissionCheck('order_manage.update_delivery_status'))
                                <form action="{{ route('order_manage.update_delivery_status', $package->id) }}"
                                    method="post">
                                    @csrf
                                    <div class="row white_box p-25 box_shadow_white mr-0 ml-0">
                                        @if ($package->order->is_confirmed == 0)
                                            <div class="col-lg-12">
                                                <div class="primary_input">
                                                    <label class="primary_selectlabel alert alert-warning">
                                                        Status is changable after confirmed the order.

                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-lg-12 p-0">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">
                                                    <strong>{{ __('order.delivery_status') }}</strong></label>
                                                <select class="primary_select mb-25" name="delivery_status"
                                                    id="delivery_status"
                                                    {{ $package->order->is_confirmed == 0 ? 'disabled' : '' }}>
                                                    @foreach ($package->processes as $key => $process)
                                                        <option value="{{ $process->id }}" @if ($package->delivery_status == $process->id) selected @endif>
                                                            {{ $process->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p-0">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">
                                                    <strong>{{ __('order.note') }}</strong> </label>
                                                <textarea class="primary_textarea height_112 address"
                                                    placeholder="{{ __('order.note') }}" name="note"
                                                    spellcheck="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p-0 text-center">
                                            <button class="primary_btn_2"><i
                                                    class="ti-check"></i>{{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            <div class="row mt-2 mr-0 ml-0 white_box p-25 box_shadow_white">
                                <div class="col-lg-12 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th scope="col">{{ __('common.state') }}</th>
                                                <th scope="col">{{ __('common.date') }}</th>
                                                <th scope="col">{{ __('common.note') }}</th>
                                                <th scope="col">{{ __('common.updated_by') }}</th>
                                            </tr>
                                            @foreach ($package->delivery_states as $key => $delivery_state)
                                                <tr>
                                                    <td>{{ $delivery_state->delivery_process->name }}</td>
                                                    <td>{{ $delivery_state->created_at }}</td>
                                                    <td>{{ @$delivery_state->note }}</td>
                                                    <td>{{ @$delivery_state->creator->first_name }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
