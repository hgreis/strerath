@extends('layouts.main')
@section('content')
@if ($id == 2)
	<div class="pinkbox">
@else 
	<div class="redbox">
@endif
		<h1 style="text-align: center">Übersicht aller offenen Rechnungen</h1>
			<table class="table">
				<tr class="my1000">
					<th style="text-align: center">#</th>
					<th style="text-align: center">Datum</th>
					<th>Kunde</th>
					<th style="text-align: center">Brutto</th>
					<th style="text-align: center">Bezahlt</th>
				</tr>
				@foreach($bills as $bill)
					<tr class="my1001">
						<td style="text-align: center; width: 150px">
							<a class="button" target="_blank" href="/bill/{{ $bill->id }}">
								Rechn.Nr.: {{ $bill->number }}
							</a>
						</td>
						<td style="text-align: center">{{ $bill->date }}</td>
						<td>{{ $bill->customer }}</td>
						<td style="text-align: right; 
								width: 150px">{{ number_format($bill->priceGross, 2, ',', ' ') }} €
						</td>
						<td style="text-align: center">
							<button class="form-control" onclick="window.location.href='/payBill/{{$bill->id}}'">BEZAHLT</button>
						</td>
					</tr>
				@endforeach
			</table>
	</div>	
@endsection