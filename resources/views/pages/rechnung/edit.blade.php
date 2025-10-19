@extends('layouts.main')
@section('content')
    <h1>Unternehmer-Rechnung: {{ $rechnung->driver->name }} 
        vom {{ date_format(date_create($rechnung->date), 'd.m.Y') }}</h1>
    @if ($rechnung->company == 2)
        <div class="my1002">
    @else
        <div class="my1003">
    @endif
        <div>
            <h3>Rechnungsnummer: {{$rechnung->name}}
            @if (isset($rechnung->doc))
                 <a target="_blank" href="/uploads/Unternehmer-Rechnung_{{ $rechnung->id }}.pdf">Unternehmer-Rechnung.pdf </a> 
            @endif
        </h3>
        </div>
        <table class="table"> 
            <tr class="my1000">
                <th style="text-align: center">Tour-Nr.</th>
                <th style="text-align: center">Liefer-Datum</th>
                <th>Auftraggeber</th>
                <th colspan="3">Tourenbeschreibung</th>
                <th style="text-align: center">Netto</th>
                <th style="text-align: center"></th>
            </tr>
        @if ($rechnung->missions != null)
            @foreach($rechnung->missions as $mission)
                <tr class="my1001">
                    @if( $mission->deliveryNote != null)
                        <td style="width: 110px">
                            <a class="missionOK" 
                                target="_blank" 
                                href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
                            </a>
                        </td>
                    @else
                        <td style="width: 110px">
                            <a class="missionNotOK" 
                                target="_blank" 
                                href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
                            </a>
                        </td>
                    @endif
                    <td style="width: 120px; text-align: center">
                        {{ date_format(date_create($mission->zielDatum), 'd.m.Y') }}
                    </td>
                    <td>{{ $mission->customer->name}} </td>
                    <td>{{ $mission->startOrt }}</td>
                    <td> &rarr; </td>
                    <td>{{ $mission->zielOrt}}</td>
                    <td style="text-align: right; 
                            width: 150px">{{ number_format($mission->preisFahrer, 2, ',', ' ') }} €
                    </td>
                    <td style="text-align: center">
                        <button class="form-control" 
                                onclick="window.location.href=
                                    '/rechnung/sub/{{ $rechnung->id }}/{{ $mission->id}}'">
                            <b>-</b>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
            <tr class="my1001">
                <td colspan="5" style="text-align: right"><b>Summe</b></td>
                <td colspan="3" style="text-align: center; 
                                width: 150px">Netto: {{ number_format($rechnung->priceNet, 2, ',', ' ') }} € / Brutto: {{ number_format($rechnung->priceGross, 2, ',', ' ') }} € 
                        </td>
            </tr>
        </table><hr>    
        
        <h3>Auftrag hinzufügen</h3>
        <table class="table">
            <tr class="my1000">
                <th style="text-align: center">Tour-Nr.</th>
                <th style="text-align: center">Liefer-Datum</th>
                <th>Auftraggeber</th>
                <th colspan="3">Tourenbeschreibung</th>
                <th style="text-align: center">Netto</th>
                <th style="text-align: center"></th>
            </tr>
            @foreach($missions as $mission)
                    <tr class="my1001">
                        @if( $mission->deliveryNote != null)
                            <td style="width: 110px">
                                <a class="missionOK" 
                                    target="_blank" 
                                    href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
                                </a>
                            </td>
                        @else
                            <td style="width: 110px">
                                <a class="missionNotOK" 
                                    target="_blank" 
                                    href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
                                </a>
                            </td>
                        @endif
                        <td style="width: 120px; text-align: center">
                            {{ date_format(date_create($mission->zielDatum), 'd.m.Y') }}
                        </td>
                        <td>{{ $mission->customer->name}} </td>
                        <td>{{ $mission->startOrt }}</td>
                        <td> &rarr; </td>
                        <td>{{ $mission->zielOrt}}</td>
                        <td style="text-align: right; 
                                width: 150px">{{ number_format($mission->preisFahrer, 2, ',', ' ') }} €
                        </td>
                        <td style="text-align: center">
                            <button class="form-control" 
                                    onclick="window.location.href=
                                        '/rechnung/add/{{ $rechnung->id }}/{{ $mission->id}}'">
                                <b>+</b>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
    </div>
@endsection

