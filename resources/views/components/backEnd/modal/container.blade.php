@props(['id' => 'remote_modal'])
<div class="modal animated rotateInDownLeft {{ $id }} " id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
    {{ $slot }}
</div>
