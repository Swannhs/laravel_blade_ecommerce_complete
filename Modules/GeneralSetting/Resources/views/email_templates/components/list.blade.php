<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{__('common.sl')}}</th>
            <th scope="col">{{ __('general_settings.subject') }}</th>
            <th scope="col">{{ __('common.type') }}</th>
            <th scope="col">{{ __('general_settings.reciepent') }}</th>
            <th scope="col">{{ __('general_settings.activate') }}</th>
            <th scope="col">{{ __('common.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($email_templates as $key => $email_template)
            @if(!$email_template->module or isModuleActive($email_template->module))
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $email_template->subject }}</td>
                    <td>
                        {{ ucwords(str_replace("_"," ",$email_template->email_template_type->type)) }}
                        @if ($email_template->relatable_type != null)
                            ({{ $email_template->relatable->name }})
                        @endif
                    </td>
                    <td>
                        @if ($email_template->reciepnt_type)
                            @foreach (json_decode($email_template->reciepnt_type) as $k => $reciepnt)
                                {{ (count(json_decode($email_template->reciepnt_type)) == 2 && $k == 1) ? '&' : '' }} {{ $reciepnt }}
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $email_template->id }}">
                            <input type="checkbox" id="checkbox{{ $email_template->id }}" @if ($email_template->is_active == 1) checked @endif @if (permissionCheck('')) value="{{ $email_template->id }}" class="checkbox" @endif>
                            <div class="slider round"></div>
                        </label>
                    </td>
                    <td>
                        <a class="primary-btn radius_30px mr-10 fix-gr-bg a_btn" href="{{ route('email_templates.manage', $email_template->id) }}">{{ __('general_settings.manage') }}</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>