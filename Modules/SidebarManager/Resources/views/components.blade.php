
@if(permissionCheck($Module->route))
    <div class="single_role_blocks">
        <div class="single_permission" id="{{ $Module->module_id }}">
            <div class="permission_header d-flex align-items-center justify-content-between">
                <div>
                    <input type="hidden" name="menu_positions[]" class="menu_positions" value="{{ $Module->position }}">
                    <input type="hidden" name="module_id[]" value="{{ $Module->module_id }}">
                    <input type="hidden" class="status" name="status[]" value="{{ $Module->status }}">
                    <input type="checkbox" name="menu_status[]" value="{{ $Module->status }}"
                           id="Main_Module_{{ $key }}"
                           class="common-radio permission-checkAll main_module_id_{{ $Module->module_id }}"  {{ $Module->status == 1 ? 'checked' : '' }} >
                    <label for="Main_Module_{{ $key }}" data-sidebar="{{ $Module->sidebar_id }}">{{ $Module->name }}</label>
                </div>
                <div class="arrow collapsed" data-toggle="collapse" data-target="#Role{{ $Module->sidebar_id }}"></div>
            </div>

            <div id="Role{{ $Module->sidebar_id }}" class="collapse">

                <div class="permission_body">
                    <ul class="submenuSort">
                        @foreach ($SubMenuList->where('parent_id',$Module->sidebar_id) as $SubMenu)
                        
                        @if(!$SubMenu->module or isModuleActive($SubMenu->module))
                            @if(permissionCheck($SubMenu->route))
                            <li class="sub_menu_li">
                                <div class="submodule">
                                    <input type="hidden" name="sub_positions[]" class="sub_positions"
                                           value="{{ $SubMenu->position }}">
                                    <input name="sub_module_id[]"
                                           value="{{ $SubMenu->sidebar_id }}" type="hidden">
                                    <input name="sub_status[]" class="sub_status"
                                           value="{{ $SubMenu->status }}" type="hidden">
                                    <input id="Sub_Module_{{ $SubMenu->sidebar_id }}" name="sub_menu_status[]"
                                           value="{{ $SubMenu->status }}"
                                           class="infix_csk common-radio  module_id_{{ $SubMenu->module_id }} module_link"
                                           {{ $SubMenu->status == 1 ? 'checked' : '' }}  type="checkbox">

                                    <label for="Sub_Module_{{ $SubMenu->sidebar_id }}">@if($SubMenu->name == 'Seller Reviews') @if(isModuleActive('MultiVendor')) {{ $SubMenu->name }} @else Company Reviews @endif @else {{ $SubMenu->name }} @endif</label>
                                    <br>
                                </div>
                                
                            </li>
                            @endif
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
