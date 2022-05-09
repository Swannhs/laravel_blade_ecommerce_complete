@if($data_type == 'product')
<div class="primary_input mb-25">
    <label class="primary_input_label" for="">{{ __('product.product_list') }}</label>
    <select name="data_id" id="slider_product" class="primary_select slider_drop mb-15">
        @foreach($productList as $key => $product)
        <option value="{{$product->id}}">{{$product->product->product_name }} @if(isModuleActive('MultiVendor')) [@if($product->seller->role->type == 'seller') {{$product->seller->first_name}} @else Inhouse @endif] @endif</option>
        @endforeach
        
    </select>
    <span class="text-danger"></span>
</div>

@elseif($data_type == 'category')
<div class="primary_input mb-25">
    <label class="primary_input_label" for="">{{ __('product.category_list') }}</label>
    <select name="data_id" id="slider_category" class="primary_select slider_drop mb-15">
        
        @foreach($categories as $key => $item)
            @if($item->status == 1)
                <option value="{{$item->id}}"><span>-></span> {{ $item->name}}</option>
            @endif

            @if(count($item->subCategories) > 0)
                @foreach($item->subCategories as $subItem)
                    @include('appearance::header.components._category_select_option',['subItem' => $subItem])
                @endforeach    
            @endif
        @endforeach
        
    </select>
    <span class="text-danger"></span>
</div>
@elseif($data_type == 'brand')
<div class="primary_input mb-25">
    <label class="primary_input_label" for="">{{ __('product.brand_list') }}</label>
    <select name="data_id" id="slider_brand" class="primary_select slider_drop mb-15">
        @foreach($brands as $key => $brand)
        <option value="{{$brand->id}}">{{$brand->name}}</option>
        @endforeach
        
    </select>
    <span class="text-danger"></span>
</div>

@elseif($data_type == 'tag')
<div class="primary_input mb-25">
    <label class="primary_input_label" for="">{{ __('common.tag') }} {{__('common.list')}}</label>
    <select name="data_id" id="slider_tag" class="primary_select slider_drop mb-15">
        @foreach($tags as $key => $tag)
        <option value="{{$tag->id}}">{{$tag->name}}</option>
        @endforeach
        
    </select>
    <span class="text-danger"></span>
</div>

@elseif($data_type == 'url')
<div class="col-lg-12">
    <div class="primary_input mb-25">
            <label class="primary_input_label"
                for="url">{{__('setup.url')}} <span class="text-danger">*</span></label>
                <input class="primary_input_field" type="text" id="url" name="data_id" autocomplete="off"
            value="" placeholder="{{__('setup.url')}}">
    </div>
    <span class="text-danger" id="error_name"></span>
</div>


@endif