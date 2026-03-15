@component('mail::message')
# <span style="text-transform: capitalize">{{ $complement_subject??'---' }}</span>

{{-- <span style="text-transform: capitalize"> Bonjour {{ $user??'---' }}</span>, <br> --}}
{!! $content??'---' !!}


<br><br>
Cordialement,<br>
{{ config('app.name') }}
@endcomponent
