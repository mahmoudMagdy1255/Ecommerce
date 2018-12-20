@component('mail::message')
Reset Account
Welcome {{ $data['data']->name }}

@component('mail::button', ['url' => aurl('reset/password/' . $data['token'])])
Click Here To Reset Your Password
@endcomponent
Or<br>
Copy This Link

<a href="{{ aurl('reset/password/' . $data['token']) }}">{{ aurl('reset/password/' . $data['token']) }}</a>
<br>Thanks,<br>
{{ config('app.name') }}
@endcomponent
