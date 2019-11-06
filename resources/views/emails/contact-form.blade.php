@component('mail::message')
# Introduction

The body of your message.
{{ $data['message'] }}

@component('mail::button', ['url' => env('APP_URL')])
Go to site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
