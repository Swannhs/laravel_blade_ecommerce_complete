@if ($message->send_type == 1 || $message->send_type == 4)
    {{ $message->send_to() }}
@else
    @foreach ($message->send_to() as $key => $item)
        <ul>
            <li>{{ $item }}</li>
        </ul>
    @endforeach
@endif
