@props(['name', 'field', 'type' => 'text', 'value' => Null, 'required' => false, 'help' => null])
@php
    $error_container = 'parsley_'.$name.'_error';
@endphp
<div class="primary_input mb-25">
    <x-backEnd.label :field="$field" :name="$name" :required="$required" :help="$help" />
    {{ Form::$type($name, $value, ['class' => 'primary_input_field', 'required' => $required, 'placeholder' => $field,  'data-parsley-errors-container' => '#'.$error_container, 'id' => $name]) }}
    <span id="{{ $error_container }}"></span>
</div>

