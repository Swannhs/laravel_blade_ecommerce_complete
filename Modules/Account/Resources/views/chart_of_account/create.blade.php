<x-backEnd.modal.dialog :title="__('chart_of_account.New Account')">
    @php
        $form_id = 'chart_of_account_form';
    @endphp

    {{Form::open(['route' => 'account.chart-of-accounts.store', 'id' => $form_id ])}}
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
