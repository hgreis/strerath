@extends('layouts.main')
@section('content')
	<div class="my1003">
		<h1 style="text-align: center">Gutschrift {{ $credit->number }} - {{ $credit->fahrer->name}} </h1>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/{{ $credit->id }}/printPDF/19'">
				<b>19% MwSt. PDF erzeugen !!!</b>
			</button><br>
		</div>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/{{ $credit->id }}/printPDF/300'">
				<b>§3 PDF erzeugen !!!</b>
			</button><br>
		</div>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/{{ $credit->id }}/printPDF/305'">
				<b>§4 PDF erzeugen !!!</b>
			</button><br>
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
				@foreach($credit->missions as $mission)
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
								width: 110px">{{ number_format($mission->preisFahrer, 2, ',', ' ') }} €
						</td>
						<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/credit/{{ $credit->id }}/delete/{{ $mission->id}}'">
								<b>-</b>
							</button>
						</td>
					</tr>
				@endforeach
				<tr class="my1001">
					<td colspan="6" style="text-align: right"><b>Summe: </td>
					<td style="text-align: right; width: 100px">
						<b>{{ number_format($credit->missions->sum('preisFahrer'), 2, ',', ' ') }} €
					</td><td></td>
				</tr>
			</table>
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
										'/credit/{{ $credit->id }}/add/{{ $mission->id}}'">
								<b> + </b>
							</button>
						</td>
					</tr>
				@endforeach					
			</table>
	</div>	
@endsection