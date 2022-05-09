<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{ __('common.sl') }}</th>
            <th scope="col">{{ __('common.name') }}</th>
            <th scope="col">{{ __('common.type') }}</th>
            <th scope="col">{{ __('common.location') }}</th>
            <th scope="col">{{ __('common.status') }}</th>
            <th scope="col">{{ __('common.action') }}</th>
        </tr>
    </thead>
    <tbody id="mainTbody">

        @foreach($menus as $key => $menu)
        <tr data-id="{{$menu->id}}">
            <td>{{$key < 9?'0':''}}{{$key + 1}}</td>
            <td>{{$menu->name}}</td>
            <td class="text-nowrap">
                @if($menu->menu_type == 'mega_menu')
                {{__('menu.mega_menu')}}
                @elseif($menu->menu_type == 'multi_mega_menu')
                {{__('menu.multi_mega_menu')}}
                @elseif($menu->menu_type == 'normal_menu')
                {{__('menu.regular_menu')}}
                @endif
            </td>
            <td>
                @if($menu->menu_position == 'top_navbar')
                {{__('menu.top_navbar')}}
                @elseif($menu->menu_position == 'navbar')
                {{__('menu.navbar')}}
                @elseif($menu->menu_position == 'main_menu')
                {{__('menu.main_menu')}}
                @endif
            </td>

            <td>
                <label class="switch_toggle" for="checkbox_{{$menu->id}}">
                    <input type="checkbox" id="checkbox_{{$menu->id}}" {{$menu->status == 1?'checked':''}} @if (!permissionCheck('menu.status')) disabled @endif class="menu_status_change"  value="{{$menu->id}}" data-id="{{$menu->id}}">
                    <div class="slider round"></div>
                </label>
            </td>
            <td>

                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{ __('common.select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @if (permissionCheck('menu.setup'))
                            <a href="{{route('menu.setup',$menu->id)}}" class="dropdown-item setup_menu">{{__('common.setup')}}</a>
                        @endif
                        @if (permissionCheck('menu.edit'))
                            @if($menu->id > 2)
                            <a data-id="{{encrypt($menu->id)}}" class="dropdown-item edit_menu" >{{__('common.edit')}}</a>
                            @endif
                        @endif
                        @if (permissionCheck('menu.delete'))
                            @if($menu->id > 2)
                            <a data-id="{{$menu->id}}" class="dropdown-item delete_menu" >{{__('common.delete')}}</a>
                            @endif
                        @endif
                    </div>
                </div>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
