<div class="col-lg-3">
    <div class="category_sidebar">
        <div class="category_refress">
            <a href="" id="refresh_btn">{{ __('defaultTheme.refresh_filters') }}</a>
            <i class="ti-reload"></i>
        </div>
        @isset($CategoryList)
        @if (count($CategoryList) > 0)
            <div class="single_category">
                <div class="category_tittle">
                    <h4>{{ __('defaultTheme.child_category') }}</h4>
                </div>
                <div class="single_category_option">
                    <nav>
                        <ul>
                            @foreach($CategoryList as $key => $category)
                            <li class='sub-menu'><a class="getProductByChoice" data-id="cat" data-value="{{ $category->id }}">{{$category->name}}<div class='ti-plus right'></div></a>
                                <ul>
                                    @foreach($category->subCategories as $key => $subCategory)
                                        <li>
                                            <a class="getProductByChoice" data-id="cat" data-value="{{ $subCategory->id }}">{{$subCategory->name}}</a>
                                            <label class="cs_checkbox">
                                                <input type="checkbox" class="getProductByChoice category_checkbox" data-id="cat" data-value="{{ $subCategory->id }}">
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
        @endif
        @endisset

        @isset ($brandList)
            @if (count($brandList) > 0)
                <div class="single_category">
                    <div class="category_tittle">
                        <h4>{{ __('common.brand') }}</h4>
                    </div>
                    <div class="single_category_option">
                        <nav>
                            <ul>
                                @foreach($brandList as $key => $brand)
                                <li class='sub-menu'><a class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}">{{$brand->name}}<div class='ti-plus right'></div></a></li>

                                @endforeach


                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        @endisset

        @isset($color)
            @if ($color != null && $color->id == 1)
                <div class="single_category ">
                    <div class="category_tittle">
                        <h4>{{ $color->name }}</h4>
                    </div>
                    <div class="single_category_option">
                        @foreach ($color->values as $k => $color_name)
                            <div class="radio colors_{{$k}}">
                                <input id="radio-{{$k}}" name="color[]" id="color" type="checkbox" color="color" data-id="{{ $color->id }}" data-value="{{ $color_name->id }}" class="attr_val_name getProductByChoice color_checkbox" value="{{ $color_name->color->name }}"/>
                                <label for="radio-{{$k}}" class="radio-label"></label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endisset

        @isset($attributeLists)
        @foreach ($attributeLists as $key => $attribute)
            <div class="single_category materials_content">
                <div class="category_tittle">
                    <h4>{{ $attribute->name }}</h4>
                </div>
                <div class="single_category_option">
                    <nav>
                        <ul>
                            @foreach ($attribute->values as $key => $attr_value)
                                <li>
                                    <a href='#Electronics'>{{ $attr_value->value }}</a>
                                    <label class="cs_checkbox">
                                        <input type="checkbox" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="{{ $attribute->id }}" data-value="{{ $attr_value->id }}" id="attr_value">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        @endforeach
        @endisset

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
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="5" id="attr_value">
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
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="4" id="attr_value">
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
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="3" id="attr_value">
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
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="2" id="attr_value">
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
                                <input type="radio" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="rating" data-value="1" id="attr_value">
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
                        <input type="text" class="js-range-slider-0" value=""/>
                    </div>
                    <div class="extra-controls form-inline">
                        <div class="form-group">
                            <div class="price_rangs">
                                
                                <input type="text" class="js-input-from form-control" id="min_price" value="{{ $min_price_lowest }}" readonly/>
                                <p>{{ __('common.min') }}</p>
                            </div>
                            <div class="price_rangs">
                                <input type="text" class="js-input-to form-control" id="max_price" value="{{ $max_price_highest }}" readonly/>
                                <p>{{ __('common.max') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
