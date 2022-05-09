@props(['name', 'field', 'value' => Null, 'required' => false, 'options' => [], 'help' => null, 'disabled' => false])
<div class="primary_input mb-25">
    @php
    $error_container = 'parsley_'.$name.'_error';
    @endphp
    <x-backEnd.label :field="$field" :name="$name" :required="$required" :help="$help"/>
    {{ Form::select($name, $options, $value, ['id' => $name, 'class' => 'primary_select nice-select ', 'required' => $required, 'data-parsley-errors-container' => '#'.$error_container, 'disabled' => $disabled]) }}
    <span id="{{ $error_container }}"></span>
</div>
