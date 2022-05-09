<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('account.bank.statement'))
        <a href="{{ route('account.bank.statement', $model->id) }}"

        class="dropdown-item">{{__('transaction.Account History')}}</a>
        @endif
        @if (permissionCheck('account.bank-accounts.edit'))
        <a href="{{ route('account.bank-accounts.edit', $model->id) }}" class="dropdown-item btn-modal"
            data-href="{{ route('account.bank-accounts.edit', $model->id) }}"
            data-container="bank_account_modal">{{__('common.edit')}}</a>
        @endif
        @if (permissionCheck('account.bank-accounts.destroy'))
        <a href="{{ route('account.bank-accounts.destroy', $model->id) }}" class="dropdown-item delete_item"
            data-href="{{ route('account.bank-accounts.destroy', $model->id) }}">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
