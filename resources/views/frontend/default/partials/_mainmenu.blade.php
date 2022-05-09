@php
    $actual_link = \Illuminate\Support\Facades\URL::current();
    $base_url = url('/');
    $flash_deal = \Modules\Marketing\Entities\FlashDeal::where('status', 1)->first();

    $new_user_zone = \Modules\Marketing\Entities\NewUserZone::where('status', 1)->first();

@endphp
<div class="main_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 order-1 order-lg-1">
                <div class="main_logo">
                    <a class="logo_div" href="{{ url('/') }}"><img
                            src="{{ showImage(app('general_setting')->logo) }}" alt="#" /></a>
                    <div class="mega_menu_icon {{ $actual_link == $base_url ? 'd-lg-none' : '' }}">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                @include('frontend.default.partials._mega_menu_small')
            </div>
            <div class="col-12 col-sm-12 col-md-9 col-lg-8 col-xl-6 order-3 order-lg-2">
                <div class="category_box">
                    <form method="GET" id="search_form">
                        <div class="input-group category_box_iner">
                            <div class="input-group-prepend">
                                <select class="country_list category_list category_id default_select"
                                    name="category_id">
                                    <option value="0">{{ __('defaultTheme.all_categories') }}</option>
                                    @foreach (Modules\Product\Entities\Category::where('status', 1)->where('searchable', 1)->get() as $key => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="form-control category_box_input" id="inlineFormInputGroup"
                                placeholder="{{ __('defaultTheme.search_your_item') }}"
                                onfocus="this.placeholder = ''"
                                onblur="this.placeholder = '{{ __('defaultTheme.search_your_item') }}'" />
                            <div class="input-group-append">
                                <button id="search_button"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="live-search">
                        <ul class="p-0" id="search_items">
                            <li class="search_item" id="search_empty_list">
                                
                            </li>
                            <li class="search_item" id="search_history">
                                
                            </li>
                            <li class="search_item" id="tag_search">
                                
                            </li>
                            <li class="search_item" id="category_search">
                                
                            </li>
                            <li class="search_item" id="product_search">
                                
                            </li>
                            <li class="search_item" id="seller_search">
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 order-2 order-lg-3 d-lg-none d-xl-block">
                <div class="main_menu_btn d-lg-flex">
                    @if (isset($flash_deal))
                        <a href="{{ route('frontend.flash-deal', $flash_deal->slug) }}"
                            class="menu_btn_1 text-nowrap">{{ __('defaultTheme.best_deals') }}</a>
                    @endif
                    @if (isset($new_user_zone))
                        <a href="{{ route('frontend.new-user-zone', $new_user_zone->slug) }}"
                            class="menu_btn_1 text-nowrap">{{ __('defaultTheme.new_user_zone') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
