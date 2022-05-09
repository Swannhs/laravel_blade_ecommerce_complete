@if (count(@$menu->rightPanelData) > 0)
    @foreach (@$menu->rightPanelData as $key => $element)
        <div class="col-lg-12 single_item" data-id="{{ $element->id }}">
            <div class="mb-10">
                <div class="card" id="accordion_right_{{ $element->id }}">
                    <div class="card-header card_header_element">
                        <p class="d-inline">
                            {{ @$element->title }}
                        </p>
                        <a href="" data-id="{{ $element->id }}" class="pull-right d-inline primary-btn right_panel_category_delete_btn"><i class="ti-close"></i></a>
                        <a href="javascript:void(0);" onclick="" class="pull-right d-inline  mr-10 primary-btn"
                            data-toggle="collapse" data-target="#collapse_right_{{ $element->id }}" aria-expanded="true"
                            aria-controls="collapse_right_{{ $element->id }}">{{__('common.edit')}}</a>

                    </div>
                    <div id="collapse_right_{{ $element->id }}" class="collapse"
                        aria-labelledby="heading_right_{{ $element->id }}" data-parent="#accordion_right_{{ $element->id }}">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="rightPanelDataEditForm">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $element->id }}">

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="title">
                                                {{ __('marketing.navigation_label') }} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field title" type="text" name="title"
                                                autocomplete="off" value="{{ $element->title }}"
                                                placeholder="{{ __('marketing.navigation_label') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                for="">{{ __('common.category') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="category"
                                                class="primary_select mb-15 right_category">
                                                @foreach ($categories->where('parent_id', 0) as $key => $category)
                                                    <option {{$element->category_id == $category->id?'selected':''}} value="{{ $category->id }}"><span>-></span> {{ $category->name }}</option>
                                                    @if(count($category->subCategories) > 0)
                                                        @foreach($category->subCategories as $subItem)
                                                            @include('menu::menu.components._category_select_option',['subItem' => $subItem, 'element' => $element])    
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="primary_input">
                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                <li>
                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                        <input name="is_newtab" value="1"
                                                            {{ $element->is_newtab == 1 ? 'checked' : '' }}
                                                            type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p>{{ __('menu.open_link_in_a_new_tab') }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="submit" class="primary-btn fix-gr-bg"><i class="ti-check"></i>
                                                {{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="mt-20 pt-100 text-center">
        {{__('menu.no_categories')}}
    </div>
@endif
