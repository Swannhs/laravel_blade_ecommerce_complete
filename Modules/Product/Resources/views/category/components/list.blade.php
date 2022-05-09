<div class="row">
    <div class="col-lg-12">
        <table class="table Crm_table_active3">
            <thead>
                <tr>
                    <th scope="col">{{ __('common.id') }}</th>
                    <th scope="col">{{ __('common.name') }}</th>
                    <th scope="col">{{ __('product.parent_category') }}</th>
                    @if(isModuleActive('MultiVendor'))
                    <th scope="col">{{ __('common.commission_rate') }}</th>
                    @endif
                    <th scope="col">{{ __('common.status') }}</th>
                    <th scope="col">{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach($CategoryList as $key => $item)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->parentCategory? $item->parentCategory->name:'Parent'}}</td>
                    @if(isModuleActive('MultiVendor'))
                    <td>{{ $item->commission_rate }} %</td>
                    @endif
                    <td><span class="{{$item->status==1?'badge_1':'badge_2'}}">{{ showStatus($item->status) }}</span></td>
                    <td>
                        <!-- shortby  -->
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                <a data-value="{{$item}}" class="dropdown-item show_category">{{ __('common.show') }}</a>
                                @if (permissionCheck('product.category.edit'))
                                    <a class="dropdown-item edit_category" data-id="{{$item->id}}">{{__('common.edit')}}</a>
                                @endif
                                @if (permissionCheck('product.category.delete'))
                                    <a class="dropdown-item delete_brand" data-id="{{$item->id}}">{{__('common.delete')}}</a>
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
</div>
