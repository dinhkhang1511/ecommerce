@component('mail::message')
# Introduction

{!! $content !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
