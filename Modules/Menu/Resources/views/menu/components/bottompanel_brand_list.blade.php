@if (count(@$menu->bottomPanelData) > 0)
    @foreach (@$menu->bottomPanelData as $key => $element)
        <div class="col-lg-12 single_item" data-id="{{ $element->id }}">
            <div class="mb-10">
                <div class="card" id="accordion_bottom_{{ $element->id }}">
                    <div class="card-header card_header_element">
                        <p class="d-inline">
                            {{ @$element->title }}
                        </p>
                        <a href="" data-id="{{ $element->id }}" class="pull-right d-inline primary-btn bottom_panel_brand_delete_btn"><i class="ti-close"></i></a>
                        <a href="javascript:void(0);" class="pull-right d-inline  mr-10 primary-btn"
                            data-toggle="collapse" data-target="#collapse_bottom_{{ $element->id }}" aria-expanded="true"
                            aria-controls="collapse_bottom_{{ $element->id }}">{{__('common.edit')}}</a>

                    </div>
                    <div id="collapse_bottom_{{ $element->id }}" class="collapse"
                        aria-labelledby="heading_bottom_{{ $element->id }}" data-parent="#accordion_bottom_{{ $element->id }}">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="bottomPanelDataEditForm">
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
                                            <label class="primary_input_label" for="">{{ __('product.brand') }}
                                                <span class="text-danger">*</span></label>
                                            <select name="brand" class="primary_select mb-15 bottom_brand">
                                                @foreach ($brands as $key => $brand)
                                                    <option {{$element->brand_id == $brand->id?'selected':''}} value="{{ $brand->id }}">
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="text-danger"></span>
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
        {{__('menu.no_brands')}}
    </div>
@endif
