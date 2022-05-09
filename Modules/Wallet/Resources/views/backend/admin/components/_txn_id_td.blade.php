@if ($transaction->txn_id)
    {{ $transaction->txn_id }}
@else
    <a onclick="bank_details({{ $transaction }})">{{__('common.show')}}</a>
@endif
