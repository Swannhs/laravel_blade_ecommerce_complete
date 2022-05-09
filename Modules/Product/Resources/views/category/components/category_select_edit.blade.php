
<option value="{{$subItem->id}}"@if($subItem->id == $parent_id) selected @endif>
    
    @for($i = 1; $i < $subItem->depth_level; $i++)
        <span>-</span>
    @endfor

    <span>-></span> {{ $subItem->name}}

</option>

@foreach($subItem->subCategories as $subItem)

    @include('product::category.components.category_select_edit',['subItem' => $subItem, 'parent_id' => $parent_id])

@endforeach