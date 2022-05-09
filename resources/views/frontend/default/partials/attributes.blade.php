
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
                                <input type="checkbox" name="attr_value[]" class="getProductByChoice" data-id="{{ $attribute->id }}" data-value="{{ $attr_value->id }}" id="attr_value">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
@endforeach
