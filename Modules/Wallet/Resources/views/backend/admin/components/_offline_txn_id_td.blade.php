@if ($transaction->txn_id)
    {{ $transaction->txn_id }}
@else
    <a data-value="{{ $transaction }}" class="bank_details">{{__('common.show')}}</a>
@endif
