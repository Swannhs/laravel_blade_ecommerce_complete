<x-backEnd.modal.dialog :title="__('income.New Income')">
    @php
    $form_id = 'income_form';
    @endphp

    {{ Form::open(['route' => 'account.incomes.store', 'id' => $form_id ]) }}
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
