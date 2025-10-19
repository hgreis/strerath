@extends('layouts.main')
@section('content')
	<h1>Rechnung generieren</h1>
	<form action="/saveBill" method="post">
		{{ csrf_field() }}
        <nobr>{{ Form::radio('taxes', 19, true)  }} 19% Mehrwertsteuer &emsp;</nobr>
        <nobr>{{ Form::radio('taxes', 300)  }} Mehrwertsteuerbefreit nach §3a &emsp;</nobr>
        <nobr>{{ Form::radio('taxes', 305)  }} Mehrwertsteuerbefreit nach §4 &emsp;</nobr>

		@foreach ($customers as $customer)
	@if ($customer->missions->count() != 0)
			@if($customers[0]->missions[0]->company == 2)
					<div class="pinkbox">
			@else
				<div class="redbox">
			@endif
				<h3>{{ $customer->name }}</h3>
				<table class="table">
					@foreach ($customer->missions->sortBy('startDatum') as $mission)
						<tr class="my1001">
							<td style="width: 50px; text-align: center">
								<input type="checkbox" name="{{ $mission->id }}"> &nbsp;
							</td>
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
							<td style="width: 100px">
								{{ date_format(date_create($mission->startDatum), 'd.m.Y') }}
							</td>
							<td>{{ $mission->startOrt }} -> {{ $mission->zielOrt}}</td>
							<td>{{ $mission->kundeBemerkung }}</td>
						</tr>
					@endforeach
				</table>
			</div>
	@endif
		@endforeach
		<input type="submit" name="submit" class="form-control">
	</form>
@endsection 