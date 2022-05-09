<x-backEnd.modal.dialog :title="__('expense.Edit Expense')">
    @php
    $form_id = 'expense_edit_form';
    @endphp

    {{ Form::model($transaction, ['route' => ['account.expenses.update', $transaction->id], 'id' => $form_id, 'method'
    => 'put' ]) }}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::expense._components.form')

            <x-backEnd.modal.footer />
        </div>

    </x-backEnd.modal.body>

    {{ Form::close() }}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#expense_modal', 'expense-table')
</script>
