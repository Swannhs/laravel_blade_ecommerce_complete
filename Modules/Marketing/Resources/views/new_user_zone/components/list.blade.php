
<div class="">
    <!-- table-responsive -->
    <table class="table Crm_table_active3">
        <thead>
            <tr>
                <th scope="col">{{ __('common.sl') }}</th>
                <th scope="col">{{ __('common.title') }}</th>
                <th scope="col" width="20%">{{ __('common.banner') }}</th>
                <th scope="col">{{ __('common.page') }} {{__('common.link')}}</th>
                <th scope="col">{{ __('common.status') }}</th>
                <th scope="col">{{ __('common.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ZoneList as $key => $zone)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $zone->title }}</td>
                <td>
                    <div class="banner_img_div">
                        @if ($zone->banner_image != null)
                        <img src="{{showImage($zone->banner_image)}}" alt="{{$zone->banner_image}}">
                        @else
                        <img src="{{showImage('backend/img/default.png')}}" alt="">
                        @endif
                    </div>
                </td>
                <td><a target="_blank" href="{{url('new-user-zone/'.$zone->slug)}}">{{$zone->slug}}</a></td>
                <td>
                    <label class="switch_toggle" for="checkbox_{{ $zone->id }}">
                        <input type="checkbox" id="checkbox_{{ $zone->id }}" {{$zone->status?'checked':''}} @if(permissionCheck('marketing.new-user-zone.status')) value="{{$zone->id}}"
                        data-id="{{$zone->id}}" class="changeStatus" @endif>
                        <div class="slider round"></div>
                    </label>
                </td>
                <td>
                    @if (permissionCheck('marketing.new-user-zone.edit') ||
                    permissionCheck('marketing.new-user-zone.delete'))
                    <!-- shortby  -->
                    <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('common.select') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                            @if (permissionCheck('marketing.new-user-zone.edit'))
                            <a href="{{ route('marketing.new-user-zone.edit', $zone->id) }}"
                                class="dropdown-item edit_brand">{{ __('common.edit') }}</a>
                            @endif
                            @if (permissionCheck('marketing.new-user-zone.delete'))
                            <a href="javascript:void(0)" class="dropdown-item delete_zone" data-id="{{$zone->id}}">{{
                                __('common.delete') }}</a>
                            @endif
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
