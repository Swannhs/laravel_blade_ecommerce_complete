<div class="">
    <!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>
                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.name') }}</th>
                <th scope="col">{{ __('common.email') }}</th>
                <th scope="col">{{ __('common.message') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ContactList as $key => $item)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ substr($item->message,0,50) }} .....</td>

                    <td>
                        @if (permissionCheck('contactrequest.contact.delete'))
                            <!-- shortby  -->
                            <div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenu2" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    {{ __('common.select') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a href="{{route('contactrequest.contact.show',$item->id)}}" class="dropdown-item edit_brand">{{ __('common.show') }}</a>
                                    <a href="#" class="dropdown-item edit_brand" onclick="showDeleteModal({{ $item->id }})">{{ __('common.delete') }}</a>
                                </div>
                            </div>
                            <!-- shortby  -->
                        @else
                            <button class="primary_btn_2" type="button">No Action Permitted</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
