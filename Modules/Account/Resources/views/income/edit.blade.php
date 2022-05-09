<x-backEnd.modal.dialog :title="__('income.Edit Income')">
    @php
    $form_id = 'income_edit_form';
    @endphp

    {{ Form::model($transaction, ['route' => ['account.incomes.update', $transaction->id], 'id' => $form_id, 'method' =>
    'put' ]) }}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::income._components.form')

            <x-backEnd.modal.footer />
        </div>

    </x-backEnd.modal.body>

    {{ Form::close() }}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#income_modal', 'income-table')
</script>
