@if ($color != null)
    <div class="single_category ">
        <div class="category_tittle">
            <h4>{{ $color->name }}</h4>
        </div>
        <div class="single_category_option">
            @foreach ($color->values as $k => $color_name)
                <div class="radio colors_{{$k}}">
                    <input id="radio-{{$k}}" name="color[]" type="radio" color="color" data-id="{{ $color->id }}" data-value="{{ $color_name->id }}" class="attr_val_name attr_clr getProductByChoice" value="{{ $color_name->color->name }}"/>
                    <label for="radio-{{$k}}" class="radio-label"></label>
                </div>
            @endforeach
        </div>
    </div>
@endif

<script type="text/javascript">
$(document).ready(function(){
    '@if ($color != null)'+
        '@foreach ($color->values as $ki => $item)'+
            $(".colors_{{$ki}}").css("background-color", "{{ $item->value }}");
        '@endforeach'+
    '@endif'
});
</script>
