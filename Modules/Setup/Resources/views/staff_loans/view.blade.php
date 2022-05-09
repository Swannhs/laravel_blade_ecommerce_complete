<div class="modal fade admin-query" id="ApplyLoanview">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.apply_loan_details') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <img src="{{ showImage($loan->user->avatar!= null ? $loan->user->avatar : "backend/img/user-no-img.png") }}" id="view_common_image" class="user-img-show-loan">
                    </div>

                    <div class="col-xl-6">
                        <p>{{__('common.name')}} : <span>{{ $loan->user != null ? $loan->user->name : "Removed" }}</span></p>
                        <p>{{__('common.title')}} : <span>{{ $loan->title }}</span></p>
                        <p>{{__('common.department')}} : <span></span>{{ @$loan->department->name }}</p>
                        <p>{{__('common.loan_type')}} : <span></span>{{ $loan->loan_type }}</p>
                        <p>{{__('common.applied_date')}} : <span></span>{{ date(app('general_setting')->dateFormat->format, strtotime($loan->apply_date)) }}</p>
                        <p>{{__('common.loan_date')}} : <span></span>{{ date(app('general_setting')->dateFormat->format, strtotime($loan->loan_date)) }}</p>
                        <p>{{__('common.amount')}} : <span></span>{{ single_price($loan->amount) }}</p>
                        <p>{{__('common.paid_loan_amount')}} : <span ></span>{{ single_price($loan->paid_loan_amount) }}</p>
                        <p>{{__('common.total_month')}} : <span></span>{{ $loan->total_month }}</p>
                        <p>{{__('common.monthly_installment')}} : <span></span>{{ single_price($loan->monthly_installment) }}</p>
                    </div>
                    <div class="col-xl-12">
                        <label class="primary_input_label" for="">{{__('common.description')}}</label>
                        <p id="view_product_description">{{ $loan->note }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
