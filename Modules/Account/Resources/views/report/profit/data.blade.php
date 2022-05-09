<!-- table-responsive -->
<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{ __('common.date') }}</th>
            <th scope="col">{{ __('common.title') }}</th>
            <th scope="col">{{ __('income.Incomes') }}</th>
            <th scope="col">{{ __('expense.Expense') }}</th>
            <th scope="col">{{ __('account.Profit') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @if(!$data['start'] and !$data['end'])
                {{ __('account.From The Beginning') }}
                @else
                {{ dateFormat($data['start']) }} - {{ dateFormat($data['end']) }}
                @endif
            </td>
            <td>
                {{ __('account.Main Income Account') }}
            </td>

            <td>
                {{ amountFormat($data['income']) }}
            </td>
            <td>
                {{ amountFormat($data['expense']) }}
            </td>
            <td>
                {{ amountFormat($data['income'] - $data['expense']) }}
            </td>


        </tr>
        <tr>
            <td>
                @if(!$data['start'] and !$data['end'])
                {{ __('account.From The Beginning') }}
                @else
                {{ dateFormat($data['start']) }} - {{ dateFormat($data['end']) }}
                @endif
            </td>
            <td>
                {{ __('account.GST / TAX / VAT') }}
            </td>

            <td>
                {{ amountFormat($data['gst_income']) }}
            </td>
            <td>
                {{ amountFormat($data['gst_expense']) }}
            </td>
            <td>
                {{ amountFormat($data['gst_income'] - $data['gst_expense']) }}
            </td>


        </tr>

        <tr>
            <td>
                @if(!$data['start'] and !$data['end'])
                {{ __('account.From The Beginning') }}
                @else
                {{ dateFormat($data['start']) }} - {{ dateFormat($data['end']) }}
                @endif
            </td>
            <td>
                {{ __('account.Total Product Wise Tax') }}
            </td>

            <td>
                {{ amountFormat($data['product_tax_income']) }}
            </td>
            <td>
                {{ amountFormat($data['product_tax_expense']) }}
            </td>
            <td>
                {{ amountFormat($data['product_tax_income'] - $data['product_tax_expense']) }}
            </td>


        </tr>

    </tbody>
</table>
