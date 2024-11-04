@component('mail::message')

Selamat datang {{ $user->nama }} <br>
Password anda adalah {{ $password }}

@component('mail::button', ['url' => url('/verify/'.$user->remember_token)])
Verifikasi
@endcomponent

Silahkan klik tombol diatas untuk melakukan verifikasi akun anda.<br>
{{ config('app.name') }}
@endcomponent
