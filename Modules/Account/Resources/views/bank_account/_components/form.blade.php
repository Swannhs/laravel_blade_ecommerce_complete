<div class="col-xl-6">
    <x-backEnd.input name="bank_name" type="text" :required="true" :field="trans('bank_account.Bank Name')" />
</div>

<div class="col-xl-6">
    <x-backEnd.input name="branch_name" type="text" :required="true" :field="trans('bank_account.Branch Name')" />
</div>
<div class="col-xl-6">
    <x-backEnd.input name="account_name" type="text" :required="true" :field="trans('bank_account.Account Name')" />
</div>

<div class="col-xl-6">
    <x-backEnd.input name="account_number" type="text" :required="true" :field="trans('bank_account.Account Number')" />
</div>

<div class="col-xl-12">
    <x-backEnd.input name="opening_balance" type="text" :required="false" :field="trans('account.Opening Balance')" />
</div>

<div class="col-xl-12">
    <x-backEnd.textarea name="description" type="text" :required="false" :field="trans('common.description')" />
</div>
@php
$status = isset($bankAccount) ? $bankAccount->status : 1;
@endphp
<div class="col-xl-12">
    <x-backEnd.checkbox name="status" type="text" :required="false" :field="trans('common.active')" value="1"
        :checked="$status" />
</div>
