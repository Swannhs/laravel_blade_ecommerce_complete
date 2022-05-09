@props(['name', 'field', 'type' => 'text', 'value' => Null, 'required' => false, 'rows' => 3, 'summernote' => false])
<div class="primary_input mb-25">

    <x-backEnd.label :field="$field" :name="$name" :required="$required" />
    {{ Form::textarea($name, $value, ['class' => 'primary_textarea resize_vertical ' . ($summernote ? 'summernote' : ''), 'required' => $required, 'placeholder' => $field, 'rows' => $rows, 'id' => $name]) }}

</div>
