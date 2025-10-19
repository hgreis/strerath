@extends('layouts.main')
@section('content')

@if($rechnungen->company == 2)
	<div class="pinkbox">
@else
	<div class="redbox">
@endif

	<h1 style="text-align: center">Offene Unternehmer-Rechnungen</h1>
		<table class="table" align="center">
			<tr class="my1000">
				<th style="width: 90px">Datum</th>
				<th></th>
				<th>Unternehmer</th>
				<th>Rechnungsnummer</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center">Brutto</th>
				<th></th>
			</tr>
			@foreach($rechnungen->sortBy('date') as $rechnung)
			<tr class="my1001">
					<td>{{ date_format(date_create($rechnung->date), 'd.m.Y') }}</td>
					@if( $rechnung->proof == 0)
						<td style="color: green; font-size: 20px">
							 	&radic;
						</td>
					@else
						<td style="color: red; font-size: 20px">
							&otimes;
						</td>
					@endif
					<td> {{ $rechnung->driver->name }} </td>
					<td> {{ $rechnung->name }} </td>
					<td style="text-align: right; width: 100px">{{ number_format($rechnung->priceNet, 2, ',', ' ') }} €</td>
					<td style="text-align: right; width: 100px">{{ number_format($rechnung->priceGross, 2, ',', ' ') }} €</td>
					<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/rechnung/pay/{{ $rechnung->id }}'">
								<b>bezahlen</b>
							</button>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection