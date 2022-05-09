@if($subItem->status == 1)
    <option value="{{ $subItem->id }}" @isset($product_categories) @if (in_array($subItem->id,$product_categories)) selected @endif @endisset>
        @for ($i = 1; $i < $subItem->depth_level; $i++)
            <span>-</span>
        @endfor
        <span>-></span> {{ $subItem->name }}
    </option>
@endif

@foreach ($subItem->subCategories as $subItem)
    @if(isset($product_categories))
        @include('seller::products.components.product._category_option_select',['subItem' => $subItem, 'product_categories' => $product_categories])
    @else
        @include('seller::products.components.product._category_option_select',['subItem' => $subItem])
    @endif
@endforeach
