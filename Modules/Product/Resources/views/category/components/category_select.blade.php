
<option value="{{$subItem->id}}">
    
    @for($i = 1; $i < $subItem->depth_level; $i++)
        <span>-</span>
    @endfor

    <span>-></span> {{ $subItem->name}}

</option>

@foreach($subItem->subCategories as $subItem)

    @include('product::category.components.category_select',['subItem' => $subItem])

@endforeach