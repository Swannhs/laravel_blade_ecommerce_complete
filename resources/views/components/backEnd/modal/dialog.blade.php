@props(['title' => null, 'size' => 'modal_800px'])
<div class="modal-dialog  {{ $size }}  modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ $title }}</h4>
            <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
        </div>

        {{ $slot }}
    </div>
</div>
