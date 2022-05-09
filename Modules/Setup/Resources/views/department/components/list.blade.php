<div class="">
<!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>
                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.name') }}</th>
                <th scope="col">{{ __('common.details') }}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($DepartmentList as $key => $item)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->details }}</td>
                    <td>
                        <span class="{{$item->status == 1?'badge_1':'badge_2'}}">{{ showStatus($item->status) }}</span>
                    </td>
                    <td>
                        <!-- shortby  -->
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenu2" data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                @if(permissionCheck('departments.edit'))
                                <a href="" class="dropdown-item edit_department" data-value="{{ $item }}">{{__('common.edit')}}</a>
                                @endif

                                @if(permissionCheck('departments.delete'))
                                <a href="" class="dropdown-item delete_department" data-id="{{ $item->id }}">{{__('common.delete')}}</a>
                                @endif
                            </div>
                        </div>
                        <!-- shortby  -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
