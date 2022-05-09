@component('mail::message')

<h1>{{ app('general_setting')->mail_header }}</h1>
<h4>{{ $data['subject'] }}</h4>
<p>{{ $data['content'] }}</p>

<p>{{  app('general_setting')->mail_footer }}</p>
@endcomponent
