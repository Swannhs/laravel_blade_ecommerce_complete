
<h1>{{ app('general_setting')->mail_header }}</h1>
<h4>{{ $subject }}</h4>
<p>{{ $content }}</p>

<p>{{  app('general_setting')->mail_footer }}</p>
