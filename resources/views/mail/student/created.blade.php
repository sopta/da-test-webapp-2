@component('mail::message', ['subject' => $subject ?? null])
Vážení rodiče

Děkujeme Vám za provedení přihlášky. Prosíme Vás o pečlivou kontrolu Vámi zadaných údajů, případné změny ihned opravte v systému.

@include('mail.__parts.detail-table')

@include('mail.__parts.payment-table')

Potvrzení o přihlášení si můžete vytisknout přímo ze systému. Stačí kliknout na tlačítko níže, přihlásit se Vašimi přihlašovacími údaji a poté kliknout na ikonu Informace vpravo na řádku u jména přihlášeného dítěte.

@include('mail.__parts.button-detail')
{{-- __SMT_END__ --}}@endcomponent
