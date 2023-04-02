@component('mail::message')
We received your payment. Here the details for you order payment.
@component('mail::panel')
<h2>{{$details['order']}}</h2>
<p>{{ $details['name'] }}</p>
<p>{{ $details['type'] }}</p>
<p>{{ $details['ref'] }}</p>
<p>{{ $details['amount'] }}</p>
<p>{{ $details['bank'] }}</p>
<p>{{ $details['date'] }}</p>


@endcomponent


@component('mail::button',['url' => $details['url']])
Log In shoppyJapan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
