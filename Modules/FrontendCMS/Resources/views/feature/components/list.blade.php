<div class="">
<!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>

                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.title') }}</th>
                <th scope="col">{{ __('common.slug') }}</th>
                <th scope="col">{{ __('common.icon') }}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($FeatureList as $key => $item)
                <tr>

                    <th>{{ $key + 1 }}</th>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->slug }}</td>
                    <td><p><i class="{{ $item->icon }}"></i></p></td>
                    <td class="pending">{{ showStatus($item->status) }}</td>
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
                                @if(permissionCheck('frontendcms.features.update'))
                                    <a href="" class="dropdown-item edit_feature" data-id="{{ $item->id }}">{{__('common.edit')}}</a>
                                @endif
                                @if(permissionCheck('frontendcms.features.delete'))
                                    <a href="" class="dropdown-item delete_feature" data-id="{{ $item->id }}">{{__('common.delete')}}</a>
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
