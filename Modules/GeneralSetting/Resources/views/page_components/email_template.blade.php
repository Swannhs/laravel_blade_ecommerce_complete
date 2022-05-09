
<div class="main-title d-md-flex">
    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.Email Template')}}</h3>
    <ul class="d-flex">
        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href=""><i class="ti-plus"></i>{{ __('general_settings.add_new_template') }}</a></li>
    </ul>
</div>
<div class="common_QA_section QA_section_heading_custom">
    <div class="QA_table ">
        <!-- table-responsive -->
        <div class="">
            <table class="table Crm_table_active2">
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
                    @foreach ($email_templates as $key => $email_template)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ strtoupper(str_replace("_"," ",$email_template->email_template_type->type)) }}</td>
                            <td>{{ $email_template->subject }}</td>
                            <td>{{ $email_template->reciepnt_type }}</td>
                            <td class="text-right">
                                <label class="switch_toggle" for="checkbox{{ $email_template->id }}">
                                    <input type="checkbox" id="checkbox{{ $email_template->id }}" @if ($email_template->is_active == 1) checked @endif value="{{ $email_template->id }}">
                                    <div class="slider round"></div>
                                </label>
                            </td>
                            <td>
                                <a class="primary_btn_2" type="button">{{ __('general_settings.manage') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
