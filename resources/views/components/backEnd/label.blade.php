@props(['name', 'field',  'required' => false, 'help' => null])

<label for="{{ $name }}" class="primary_input_label {{ $required ? 'required' : '' }}">
    {{ $field }}
    <x-backEnd.help :help="$help" />
</label>

