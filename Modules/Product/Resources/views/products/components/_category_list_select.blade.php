
<div class="primary_input mb-25">
    <div class="double_label d-flex justify-content-between">
        <label class="primary_input_label" for="">{{ __('product.category') }} <span class="text-danger">*</span></label>
        <label class="primary_input_label green_input_label" for=""><a href="" id="add_new_category">{{__('common.add_new')}}<i class="fas fa-plus-circle"></i></a></label>
    </div>
    <select name="category_ids[]" id="category_id" class="primary_select mb-15 category" @if(app('general_setting')->multi_category == 1) multiple @elseif(isset($product) && count($product->categories) > 1) multiple @endif required="1">
        
        @foreach ($categories->where('parent_id', 0) as $key => $category)
            @if($category->status == 1)
                <option value="{{ $category->id }}" @isset($product_categories) @if (in_array($category->id,$product_categories)) selected @endif @endisset><span>-></span> {{ $category->name }}</option>
            @endif
            @if(count($category->subCategories) > 0)
                @foreach($category->subCategories as $subItem)
                    @if(isset($product_categories))
                        @include('product::products.components._category_select_option',['subItem' => $subItem,'product_categories' => $product_categories])
                    @else
                        @include('product::products.components._category_select_option',['subItem' => $subItem])
                    @endif
                    
                @endforeach
            @endif
        @endforeach
    </select>
    <span class="text-danger" id="error_category_ids">{{ $errors->first('category_id') }}</span>
</div>
