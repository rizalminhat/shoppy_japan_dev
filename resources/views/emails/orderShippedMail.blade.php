

@component('mail::message')
Here the latest order details. Thank you shopping with us.
@component('mail::panel')
<h2>{{ $details['title'] }}</h2>
<h2>{{ $details['tracking'] }}</h2>
<h2>{{ $details['courier'] }}</h2>
@endcomponent


@component('mail::button',['url' => $details['url']])
Click Here To Log In shoppyJapan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
