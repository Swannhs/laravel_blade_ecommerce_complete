@if($subItem->status == 1)
    <option value="{{ $subItem->id }}" @isset($element) @if ($element->category_id == $subItem->id) selected @endif @endisset>
        @for ($i = 1; $i < $subItem->depth_level; $i++)
            <span>-</span>
        @endfor
        <span>-></span> {{ $subItem->name }}
    </option>
@endif

@foreach ($subItem->subCategories as $subItem)
    @if(isset($element))
        @include('appearance::header.components._category_select_option',['subItem' => $subItem, 'element' => $element])
    @else
        @include('appearance::header.components._category_select_option',['subItem' => $subItem])
    @endif
@endforeach