@component('mail::message', ['subject' => $subject ?? null])
Vážení rodiče

Dovolujeme si vás upozornit, že v přihlášce žáka **{{ $student->name }}** byla provedena následující změna.

@if($action == 'logout')
@if($student->logged_out){{-- IS logged_out --}}
Žák je odhlášen, pro více informací nás kontaktujte.
@else{{-- IS NOT logged_out --}}
Žák **je** nyní veden jako **řádně přihlášený**. Zkontrolujte si údaje zadané v přihlašovacím systému pomocí tlačítka níže.
@endif
@elseif($action == 'cancel')
@if($student->canceled){{-- IS canceled --}}
**Zrušení** přihlášky z důvodu: {{ $student->canceled }}.
@else{{-- IS NOT canceled --}}
Přihláška již není zrušena. Pro více informací klikněte na tlačítko níže.
@endif
@endif

@include('mail.__parts.button-detail')

@endcomponent
