@component('mail::message', ['subject' => $subject ?? null])
Vážení rodiče

Vaše platba za akci Czechitas za žáka **{{ $student->name }}** s částkou **{{ formatPrice($price) }}** byla vložena do systému.

V případě plně uhrazeného kurzu si můžete vytisknout doklad o zaplacení. Stačí kliknout na tlačítko níže a přihlásit se Vašimi přihlašovacími údaji.

@include('mail.__parts.button-detail')
@endcomponent
