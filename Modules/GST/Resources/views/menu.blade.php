@if (permissionCheck('gst_setup'))
    @php
        $gst_admin = false;
        if(request()->is('gst-setup/*'))
        {
            $gst_admin = true;
        }
    @endphp
    <li class="{{ $gst_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,19)->position }}" data-status="{{ menuManagerCheck(1,19)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $gst_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-wrench"></span>
            </div>
            <div class="nav_title">
                <span>{{__('gst.gst_setup')}}</span>
            </div>
        </a>
        <ul id="gst_ul">
            @if (permissionCheck('gst_tax.index') && menuManagerCheck(2,19,'gst_tax.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,19,'gst_tax.index')->position }}">
                    <a href="{{ route('gst_tax.index') }}" @if (request()->is('gst-setup/gst')) class="active" @endif>{{__('gst.gst_list')}}</a>
                </li>
            @endif

            @if (permissionCheck('gst_tax.configuration_index') && menuManagerCheck(2,19,'gst_tax.configuration_index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,19,'gst_tax.configuration_index')->position }}">
                    <a href="{{ route('gst_tax.configuration_index') }}" @if (request()->is('gst-setup/gst/configuration')) class="active" @endif>{{__('gst.configuration')}}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
