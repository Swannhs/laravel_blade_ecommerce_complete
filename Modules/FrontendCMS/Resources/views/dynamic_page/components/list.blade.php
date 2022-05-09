<div class="">
    <!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>
                <th scope="col" width="10%">{{ __('common.sl') }}</th>
                <th scope="col" width="20%">{{ __('common.title') }}</th>
                <th scope="col" width="20%">{{ __('common.slug') }}</th>
                <th scope="col" width="20%">{{ __('common.page_link') }}</th>
                <th scope="col" width="15%">{{ __('common.status') }}</th>
                <th scope="col" width="15%">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pageList as $key => $item)
                @if($item->module == 'Lead')
                    @continue
                @endif
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->slug }}</td>
                    <td><a target="_blank" href="{{url('/'.$item->slug)}}">{{__('common.click_here')}}</a></td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $item->id }}">
                            <input type="checkbox" id="checkbox{{ $item->id }}" {{$item->status?'checked':''}} value="{{$item->id}}" data-value="{{$item}}" class="statusChange" @if (!permissionCheck('frontendcms.dynamic-page.status')) disabled @endif>
                            <div class="slider round"></div>
                        </label>
                    </td>
                    <td>
                        <!-- shortby  -->
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">

                                @if (permissionCheck('frontendcms.dynamic-page.update'))
                                    <a href="{{ route('frontendcms.dynamic-page.edit', $item->id) }}" class="dropdown-item edit_brand">{{ __('common.edit') }}</a>
                                @endif
                                @if (permissionCheck('frontendcms.dynamic-page.delete'))
                                    <a href="" class="dropdown-item delete_page" data-id="{{$item->id}}">{{ __('common.delete') }}</a>
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
