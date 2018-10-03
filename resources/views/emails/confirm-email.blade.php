@component('mail::message')
# Welcome to our little family

Please confirm your email to activate your account.

@component('mail::button', ['url' => url('/register/activate?token=' . $user->confirmation_token)])
Activate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
