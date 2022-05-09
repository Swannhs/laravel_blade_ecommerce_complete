<x-backEnd.modal.dialog :title="__('expense.New Expense')">
    @php
    $form_id = 'expense_form';
    @endphp

    {{Form::open(['route' => 'account.expenses.store', 'id' => $form_id ])}}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::expense._components.form')

            <x-backEnd.modal.footer />
        </div>

    </x-backEnd.modal.body>

    {{Form::close()}}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#expense_modal', 'expense-table')
</script>
