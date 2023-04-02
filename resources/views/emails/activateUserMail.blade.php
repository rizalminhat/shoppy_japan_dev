

@component('mail::message')
Thanks for signing up shoppyJapan.
@component('mail::panel')
<h2>{{ $details['title'] }}</h2>
<h2>{{ $details['tracking'] }}</h2>
<h2>{{ $details['courier'] }}</h2>
@endcomponent


@component('mail::button',['url' => $details['url']])
Log In shoppyJapan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
