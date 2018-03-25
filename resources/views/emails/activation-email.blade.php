@component('mail::message')
# User Activation Email

Please click below to activate your account

@component('mail::button', ['url' => url('/activate?token=' . $user->activation_token) ])
Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
