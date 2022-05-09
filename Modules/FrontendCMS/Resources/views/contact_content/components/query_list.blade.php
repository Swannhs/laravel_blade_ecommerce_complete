<div class="">
    <table class="table Crm_table_active3">
        <thead>
            <tr>
                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.name') }}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th class="w_160">{{ __('common.action') }}
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($QueryList as $key => $item)

                <tr>
                    <td>{{ $key +1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>

                        <label class="switch_toggle" for="checkbox{{ $item->id }}">
                            <input type="checkbox" id="checkbox{{ $item->id }}" {{$item->status?'checked':''}} value="{{$item->id}}" data-value="{{$item}}" class="statusChange" @if (!permissionCheck('frontendcms.query.status')) disabled @endif>
                            <div class="slider round"></div>
                        </label>
                    </td>

                    <td>

                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                @if (permissionCheck('frontendcms.query.update'))
                                    <a href="" data-value="{{ $item }}" class="dropdown-item edit_query">{{ __('common.edit') }}</a>
                                @endif
                                @if (permissionCheck('frontendcms.query.delete'))
                                    <a href="" class="dropdown-item delete_query" data-id="{{ $item->id }}">{{ __('common.delete') }}</a>
                                @endif
                            </div>
                        </div>

                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>
