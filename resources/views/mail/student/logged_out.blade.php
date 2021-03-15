@component('mail::message', ['subject' => $subject ?? null])
Vážení rodiče,

Upozorňujeme, že jste odhlásili žáka {{ $student->name }}.

@include('mail.__parts.button-detail')
@endcomponent
