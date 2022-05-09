<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('defaultTheme.contact_form') }}</title>
</head>
<body>
    <h2>{{ __('defaultTheme.contact_message') }}</h2>
    <p>
        {{ __('common.name') }}:
        {{$details['name']}}</p>
    <p>
        {{ __('common.email') }}:
        {{$details['email']}}</p>
    <p>
        {{ __('common.message') }}:
        {{$details['message']}}</p>

</body>
</html>
