@props(['icon' => false, 'title' => null])
<div class="card filterable">
    @if($title)
    <div class="card-header">
        <h3 class="card-title">
           @if($icon)
                <i class="{{ $icon }}"></i>
            @endif
           {{ $title }}
        </h3>
        <span class="float-right fnt_size txt_font">

            <i class="fa fa-fw ti-angle-up clickable"></i>
        </span>
    </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
