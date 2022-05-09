<!-- table-responsive -->
<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{ __('common.date') }}</th>
            <th scope="col">{{ __('common.title') }}</th>
            <th scope="col">{{ __('transaction.Credit') }}</th>
            <th scope="col">{{ __('transaction.Debit') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>
                {{ dateFormat($transaction->transaction_date) }}
            </td>

            <td>
                {{ $transaction->title }}
            </td>

            <td>
                @if($transaction->type == 'in')
                {{ amountFormat($transaction->amount) }}
                @endif
            </td>

            <td>
                @if($transaction->type == 'out')
                {{ amountFormat($transaction->amount) }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>{{ trans('common.total') }}</td>
            <td></td>
            <td>{{ single_price($transactions->where('type','in')->sum('amount')) }}</td>
            <td>{{ single_price($transactions->where('type','out')->sum('amount')) }}</td>
        </tr>
    </tfoot>
</table>
