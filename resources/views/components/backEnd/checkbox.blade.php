@props(['name', 'field',  'value' => 1, 'required' => false, 'checked' => false, 'help' => null])

<div class="primary_input mb-25">
        <label class="primary_checkbox d-flex mr-12 w-100">
            <input name="{{ $name }}" value="{{ $value }}" type="checkbox" {{ $checked ? 'checked' : ''}}  {{ $required ? 'required' : ''}}>
            <span class="checkmark"></span>
            <p class="ml-2">{{ $field }} <x-backEnd.help :help="$help" /> </p>
        </label>
</div>
