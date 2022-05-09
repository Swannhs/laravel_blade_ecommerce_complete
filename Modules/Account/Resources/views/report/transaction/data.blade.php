<!-- table-responsive -->
<table class="table Crm_table_active_3">
    <thead>
        <tr>
            <th scope="col">{{ __('common.date') }}</th>
            <th scope="col">{{ __('chart_of_account.Chart Of Accounts') }}</th>
            <th scope="col">{{ __('bank_account.Bank Accounts') }}</th>
            <th scope="col">{{ __('common.title') }}</th>
            <th scope="col">{{ __('transaction.Credit') }}</th>
            <th scope="col">{{ __('transaction.Debit') }}</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td>{{ trans('common.total') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<input type="hidden" id="currency_sym" name="currency_sym" value="{{ app('general_setting')->currency_symbol }}">
