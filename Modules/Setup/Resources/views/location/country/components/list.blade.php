<div class="">
    <table class="table Crm_table_active3">
        <thead>
            <tr>

                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.name') }}</th>
                <th scope="col">{{ __('setup.code') }}</th>
                <th scope="col">{{ __('setup.flag') }}</th>
                <th scope="col">{{ __('setup.phonecode') }}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($countries as $key => $country)
                <tr>

                    <th>{{ $key + 1 }}</th>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->code }}</td>
                    <td>
                        <div class="list_flag_div">
                            <img class="list_flag" src="{{ showImage($country->flag ? $country->flag : 'flags/no_image.png') }}"
                            alt="">
                        </div>
                    </td>
                    <td>{{ $country->phonecode }}</td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $country->id }}">
                            <input type="checkbox" id="checkbox{{ $country->id }}" data-id="{{ $country->id }}" @if(permissionCheck('setup.country.status')) class="status_change" {{ $country->status ? 'checked' : '' }} value="{{ $country->id }}" @else disabled @endif>
                            <div class="slider round"></div>
                        </label>
                    </td>
                    <td>
                        @if (permissionCheck('setup.country.update'))
                            <div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('common.select') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a href="" class="dropdown-item edit_country" data-id="{{ $country->id }}">{{ __('common.edit') }}</a>
                                </div>
                            </div>
                        @else
                            <button class="primary_btn_2" type="button">{{ __('common.no_action_permitted') }}</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
