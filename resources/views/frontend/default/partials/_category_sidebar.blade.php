<div class="col-lg-3">
    <div class="category_sidebar">
        <div class="category_refress">
            <a href="" id="refresh_btn">{{ __('defaultTheme.refresh_filters') }}</a>
            <i class="ti-reload"></i>
        </div>
        <div class="single_category">
            <div class="category_tittle">
                <h4>{{ __('common.category') }}</h4>
            </div>
            <div class="single_category_option">
                <nav>
                    <ul>
                        @foreach($CategoryList as $key => $category)
                        @if (count($category->subCategories) > 0)
                        <li class='sub-menu'><a class="getProductByChoice" data-id="parent_cat"
                                data-value="{{ $category->id }}">{{$category->name}}<div
                                    class='ti-plus right plus_btn_div'></div></a>
                            @else
                        <li class='sub-menu'><a class="getProductByChoice" data-id="cat"
                                data-value="{{ $category->id }}">{{$category->name}}<div
                                    class='ti-plus right plus_btn_div'></div></a>
                            @endif
                            <ul>
                                @foreach($category->subCategories as $key => $subCategory)
                                <li>
                                    <a href="#">{{$subCategory->name}}</a>
                                    <label class="cs_checkbox">
                                        <input type="checkbox" class="getProductByChoice attr_checkbox" data-id="cat"
                                            data-value="{{ $subCategory->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach

                            </ul>
                        </li>
                        @endforeach

                    </ul>
                </nav>
            </div>
        </div>
        <div class="brandDiv">

        </div>
        <div class="colorDiv">

        </div>
        <div class="attributeDiv">

        </div>

        <div class="single_category materials_content">
            <div class="category_tittle">
                <h4>{{ __('defaultTheme.rating') }}</h4>
            </div>
            <div class="single_category_option">
                <nav>
                    <ul>

                        <li>
                            <a href='#Electronics'>
                                <div class="review_star_icon">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>


                            </a>
                            <label class="cs_checkbox">
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice"
                                    data-id="rating" data-value="5" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <a href='#Electronics'>
                                <div class="review_star_icon">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                </div>
                            </a>
                            <label class="cs_checkbox">
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice"
                                    data-id="rating" data-value="4" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <a href='#Electronics'>
                                <div class="review_star_icon">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                </div>
                            </a>
                            <label class="cs_checkbox">
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice"
                                    data-id="rating" data-value="3" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <a href='#Electronics'>
                                <div class="review_star_icon">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                </div>
                            </a>
                            <label class="cs_checkbox">
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice"
                                    data-id="rating" data-value="2" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                        <li>
                            <a href='#Electronics'>
                                <div class="review_star_icon">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i>
                                    <i class="fas fa-star non_rated"></i> {{ __('defaultTheme.and_up') }}
                                </div>
                            </a>
                            <label class="cs_checkbox">
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice"
                                    data-id="rating" data-value="1" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>

        <div class="single_category price_rangs">
            <div class="category_tittle">
                <h4>{{ __('defaultTheme.price_range') }}</h4>
            </div>
            <div class="single_category_option" id="price_range_div">
                <div class="wrapper">
                    <div class="range-slider">
                        <input type="text" class="js-range-slider-0" value="" />
                    </div>
                    <div class="extra-controls form-inline">
                        <div class="form-group">
                            <div class="price_rangs">
                                <input type="text" class="js-input-from form-control" id="min_price"
                                    value="{{ $min_price_lowest }}" readonly />
                                <p>{{ __('common.min') }}</p>
                            </div>
                            <div class="price_rangs">
                                <input type="text" class="js-input-to form-control" id="max_price"
                                    value="{{ $max_price_highest }}" readonly />
                                <p>{{ __('common.max') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
