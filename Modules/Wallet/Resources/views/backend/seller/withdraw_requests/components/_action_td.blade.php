@if ($transaction->status == 0)
    <a class="primary-btn radius_30px mr-10 fix-gr-bg link_btn getEditForm" data-value="{{ $transaction }}">{{ __('wallet.edit') }}</a>
@endif
