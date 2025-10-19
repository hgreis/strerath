@extends('layouts.main')
@section('content')
	<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<h1 style="text-align: center">Fahrtenauflistung zur Gutschriftserstellung</h1>
	<form action="/listingSave" method="post">
				{{ csrf_field() }}
	
@foreach($customers as $customer)
		<div class="redbox"> 
			<div class="flip">
				<h3>{{ $customer->name }}</h3>
			</div>
			<div class='panel'>
				@foreach($customer->missions->sortBy('startDatum') as $mission)
					<table>
						<tr>
							<td>
								<input type="checkbox" name="{{ $mission->id }}">
							</td>
							@if( $mission->deliveryNote != null)
								<td style="width: 100px">
									<a class="missionOK" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>

							@else
								<td style="width: 100px">
									<a class="missionNotOK" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>
							@endif
							<td style="width: 100px">{{ $mission->startDatum }}</td>
							<td style="width: 200px">{{ $mission->startOrt}}</td>
							<td style="width: 250px">&rarr; &nbsp {{ $mission->zielOrt}}</td>
							<td style="min-width: 200px">{{ $mission->kundeBemerkung}}</td>
							<td style="text-align: right; width: 80px">{{ $mission->preisKunde}} €</td>
						</tr>
					</table>	
				@endforeach	
				<button class="form-control" 
						value="{{ $mission->kunde }}"
						name="submit" 
						style="background-color: grey; color: white">
							<b>Auflistung erstellen</b>
				</button>	
			</div>
		</div>
@endforeach
	</div>
	</form>


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