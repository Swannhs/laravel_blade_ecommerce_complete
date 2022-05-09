@props(['datatable' => null])
@php
$modal_id= 'delete_modal';
$form_id= 'delete_modal_form';
@endphp
<x-backEnd.modal.container :id="$modal_id" >
    <x-backEnd.modal.dialog :title="__('common.Delete Confirmation')" size="">

        @php echo Form::open(['method' => 'delete', 'id' => $form_id]); @endphp
        <x-backEnd.modal.body>
            <div class="row">
                <div class="col-12 text-danger font-weight-bold">
                    {{ __('common.are_you_sure_to_delete_?') }}
                </div>
                <x-backEnd.modal.footer action="delete"/>
            </div>

        </x-backEnd.modal.body>

        @php echo Form::close(); @endphp
    </x-backEnd.modal.dialog>

</x-backEnd.modal.container>

@push('scripts_after')
<script>
    _formValidation('{{ $form_id }}', '#{{ $modal_id }}', '{{ $datatable }}')
</script>
@endpush
