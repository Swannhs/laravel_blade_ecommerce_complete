@if (permissionCheck('account_module'))
@php
$chart_of_accounts = ['account.chart-of-accounts.index'];
$incomes = ['account.incomes.index'];
$expenses = ['account.expenses.index'];
$bank_accounts = ['account.bank-accounts.index','account.bank.statement'];
$nav = array_merge($chart_of_accounts, $incomes, $expenses, $bank_accounts, ['account.profit'], ['account.transaction'],
['account.statement']);
@endphp

<li class="{{ spn_nav_item_open($nav, 'mm-active') }} sortable_li"
    data-position="{{ menuManagerCheck(1,20)->position }}" data-status="{{ menuManagerCheck(1,20)->status }}">
    <a href="javascript:void(0);" class="has-arrow" aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
        <div class="nav_icon_small">
            <span class="fas fa-comment-dollar"></span>
        </div>
        <div class="nav_title">
            <span>{{ trans('account.Account') }}</span>
        </div>
    </a>
    <ul id="account-menu">
        @if (permissionCheck('account.chart-of-accounts.index') &&
        menuManagerCheck(2,20,'account.chart-of-accounts.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.chart-of-accounts.index')->position }}">
            <a href="{{ route('account.chart-of-accounts.index') }}" class="{{ spn_active_link($chart_of_accounts) }}"
                class="">
                {{ __('account.Chart Of Accounts') }}
            </a>
        </li>
        @endif
        @if (permissionCheck('account.bank-accounts.index') &&
        menuManagerCheck(2,20,'account.bank-accounts.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.bank-accounts.index')->position }}">
            <a href="{{ route('account.bank-accounts.index') }}" class="{{ spn_active_link($bank_accounts) }}" class="">
                {{ __('account.Bank Accounts') }}
            </a>
        </li>
        @endif

        @if (permissionCheck('account.incomes.index') && menuManagerCheck(2,20,'account.incomes.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.incomes.index')->position }}">
            <a href="{{ route('account.incomes.index') }}" class="{{ spn_active_link($incomes) }}" class="">
                {{ __('list.Income') }}
            </a>
        </li>
        @endif

        @if (permissionCheck('account.expenses.index') && menuManagerCheck(2,20,'account.expenses.index')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.expenses.index')->position }}">
            <a href="{{ route('account.expenses.index') }}" class="{{ spn_active_link($expenses) }}" class="">
                {{ __('account.Expenses') }}
            </a>
        </li>
        @endif

        @if (permissionCheck('account.profit') && menuManagerCheck(2,20,'account.profit')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.profit')->position }}">
            <a href="{{ route('account.profit') }}" class="{{ spn_active_link('account.profit') }}" class="">
                {{ __('account.Profit') }}
            </a>
        </li>
        @endif

        @if (permissionCheck('account.transaction_dtbl') && menuManagerCheck(2,20,'account.transaction')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.transaction')->position }}">
            <a href="{{ route('account.transaction') }}" class="{{ spn_active_link('account.transaction') }}" class="">
                {{ __('transaction.Transaction') }}
            </a>
        </li>
        @endif

        @if (permissionCheck('account.statement') && menuManagerCheck(2,20,'account.statement')->status == 1)
        <li data-position="{{ menuManagerCheck(2,20,'account.statement')->position }}">
            <a href="{{ route('account.statement') }}" class="{{ spn_active_link('account.statement') }}" class="">
                {{ __('transaction.Statement') }}
            </a>
        </li>
        @endif
    </ul>
</li>

@endif
