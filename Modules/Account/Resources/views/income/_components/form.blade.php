<div class="col-xl-6">
    <x-backEnd.input name="title" type="text" :required="true" :field="trans('common.title')" />
</div>

<div class="col-xl-6 ">
    <x-backEnd.select name="chart_of_account_id" :value="$default_id" :required="true"
        :field="trans('chart_of_account.Income Account')" :options="$chart_of_accounts"
        :help="__('chart_of_account.Select your Income Account')" />
</div>

<div class="col-xl-6 ">
    <x-backEnd.select name="payment_method" :required="true" :field="trans('chart_of_account.Payment Method')"
        :options="$payment_methods" :help="__('chart_of_account.Select your Payment method')" />
</div>

<div class="col-xl-6 mb-25" id="bank_column" {{ (isset($transaction) and $transaction->payment_method == 'Bank') ? '' :
    'style="display: none"' }}>
    <x-backEnd.select name="bank_account_id" :required="false" :field="trans('bank_account.Bank Accounts')"
        :options="$bankAccounts" :help="__('chart_of_account.bank_account_help')" />
</div>

<div class="col-xl-6">
    <x-backEnd.input name="amount" type="text" :required="true" :field="trans('account.Amount')" />
</div>

<div class="col-xl-6">
    <x-backEnd.date name="transaction_date" type="date" :required="true" :field="trans('account.Transaction date')"
        :value="isset($transaction) ? $transaction->transaction_date : date('Y-m-d')" />
</div>

<div class="col-xl-6">
    <x-backEnd.file name="file" :required="false" :field="trans('common.file')" />
</div>

<div class="col-xl-12">
    <x-backEnd.textarea name="description" :required="false" :field="trans('common.description')" />
</div>
