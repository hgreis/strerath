@extends('layouts.main')
@section('content')
	<div class="my1003">
		<h1 style="text-align: center">Fahrtenauflistung {{ $list->id }} - {{ $list->kunde->name}} </h1>
		<button class="form-control" 
				onclick="window.location.href=
					'/listing/{{ $list->id }}/printPDF'">
			<b>Eine neue PDF erzeugen !!!</b>
		</button><br>
		<table class="table">
			<tr class="my1000">
				<th style="text-align: center">Listen-Nr.</th>
				<th style="text-align: center">Liefer-Datum</th>
				<th colspan="3">Tourenbeschreibung</th>
				<th style="text-align: center">Bemerkung</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center"></th>
			</tr>
			@foreach($list->missions as $mission)
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
					<td>{{ $mission->startOrt }}</td>
					<td> &rarr; </td>
					<td>{{ $mission->zielOrt}}</td>
					<td>{{ $mission->kundeBemerkung }}</td>
					<td style="text-align: right; 
							width: 110px">{{ number_format($mission->preisFahrer, 2, ',', ' ') }} €
					</td>
					<td style="text-align: center">
						<button class="form-control" 
								onclick="window.location.href=
									'/listing/{{ $list->id }}/delete/{{ $mission->id}}'">
							<b>-</b>
						</button>
					</td>
				</tr>
			@endforeach
		</table>
		<h3>Auftrag hinzufügen</h3>
		<table class="table">
			<tr class="my1000">
				<th style="text-align: center">Listen-Nr.</th>
				<th style="text-align: center">Liefer-Datum</th>
				<th colspan="3">Tourenbeschreibung</th>
				<th style="text-align: center">Bemerkung</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center"></th>
			</tr>
			@foreach($missions->sortBy('zielDatum') as $mission)
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
					<td>{{ $mission->startOrt }}</td>
					<td> &rarr; </td>
					<td>{{ $mission->zielOrt}}</td>
					<td>{{ $mission->kundeBemerkung }}</td>
					<td style="text-align: right; 
							width: 150px">{{ number_format($mission->preisFahrer, 2, ',', ' ') }} €
					</td>
					<td style="text-align: center">
						<button class="form-control" 
								onclick="window.location.href=
									'/listing/{{ $list->id }}/add/{{ $mission->id}}'">
							<b>+</b>
						</button>
					</td>
				</tr>
			@endforeach					
		</table>
	</div>	
@endsection