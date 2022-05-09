@if (permissionCheck('shipping_methods.index') && menuManagerCheck(2,18,'shipping_methods.index')->status == 1)
    <li data-position="{{ menuManagerCheck(2,18,'shipping_methods.index')->position }}">
        <a href="{{route('shipping_methods.index')}}" @if (request()->is('setup/shipping-methods')) class="active" @endif>{{ __('shipping.shipping_method') }}</a>
    </li>
@endif
