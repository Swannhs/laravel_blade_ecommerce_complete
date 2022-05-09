<div class="main-title">
    <h3 class="mb-30">
        {{__('menu.edit_menu')}} </h3>
</div>

<form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" id="edit_form">

    <div class="white-box">
        <div class="add-visitor">
            <div class="row">

                <div class="col-lg-12">
                    <input type="hidden" id="id" name="id" value="{{$item->id}}" />
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="name">
                            {{__('common.name')}}
                            <span class="text-danger">*</span>
                        </label>
                        <input class="primary_input_field name" type="text" id="name" name="name" value="{{$item->name}}" autocomplete="off"  placeholder="{{__('common.name')}}">
                    </div>
                    <span class="text-danger" id="error_name"></span>
                </div>

                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="slug">
                           {{__('common.slug')}}
                            <span class="text-danger">*</span>
                        </label>
                        <input class="primary_input_field slug" type="text" id="slug" name="slug" value="{{$item->slug}}" autocomplete="off" placeholder="{{__('common.slug')}}" required>
                    </div>
                    <span class="text-danger"  id="error_slug"></span>
                </div>

                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="icon">
                           {{__('common.icon')}} ({{__('menu.use_themefy_or_fontawesome_icon')}})
                        </label>
                        <input class="primary_input_field icp" type="text" id="icon" name="icon" value="{{$item->icon}}" autocomplete="off" placeholder="ti-briefcase">
                    </div>
                    <span class="text-danger"  id="error_icon"></span>
                </div>



                 <div class="col-xl-12">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="status" id="status_active" value="1" {{$item->status == 1?'checked':''}} class="active"
                                        type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="status" value="0" id="status_inactive" {{$item->status == 0?'checked':''}} class="de_active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="error_status"></span>
                    </div>
                </div>



                <div class="form-group col-xl-12 in_parent_div " id="menu_type_div">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for="">{{ __('menu.menu_type') }} <span class="text-danger">*</span></label>
                        <select name="menu_type" id="menu_type" class="primary_select mb-15" disabled>
                            <option data-display="{{__('menu.select_menu_type')}}" value="">{{__('menu.select_menu_type')}}</option>
                            <option {{$item->menu_type == 'multi_mega_menu'?'selected':''}} value="multi_mega_menu">{{__('menu.multi_mega_menu')}}</option>
                            <option {{$item->menu_type == 'mega_menu'?'selected':''}} value="mega_menu">{{__('menu.mega_menu')}}</option>
                            <option {{$item->menu_type == 'normal_menu'?'selected':''}} value="normal_menu">{{__('menu.normal_menu')}}</option>
                        </select>
                        <span class="text-danger" id="error_menu_type"></span>
                    </div>
                </div>

                <div class="form-group col-xl-12 in_parent_div " id="display_position_div">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for="">{{ __('menu.display_location') }} <span class="text-danger">*</span></label>
                        <select name="menu_position" id="menu_position" class="primary_select mb-15">
                            <option data-display="{{__('menu.select_display_location')}}" value="">{{__('menu.select_display_location')}}</option>
                            <option {{ $item->menu_position == 'main_menu'?'selected':'' }} value="main_menu">{{__('menu.main_menu')}}</option>
                            <option {{ $item->menu_position == 'top_navbar'?'selected':'' }} value="top_navbar">{{__('menu.top_bar')}}</option>            
                        </select>
                        <span class="text-danger" id="error_menu_position"></span>
                    </div>
                </div>



            </div>

                <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button id="create_btn" type="submit" class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip" title=""
                                data-original-title="">
                                <span class="ti-check"></span>
                                {{__('common.update')}} </button>
                        </div>
                </div>
        </div>
    </div>
</form>

