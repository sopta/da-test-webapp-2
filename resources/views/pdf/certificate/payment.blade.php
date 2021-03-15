@extends('pdf.layout.certificate')

@section('title', "Potvrzení o zaplacení akce")

@section('payment_date')
    @if (!empty($paymentDate))
        <tr>
            <th class="space firstCol">Datum platby</th>
            <td colspan="2">{{ $paymentDate->format("d.m.Y") }}</td>
        </tr>
    @endif
@endsection
