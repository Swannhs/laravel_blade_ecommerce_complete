<x-backEnd.modal.dialog :title="__('chart_of_account.Edit Account')">
    @php
        $form_id = 'chart_of_account_edit_form';
    @endphp

    {{Form::model($chartOfAccount, ['route' => ['account.chart-of-accounts.update', $chartOfAccount->id], 'id' => $form_id, 'method' => 'put' ])}}
    <x-backEnd.modal.body>

        <div class="row">
            @includeIf('account::chart_of_account._components.form')

            <x-backEnd.modal.footer/>
        </div>

    </x-backEnd.modal.body>

    {{Form::close()}}
</x-backEnd.modal.dialog>

<script>
    _formValidation('{{ $form_id }}', '#chart_of_account_modal', 'chart-of-account-table')
</script>
