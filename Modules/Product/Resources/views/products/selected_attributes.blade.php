@php
    $attribute = \Modules\Product\Entities\Attribute::where('id',$attribute)->first();
@endphp
<div class="row">
    <div class="col-lg-4"><input type="hidden" name="choice_no[]" id="attribute_id_{{$attribute->id}}" value="{{$attribute->id}}">
        <div class="primary_input mb-25"><input class="primary_input_field" width="40%" name="choice[]" type="text"
                value="{{$attribute->name}}" readonly></div>
    </div>
    <div class="col-lg-7">
        <div class="primary_input mb-25">
            <select name="choice_options_{{$attribute->id}}[]" id="choice_options" class="primary_select mb-15" multiple>
                @foreach(@$attribute->values as $key => $item)
                    @if($item->color)
                        <option value="{{$item->id}}">{{@$item->color->name}}</option>
                    @else
                        <option value="{{$item->id}}">{{$item->value}}</option>
                    @endif
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-lg-1 text-center">
        <a class="btn cursor_pointer attribute_remove"><i class="ti-trash"></i></a>
    </div>

</div>
