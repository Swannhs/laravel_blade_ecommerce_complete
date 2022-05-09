@if (permissionCheck('generalsetting.index') || permissionCheck('email_templates.index'))
    @php
        $general_admin = false;
        if(request()->is('generalsetting') || request()->is('generalsetting/*') || request()->is('modulemanager'))
        {
            $general_admin = true;
        }
    @endphp
    <li class="{{ $general_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,16)->position }}" data-status="{{ menuManagerCheck(1,16)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $general_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-cog"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('general_settings.system_settings') }}</span>
            </div>
        </a>
        <ul id="general_setting_1">
            @if(isModuleActive('AmazonS3'))
            <li>
                <a href="{{ route('file-storage.index') }}" class="{{request()->routeIs('file-storage.index') ? 'active' : ''}}">
                    {{ __('general_settings.file_storage') }}
                    @if (config('app.sync'))
                    <span class="demo_addons">Addon</span>
                    @endif
                </a>
            </li>
            @endif
            @if (permissionCheck('generalsetting.index') && menuManagerCheck(2,16,'generalsetting.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'generalsetting.index')->position }}">
                    <a href="{{ route('generalsetting.index') }}" @if (request()->is('generalsetting')) class="active" @endif>{{ __('general_settings.general_settings') }}</a>
                </li>
            @endif
            @if (permissionCheck('email_templates.index') && menuManagerCheck(2,16,'email_templates.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'email_templates.index')->position }}">
                    <a href="{{ route('email_templates.index') }}" @if (request()->is('generalsetting/email-templates*')) class="active" @endif>{{__('general_settings.Email Template')}}</a>
                </li>
            @endif
            @if (permissionCheck('sms_templates.index') && menuManagerCheck(2,16,'sms_templates.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'sms_templates.index')->position }}">
                    <a href="{{ route('sms_templates.index') }}" @if (request()->is('generalsetting/sms-templates*')) class="active" @endif>{{__('common.sms')}} {{__('general_settings.template')}}</a>
                </li>
            @endif
            @if (permissionCheck('company_info') && menuManagerCheck(2,16,'company_info')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'company_info')->position }}">
                    <a href="{{ route('generalsetting.company_index') }}" @if (request()->is('generalsetting/company-info')) class="active" @endif>{{__('general_settings.company_information')}}</a>
                </li>
            @endif
            @if (permissionCheck('smtp_info') && menuManagerCheck(2,16,'smtp_info')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'smtp_info')->position }}">
                    <a href="{{ route('generalsetting.smtp_index') }}" @if (request()->is('generalsetting/smtp-setting')) class="active" @endif>{{ __('general_settings.email_settings') }}</a>
                </li>
            @endif
            @if (permissionCheck('sms_info') && menuManagerCheck(2,16,'sms_info')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'sms_info')->position }}">
                    <a href="{{ route('generalsetting.sms_index') }}" @if (request()->is('generalsetting/sms-setting')) class="active" @endif>{{ __('general_settings.sms_settings') }}</a>
                </li>
            @endif
            @if (permissionCheck('setup.analytics.index') && menuManagerCheck(2,16,'setup.analytics.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'setup.analytics.index')->position }}">
                    <a href="{{ route('setup.analytics.index') }}" @if (request()->is('generalsetting/analytics')) class="active" @endif>{{__('setup.analytics')}}</a>
                </li>
            @endif
            @if (permissionCheck('generalsetting.activation_index') && menuManagerCheck(2,16,'generalsetting.activation_index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'generalsetting.activation_index')->position }}">
                    <a href="{{ route('generalsetting.activation_index') }}" @if (request()->is('generalsetting/activation')) class="active" @endif>{{ __('general_settings.activation') }}</a>
                </li>
            @endif
            {{-- Notification Setting --}}
            @if (permissionCheck('notificationsetting.index') && menuManagerCheck(2,16,'notificationsetting.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'notificationsetting.index')->position }}">
                    <a href="{{ route('notificationsetting.index') }}" @if (request()->is('generalsetting/notification')) class="active" @endif>{{ __('common.notification') }} {{ __('common.setting') }}</a>
                </li>
            @endif

            @if (permissionCheck('generalsetting.social_login_configuration') && menuManagerCheck(2,16,'generalsetting.social_login_configuration')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'generalsetting.social_login_configuration')->position }}">
                    <a href="{{ route('generalsetting.social_login_configuration') }}" @if (request()->is('generalsetting/social_login_configuration')) class="active" @endif>
                        {{ __('general_settings.social_configuration') }}</a>
                </li>
            @endif

            @if (permissionCheck('maintenance.index') && menuManagerCheck(2,16,'maintenance.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'maintenance.index')->position }}">
                    <a href="{{ route('maintenance.index') }}" @if (request()->is('generalsetting/maintenance-mode')) class="active" @endif>{{ __('general_settings.maintenance') }} {{ __('general_settings.mode') }}</a>
                </li>
            @endif

            @if (permissionCheck('generalsetting.updatesystem') && menuManagerCheck(2,16,'generalsetting.updatesystem')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'generalsetting.updatesystem')->position }}">
                    <a href="{{ route('generalsetting.updatesystem') }}" @if (request()->is('generalsetting/update-system')) class="active" @endif>{{ __('general_settings.about_update') }}</a>
                </li>
            @endif

            @if (permissionCheck('modulemanager.index') && menuManagerCheck(2,16,'modulemanager.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,16,'modulemanager.index')->position }}">
                    <a href="{{ route('modulemanager.index') }}" @if (request()->is('modulemanager')) class="active" @endif>{{ __('general_settings.module') }} {{__('general_settings.manager')}}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
