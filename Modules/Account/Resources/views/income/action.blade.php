<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('account.incomes.edit'))
            <a href="{{ route('account.incomes.edit', $model->id) }}" class="dropdown-item btn-modal"
               data-href="{{ route('account.incomes.edit', $model->id) }}"
               data-container="income_modal">{{__('common.edit')}}</a>
        @endif

        @if (permissionCheck('account.incomes.destroy'))
            <a href="{{ route('account.incomes.destroy', $model->id) }}" class="dropdown-item delete_item"
               data-href="{{ route('account.incomes.destroy', $model->id) }}">{{__('common.delete')}}</a>
        @endif
    </div>
</div>
