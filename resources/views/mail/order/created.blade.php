@component('mail::message')
# Přijatá objednávka

Dobrý den,

děkujeme Vám za vyplnění objednávky.<br>
O zpracování objednávky budete informováni emailem.

## Detaily objednávky
**Služba:** {{ trans('orders.type.'.$order->type) }}<br>
**Odběratel**: {{ $order->client }}<br>
**Kontaktní osoba**: {{ $order->contact_name }}<br> Email: [{{ $order->contact_mail }}](mailto:{{ $order->contact_mail }}), Telefon: {{ $order->contact_tel }}<br>
@if (empty($order->start_date_2) && empty($order->start_date_3))
**Požadovaný termín**: {{ $order->start_date_1 }} - {{ $order->getXData('end_date_1') }}
@else
**Požadovaný termín:**: jeden z {{ $order->start_date_1 }} - {{ $order->getXData('end_date_1') }}@if (!empty($order->start_date_2)), {{ $order->start_date_2 }} - {{ $order->getXData('end_date_2') }}@endif{{ "" }}@if (!empty($order->start_date_3)), {{ $order->start_date_3 }} - {{ $order->getXData('end_date_3') }}@endif
@endif

@endcomponent
