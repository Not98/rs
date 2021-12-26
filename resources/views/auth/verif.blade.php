@component('mail::message')
Verifikasi Account SIMPUS Online Bantarkawung
 
<br>
{{$user}}

@component('mail::button', ['url' => $urlv])
Verifikasi 
@endcomponent

Terimakasih ,<br>
By :{{ config('app.name') }}
@endcomponent
