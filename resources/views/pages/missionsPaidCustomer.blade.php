@extends('layouts.main')
@section('content')
	<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<h1 style="text-align: center">Fahrten quittieren</h1>
	@if($missions->company == 1)
		<div class="redbox">
	@else
		<div class="pinkbox">
	@endif
		@foreach($missions as $customer)
			<h3> {{ $customer[0]->kunde }} </h3>
				<table class="table">
					<tr class="my1000">
						<th>#</th>
						<th>Datum</th>
						<th>Beschreibung</th>
						<th>Bemerkung</th>
						<th>Netto</th>
						<th></th>
					</tr>
					@foreach($customer->sortBy('startDatum') as $mission)
						<tr class="my1001">
							@if( $mission->deliveryNote != null)
								<td style="width: 130px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}"
										style="color: black; background-color: green;">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>
							@else
								<td style="width: 130px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}"
										style="color: black; background-color: red;">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>
							@endif
							<td style="text-align: center">
								{{ date_format(date_create($mission->startDatum), 'd.m.Y') }}
							</td>
							<td>{{ $mission->startOrt }} -> {{ $mission->zielOrt }} </td>
							<td> {{ $mission->kundeBemerkung }} </td>
							<td style="text-align: right; padding-right: 15px"> {{ number_format($mission->preisKunde,2)  }} </td>
							<td>
								<button class="form-control" onclick="window.location.href='/payMission/{{ $mission->id }}'">BEZAHLT</button>
							</td>
						</tr>
					@endforeach
				</table>
		@endforeach
	</div>



	<script>
		var acc = document.getElementsByClassName("flip");
		var i;

		for (i = 0; i < acc.length; i++) {
		    acc[i].addEventListener("click", function() {
		        this.classList.toggle("active");
		        var panel = this.nextElementSibling;
		        if (panel.style.display === "block") {
		            panel.style.display = "none";
		        } else {
		            panel.style.display = "block";
		        }
		    });
		}
	</script>
@endsection