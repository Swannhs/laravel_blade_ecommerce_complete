<x-backEnd.modal.dialog :title="__('bank_account.New Account')">
    @php
    $form_id = 'bank_account_form';
    @endphp

    {{Form::open(['route' => 'account.bank-accounts.store', 'id' => $form_id ])}}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::bank_account._components.form')

            <x-backEnd.modal.footer />
        </div>

    </x-backEnd.modal.body>

    {{ Form::close() }}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#bank_account_modal', 'bank-account-table')
</script>
