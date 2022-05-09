@props(['name', 'field', 'value' => Null, 'required' => false, 'help' => null])
@php
    $error_container = 'parsley_'.$name.'_error';
@endphp

<div class="primary_input mb-15">
    <div class="primary_datepicker_input">
        <div class="no-gutters input-right-icon">
            <div class="col">
                <div class="">
                    {{ Form::text($name, $value, ['class' => 'primary_input_field primary-input form-control', 'required' => $required, 'placeholder' => $field,  'data-parsley-errors-container' => '#'.$error_container, 'id' => $name]) }}

                </div>
            </div>
            <button class="" type="button">
                <i class="ti-calendar" id="start-date-icon"></i>
            </button>
        </div>
        <span id="{{ $error_container }}"></span>
    </div>

</div>
