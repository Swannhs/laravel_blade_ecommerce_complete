@component('mail::message')

<h4>{{ $data['subject'] }}</h4>
<p>{{ $data['content'] }}</p>

@endcomponent
