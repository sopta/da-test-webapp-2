@component('mail::message', ['subject' => $subject ?? null])
Vážení rodiče

Provedli jste úpravu údajů u přihlášky žáka  **{{ $student->name }}**. Prosíme Vás o pečlivou kontrolu Vámi zadaných údajů, případné změny ihned opravte v systému.

@include('mail.__parts.detail-table')

@include('mail.__parts.payment-table')

@include('mail.__parts.button-detail')
{{-- __SMT_END__ --}}@endcomponent
