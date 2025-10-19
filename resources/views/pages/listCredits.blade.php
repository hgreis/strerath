@extends('layouts.main')
@section('content')

@if($credits->company == 2)
	<div class="pinkbox">
@else
	<div class="redbox">
@endif

	<h1 style="text-align: center">Übersicht aller Gutschriften</h1>
		<table class="table" align="center">
			<tr class="my1000">
				<th>#</th>
				<th style="width: 90px">Datum</th>
				<th style="width: 90px">Bezahlt</th>
				<th colspan="2">Unternehmer</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center">Brutto</th>
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
					@if($credit->credit_paid != null)
						<td>{{ date_format(date_create($credit->credit_paid), 'd.m.Y') }}</td>
					@else
						<td></td>
					@endif
					<td>{{ $credit->driver->contractor }}</td>
					<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/credit/{{ $credit->id }}/edit'">
								<b>edit</b>
							</button>
					</td>
					<td style="text-align: right; width: 100px">{{ number_format($credit->priceNet, 2, ',', ' ') }} €</td>
					<td style="text-align: right; width: 100px">{{ number_format($credit->priceGross, 2, ',', ' ') }} €</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection