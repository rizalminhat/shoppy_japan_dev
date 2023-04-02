@component('mail::message')
Here the status for your item. Login shoppyJapan for more details.
@component('mail::panel')
<h2>{{ $details['title'] }}</h2>
<h2>{{ $details['available'] }}</h2>
<h2>{{ $details['not'] }}</h2>
@endcomponent


@component('mail::button',['url' => $details['url']])
Log In shoppyJapan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
