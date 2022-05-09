<x-backEnd.modal.dialog :title="__('chart_of_account.Edit Account')">
    @php
    $form_id = 'bank_account_edit_form';
    @endphp

    {{Form::model($bankAccount, ['route' => ['account.bank-accounts.update', $bankAccount->id], 'id' => $form_id,
    'method' => 'put' ])}}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::bank_account._components.form')

            <x-backEnd.modal.footer />
        </div>

    </x-backEnd.modal.body>

    {{Form::close()}}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#bank_account_modal', 'bank-account-table')
</script>
