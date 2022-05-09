@if (permissionCheck('frontendcms.widget.index') || permissionCheck('frontendcms.features.index') || permissionCheck('frontendcms.merchant-content.index') || permissionCheck('frontendcms.pricing.index') ||permissionCheck('frontendcms.return-exchange.index') || permissionCheck('frontendcms.contact-content.index') || permissionCheck('frontendcms.static-page.index')|| permissionCheck('footerSetting.footer.index') || permissionCheck('frontendcms.subscribe-content.index') || permissionCheck('frontendcms.about-us.index') || permissionCheck('frontendcms.title_index'))
    @php
        $frontend_cms = false;

        if(request()->is('frontendcms/*') || request()->is('footer/footer-setting'))
        {
            $frontend_cms = true;
        }
    @endphp
<li class="{{ $frontend_cms ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,2)->position }}" data-status="{{ menuManagerCheck(1,2)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $frontend_cms ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-user"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('frontendCms.frontend_cms') }}</span>
        </div>
    </a>
    <ul id="frontend_cms">
        @if (permissionCheck('frontendcms.widget.index') && menuManagerCheck(2,2,'frontendcms.widget.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.widget.index')->position }}">
                <a href="{{ route('frontendcms.widget.index') }}" class="{{request()->is('frontendcms/homepage') ? 'active' : ''}}">{{ __('frontendCms.home_page') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontendcms.features.index') && menuManagerCheck(2,2,'frontendcms.features.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.features.index')->position }}">
                <a href="{{ route('frontendcms.features.index') }}" class="{{request()->is('frontendcms/features') ? 'active' : ''}}">{{ __('frontendCms.features') }}</a>
            </li>
        @endif
        
        @if (permissionCheck('frontendcms.merchant-content.index') && menuManagerCheck(2,2,'frontendcms.merchant-content.index')->status == 1 && isModuleActive('MultiVendor'))
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.merchant-content.index')->position }}">
                <a href="{{ route('frontendcms.merchant-content.index') }}" class="{{request()->is('frontendcms/merchant-content') ? 'active' : ''}}">{{ __('frontendCms.merchant_content') }}</a>
            </li>
        @endif

        @if (permissionCheck('frontendcms.return-exchange.index') && menuManagerCheck(2,2,'frontendcms.return-exchange.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.return-exchange.index')->position }}">
                <a href="{{ route('frontendcms.return-exchange.index') }}" class="{{request()->is('frontendcms/return-exchange') ? 'active' : ''}}">{{ __('frontendCms.return_exchange') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontendcms.contact-content.index') && menuManagerCheck(2,2,'frontendcms.contact-content.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.contact-content.index')->position }}">
                <a href="{{ route('frontendcms.contact-content.index') }}" class="{{request()->is('frontendcms/contact-content') ? 'active' : ''}}">{{ __('frontendCms.contact_content') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontendcms.dynamic-page.index') && menuManagerCheck(2,2,'frontendcms.dynamic-page.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.dynamic-page.index')->position }}">
                <a href="{{ route('frontendcms.dynamic-page.index') }}" class="{{request()->is('frontendcms/dynamic-page') ? 'active' : ''}}">{{ __('frontendCms.dynamic_pages') }}</a>
            </li>
        @endif
        @if (permissionCheck('footerSetting.footer.index') && menuManagerCheck(2,2,'footerSetting.footer.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'footerSetting.footer.index')->position }}">
                <a href="{{ route('footerSetting.footer.index') }}" class="{{request()->is('footer/footer-setting') ? 'active' : ''}}">{{ __('frontendCms.footer_setting') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontendcms.subscribe-content.index') && menuManagerCheck(2,2,'frontendcms.subscribe-content.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.subscribe-content.index')->position }}">
                <a href="{{ route('frontendcms.subscribe-content.index') }}" class="{{request()->is('frontendcms/subscribe-content') ? 'active' : ''}}">{{ __('frontendCms.subscription') }}</a>
            </li>
        @endif

        @if (permissionCheck('frontendcms.popup-content.index') && menuManagerCheck(2,2,'frontendcms.popup-content.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.subscribe-content.index')->position }}">
                <a href="{{ route('frontendcms.popup-content.index') }}" class="{{request()->is('frontendcms/popup-content') ? 'active' : ''}}">{{ __('frontendCms.popup_content') }}</a>
            </li>
        @endif

        @if (permissionCheck('frontendcms.about-us.index') && menuManagerCheck(2,2,'frontendcms.about-us.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.about-us.index')->position }}">
                <a href="{{ route('frontendcms.about-us.index') }}" class="{{request()->is('frontendcms/about-us') ? 'active' : ''}}">{{ __('frontendCms.about_us') }}</a>
            </li>
        @endif
        @if (permissionCheck('frontendcms.title_index') && menuManagerCheck(2,2,'frontendcms.title_index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,2,'frontendcms.title_index')->position }}">
                <a href="{{ route('frontendcms.title_index') }}" class="{{request()->is('frontendcms/title-setting') ? 'active' : ''}}">{{ __('frontendCms.related_sale_setting') }}</a>
            </li>
        @endif
    </ul>
</li>
@endif
