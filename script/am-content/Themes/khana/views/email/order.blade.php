@component('mail::message')
# New Message

Name: {{ $data['name'] }}<br>
Email: {{ $data['email'] }}<br>
Subject: {{ $data['subject'] }}<br>
Message: {{ $data['message'] }}

Order confirmation
Thanks,<br>
{{ config('app.name') }}
@endcomponent
