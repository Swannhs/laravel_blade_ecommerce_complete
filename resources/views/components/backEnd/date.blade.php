@props(['name', 'field', 'value' => Null, 'required' => false, 'help' => null])
@php
    $error_container = 'parsley_'.$name.'_error';
@endphp

<div class="primary_input mb-15">
    <x-backEnd.label :field="$field" :name="$name" :required="$required" :help="$help" />
    <div class="primary_datepicker_input">
        <div class="no-gutters input-right-icon date_container">
            <div class="col">
                <div class="">
                    {{ Form::text($name, $value, ['class' => 'primary_input_field primary-input date form-control', 'required' => $required,   'data-parsley-errors-container' => '#'.$error_container, 'id' => $name, 'readonly'])  }}
                </div>
            </div>
            <button class="" type="button">
                <i class="ti-calendar date-icon" ></i>
            </button>
        </div>
    </div>
</div>
