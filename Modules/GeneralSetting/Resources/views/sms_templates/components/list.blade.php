<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{__('common.sl')}}</th>
            <th scope="col">{{ __('common.type') }}</th>
            <th scope="col">{{ __('general_settings.subject') }}</th>
            <th scope="col">{{ __('general_settings.reciepent') }}</th>
            <th scope="col">{{ __('general_settings.activate') }}</th>
            <th scope="col">{{ __('common.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sms_templates as $key => $sms_template)
            @if(!$sms_template->module or isModuleActive($sms_template->module))
            <tr>
                <td>{{ $key+1 }}</td>
                <td>
                    {{ strtoupper(str_replace("_"," ",$sms_template->templateType->type)) }}
                </td>
                <td>{{ $sms_template->subject }}</td>
                <td>
                    @if ($sms_template->reciepnt_type)
                        @foreach (json_decode($sms_template->reciepnt_type) as $k => $reciepnt)
                            {{ (count(json_decode($sms_template->reciepnt_type)) == 2 && $k == 1) ? '&' : '' }} {{ $reciepnt }}
                        @endforeach
                    @endif
                </td>
                <td>
                    <label class="switch_toggle" for="checkbox{{ $sms_template->id }}">
                        <input type="checkbox" id="checkbox{{ $sms_template->id }}" @if ($sms_template->is_active == 1) checked @endif @if (permissionCheck('')) value="{{ $sms_template->id }}" class="checkbox" @endif>
                        <div class="slider round"></div>
                    </label>
                </td>
                <td>
                    <a class="primary-btn radius_30px mr-10 fix-gr-bg a_btn" href="{{ route('sms_templates.manage', $sms_template->id) }}">{{ __('general_settings.manage') }}</a>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>