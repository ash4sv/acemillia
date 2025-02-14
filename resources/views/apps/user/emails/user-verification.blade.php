@component('mail::message')
{{--# Welcome to Malaysia Hobby Expo 2024 (MHX2024)--}}

Please verify your email address by clicking the button below.

@component('mail::button', ['url' => $url])
Verify Email Address
@endcomponent

Thank you!<br>
{{--Malaysia Hobby Expo 2024--}}

---

<small>If you're having trouble clicking the "Verify Email Address" button, copy and
    paste the URL below into your web browser: <a href="{{ $url }}">{{ $url }}</a></small>

@endcomponent
