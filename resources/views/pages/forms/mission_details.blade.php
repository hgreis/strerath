@if($mission->company == 1)
    <h2>STRERATH TRANSPORTE - Auftragsübersicht #{{ $mission->id }}</h2>
@else
    <h2>SABINE HEINRICHS TRANSPORTE - Auftragsübersicht #{{ $mission->id }}</h2>
@endif
    <h3>Touren-Details</h3>
        <table style="width: 100%">
            <tr>
                <th style="width: 50%">Abholung</th>
                <th style="width: 50%">Auslieferung</th>
            </tr>
            <tr>
                <td style="padding-right: 30px">
                    Datum: {{ $mission->startDatum }}<br>
                    Name: {{ $mission->startName }}<br>
                    Strasse: {{ $mission->startStrasse }}<br>
                    Ort: {{ $mission->startOrt }}<br>
                    Bemerkung: {{ $mission->startBemerkung }}
                </td>
                <td>
                    Datum: {{ $mission->zielDatum }}<br>
                    Name: {{ $mission->zielName }}<br>
                    Strasse: {{ $mission->zielStrasse }}<br>
                    Ort: {{ $mission->zielOrt }}<br>
                    Bemerkung: {{ $mission->zielBemerkung }}
                </td>
            </tr><tr><td>&nbsp;</td></tr>
            <tr>
                <td>Auftragsbestätigung: 
                    @if($mission->missionConfirmation == null)
                        <b style="color: red">KEINE AUFTRAGSBESTÄTIGUNG HINTERLEGT</b>
                    @else
                        <a href="/uploads/{{$mission->id}} Auftragsbestaetigung.pdf" target="_blank">{{ $mission->id }} Auftragsbestätigung.pdf </a>
                    @endif
                </td>
                <td>Ablieferbeleg: 
                    @if($mission->deliveryNote == null)
                        <b style="color: red">KEIN ABLIEFERBELEG HINTERLEGT</b>
                    @else
                        <a href="/uploads/{{$mission->id}} Lieferschein.pdf" target="_blank">{{ $mission->id }} Ablieferbeleg.pdf </a>
                    @endif
                </td>
            </tr>
        </table><hr>
    <h3>Fahrer-Details</h3>
        <table style="width: 100%">
            <tr>
                <th><b>Fahrer</b></th>
                <th><b>Unternehmer</b></th>
                <th><b>Vergütung</b></th>
            </tr>
            <tr>
                @if(isset($mission->driver))
                    <td>
                        Name: {{ $mission->driver->name }}<br>
                        Telefon: {{ $mission->driver->phone }}<br>
                        Nummernschild: {{ $mission->driver->number_plate }}
                    </td>
                    <td>
                        Firma: {{ $mission->driver->contractor }}<br>
                        Anschrift: {{ $mission->driver->street }}, {{ $mission->driver->city }}<br>
                        Emailadresse: {{ $mission->driver->email }}
                    </td>
                @else
                    <td>KEIN FAHRER AUSGEWÄHLT</td>
                    <td></td>
                @endif
                <td>
                    Vereinbarter Preis: {{ number_format($mission->preisFahrer, 2) }} €<br>
                    Gutschrift-Nr.: {{ $mission->credit }} <br>
                    Bezahlt am: {{ $mission->credit_paid }}
                </td>
            </tr>
        </table><hr>
    <h3>Auftraggeber</h3>
        <table style="width: 100%">
            <tr>
                <td>
                    <b>{{ $mission->customer->name }}</b><br>
                    {{ $mission->customer->street }}<br>
                    {{ $mission->customer->city}}<br>
                </td>
                <td>
                    <b>Kontaktdaten:</b><br>
                    Telefon: {{ $mission->customer->phone }}<br>
                    Email: {{ $mission->customer->email }}
                </td>
                <td>
                    Tourenpreis: {{ number_format($mission->preisKunde, 2) }} €<br>
                        @if(isset($mission->bill_id))
                            Rechnungsnummer: RE-{{ $mission->bill_number }}<br>
                        @else
                            <b style="color: red"> ES WURDE NOCH KEINE RECHNUNG ERSTELLT</b><br>
                        @endif
                    Rechnungsbetrag: {{ number_format($mission->bill_price,2) }}€<br>
                    Zahlungseingang: {{ $mission->bill_paid }}<br>
                </td>
            </tr>
        </table>
