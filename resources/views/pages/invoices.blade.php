@extends('layouts.main')
@section('content')
@if ($id == 2)
	<div class="pinkbox">
@else 
	<div class="redbox">
@endif
		<h1 style="text-align: center">Übersicht aller Rechnungen</h1>
		<table class="table">
			<tr class="my1000">
				<th style="padding: 3px; text-align: center">#</th>
				<th style="padding: 3px; text-align: center">Datum</th>
				<th style="padding: 3px">Kunde</th>
				<th style="padding: 3px; text-align: center">Netto</th>
				<th style="padding: 3px; text-align: center">Brutto</th>
				<th style="padding: 3px; text-align: center">Bezahlt</th>
			</tr>
			@foreach($bills as $bill)
				<tr class="my1001">
					<td style="padding: 3px; text-align: center">
						<a class="button" target="_blank" href="/bill/{{ $bill->id }}">
							Rechn.Nr.: {{ $bill->number }}
						</a>
					</td>
					<td style="text-align: center">{{ $bill->date }}</td>
					<td style="padding: 3px">{{ $bill->customer }}</td>
					<td style="padding: 3px; text-align: right">
						{{ number_format($bill->priceNet, 2, ',', ' ') }} €
					</td>
					<td style="padding: 3px; text-align: right">
						{{ number_format($bill->priceGross, 2, ',', ' ') }} €
						</td>
						@if ($bill->paid == null)
							<td></td>
						@else
							<td style="padding: 3px; text-align: center">{{ date_format($bill->paid, 'd.m.Y') }} </td>
						@endif
				</tr>
			@endforeach
		</table>
	</div>	
@endsection