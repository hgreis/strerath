@extends('layouts.main')
@section('content')
@if($credits->company == 2)
	<div class="pinkbox">
@else
	<div class="redbox">
@endif

		<h1 style="text-align: center">Gutschriften - Überweisung bestätigen</h1>
		<table class="table" align="center" style="width: 80%">
			<tr class="my1000">
				<th style="text-align: center">#</th>
				<th style="width: 90px">Datum</th>
				<th>Unternehmer</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center">Brutto</th>
				<th></th>
			</tr>
			@foreach( $credits as $credit)
				<tr class="my1001">
					<td style="text-align: center; width: 80px">
						@if($credits->company == 2)
							<a class="button" target="_blank" href="/Gutschriften/Sabine Heinrichs Transporte GS-{{$credit->number}}.pdf">GS-{{ $credit->number }}</a>
						@else
							<a class="button" target="_blank" href="/Gutschriften/Strerath Transporte GS-{{$credit->number}}.pdf">GS-{{ $credit->number }}</a>
						@endif
					</td>
					<td>{{ date_format(date_create($credit->date), 'd.m.Y') }}</td>
					<td>{{ $credit->driver->name }}</td>
					<td style="text-align: right; width: 100px">{{ number_format($credit->priceNet, 2, ',', ' ') }} €</td>
					<td style="text-align: right; width: 100px">{{ number_format($credit->priceGross, 2, ',', ' ') }} €</td>
					<td style="text-align: center">
							<button type="button" onclick="window.location.href='/payCredit/{{ $credit->id }}'">BEZAHLT</button>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection