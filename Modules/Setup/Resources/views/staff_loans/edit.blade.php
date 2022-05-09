<div class="modal fade admin-query" id="ApplyLoanEdit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.apply_for_loan_update') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('apply_loans.update', $loan->id) }}" method="post" id="ApplyLoan_addForm">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.department') }} *</label>
                                <select class="primary_select mb-25 department_id" name="department_id"
                                    id="department_id" required>
                                    @foreach (\Modules\Setup\Entities\Department::where('status', 1)->get() as $key =>
                                    $department)
                                    <option value="{{ $department->id }}" @if ($loan->department_id == $department->id)
                                        selected @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="department_id_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.type') }} *</label>
                                <select class="primary_select mb-25 loan_type" name="loan_type" id="loan_type" required>
                                    <option value="General" @if ($loan->loan_type == "General") selected
                                        @endif>{{ __('common.General') }}</option>
                                    <option value="Emergency" @if ($loan->loan_type == "Emergency") selected
                                        @endif>{{ __('common.Emergency') }}</option>
                                </select>
                                <span class="text-danger" id="loan_type_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.title') }} *</label>
                                <input name="title" class="primary_input_field title"
                                    placeholder="{{ __('common.title') }}" type="text" value="{{ $loan->title }}"
                                    required>
                                <span class="text-danger" id="title_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{ __('common.loan_date') }}</label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{ __('common.date') }}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="loan_date" type="text" name="loan_date"
                                                    value="{{ date('m/d/Y', strtotime($loan->loan_date)) }}"
                                                    autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                    <span class="text-danger" id="loan_date_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.amount') }} *</label>
                                <input name="amount" id="amount" class="primary_input_field amount"
                                    placeholder="{{ __('common.amount') }}" type="number" min="0" step="1"
                                    value="{{ $loan->amount }}" required>
                                <span class="text-danger" id="amount_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.total_month') }}</label>
                                <input name="total_month" id="total_month" class="primary_input_field total_month"
                                    placeholder="{{ __('common.total_month') }}" type="number"
                                    value="{{ $loan->total_month }}" min="0" step="1" required>
                                <span class="text-danger" id="total_month_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.monthly_installment') }}</label>
                                <input name="monthly_installment" id="monthly_installment"
                                    class="primary_input_field monthly_installment" placeholder="00.00" type="number"
                                    value="{{ $loan->monthly_installment }}" min="0" step="1" readonly>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.description') }} *</label>
                                <textarea class="primary_textarea height_112"
                                    placeholder="{{ __('common.description') }}" name="note" id="note"
                                    spellcheck="false">{{ $loan->note }}</textarea>
                                <span class="text-danger" id="note_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                    id="save_button_parent"><i class="ti-check"></i>{{ __('common.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
