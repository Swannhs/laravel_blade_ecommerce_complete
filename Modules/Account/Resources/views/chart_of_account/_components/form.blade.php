<div class="col-xl-6" >
    <x-backEnd.select name="parent_id" :required="false" :field="trans('account.Parent Account')" :options="$chart_of_accounts" :help="__('chart_of_account.Parent account selection will add your account as a sub account')" :disabled="isset($chartOfAccount)"/>
</div>

<div class="col-xl-6">
    <x-backEnd.input name="name" type="text" :required="true" :field="trans('account.Name')"/>
</div>

<div class="col-xl-6">
    <x-backEnd.input name="code" type="text" :required="false" :field="trans('account.Code')" :help="__('chart_of_account.Account code need to be unique, Leave blank for auto generate an unique account code')"/>
</div>

<div class="col-xl-6" id="account_type_col">
    <x-backEnd.select name="type" :required="true" :field="trans('account.Type')" :options="$account_types" :disabled="isset($chartOfAccount)" />
</div>

<div class="col-xl-12">
    <x-backEnd.textarea name="description" type="text" :required="false" :field="trans('common.description')" />
</div>

<div class="col-xl-6 mb-25" >
    <x-backEnd.select name="default_for" :required="false" :field="trans('account.Default for')" :options="$default_for" :help="trans('chart_of_account.Selecting a default Account, will remove previously default account for selected item')"/>
</div>
<div class="col-xl-6" >
    <x-backEnd.input name="opening_balance" type="number"  :required="false" :field="trans('account.Opening Balance')" />
</div>

@php
    $status = isset($chartOfAccount) ? $chartOfAccount->status : 1;
@endphp

<div class="col-xl-12">
    <x-backEnd.checkbox name="status" type="text" :required="false" :field="trans('common.active')" value="1"  :checked="$status"/>
</div>
