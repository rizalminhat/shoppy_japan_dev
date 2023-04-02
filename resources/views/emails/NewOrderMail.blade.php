@component('mail::message')
New order arrived proceed for purchasing.
@component('mail::panel')
<h2>{{$details['order']}}</h2>
<p>{{ $details['name'] }}</p>
<p>{{ $details['email']}}</p>
<p>{{ $details['amount'] }}</p>



@endcomponent


@component('mail::button',['url' => $details['url2']])
Log In shoppyJapan Admin
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
