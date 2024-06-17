@component('mail::message')
Hello {{$user->name}},

<p>We understand it happpen.</p>

@component('mail::button',['url'=>url('reset/'.$user->remember_token)])
Reset Your Password
@endcomponent

<p>In case you have any issues recovering your password,please contect us.</p>

Thanks, <br>
{{ config('app.name')}}
@endcomponent
