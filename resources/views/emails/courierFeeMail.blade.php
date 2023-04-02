

@component('mail::message')
Here the courier fee for your order. Login your account to proceed the payment.
Thank you shopping with us.
@component('mail::panel')
<h2>{{ $details['title'] }}</h2>
<h2>{{ $details['courier_fee'] }}</h2>
@endcomponent


@component('mail::button',['url' => $details['url']])
Log In shoppyJapan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
