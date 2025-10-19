@extends('layouts.main')
@section('content')
	<div class="redbox">
		<h1 style="text-align: center">Übersicht Fahrtenauflistungen</h1>
		<table class="table"  align="center">
			<tr>
				<th class="myth">Datum</th>
				<th class="myth">Auftraggeber</th>
				<th class="myth"></th>
				<th class="myth">Netto</th>
				<th class="myth">Brutto</th>
				<th class="myth">Details</th>
			</tr>
			@foreach($listings as $listing)
				<tr class="my1001">
					<td style="text-align: center;">{{ date_format(date_create($listing->date), 'd.m.Y') }}</td>
					<td>{{ $listing->customer->name }}</td>
					<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/listing/{{ $listing->id }}/edit'">
								<b>edit</b>
							</button>
					</td>
					<td style="text-align: right; padding-right: 20px">{{ number_format($listing->priceNet,2) }} €</td>
					<td style="text-align: right">{{ number_format($listing->priceGross, 2) }} €</td>
					<td style="text-align: center; width: 120px">
							<a class="button" target="_blank" href="/Fahrtenauflistungen/Strerath Transporte Liste-{{$listing->id}}.pdf">Details</a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection