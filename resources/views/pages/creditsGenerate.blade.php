@extends('layouts.main')
@section('content')
	<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<h1>Unternehmer-Gutschrift erstellen</h1>
	<form action="/saveCredit" method="post">
				{{ csrf_field() }}
        <nobr>{{ Form::radio('taxes', 19, true)  }} 19% Mehrwertsteuer &emsp;</nobr>
        <nobr>{{ Form::radio('taxes', 300)  }} Mehrwertsteuerbefreit nach §3a &emsp;</nobr>
        <nobr>{{ Form::radio('taxes', 305)  }} Mehrwertsteuerbefreit nach §4 &emsp;</nobr>				
	
@foreach($drivers as $driver)
	@if($company == 2)
		<div class="pinkbox"> 
		<input type="hidden" name="company" value="2">
	@else
		<div class="redbox"> 
		<input type="hidden" name="company" value="1">
	@endif
			<div class="flip">
				<h3>{{ $driver->name }}</h3>
			</div>
			<div class='panel'>
				@foreach($driver->missions->sortBy('startDatum') as $mission)
					<table>
						<tr>
							<td>
								<input type="checkbox" name="{{ $mission->id }}">
							</td>
							@if( $mission->deliveryNote != null)
								<td style="width: 100px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}"
										style="color: black; background-color: green;">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>

							@else
								<td style="width: 100px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/{{ $mission->id }}"
										style="color: black; background-color: red;">Tour-Nr.: {{ $mission->id }}
									</a>
								</td>
							@endif
							<td style="width: 100px">{{ $mission->startDatum }}</td>
							<td style="width: 300px">{{ $mission->kunde}}</td>
							<td style="width: 200px">{{ $mission->startOrt}}</td>
							<td style="width: 200px">{{ $mission->zielOrt}}</td>
							<td>{{ $mission->preisFahrer}} €</td>
						</tr>
					</table>	
				@endforeach	
				<button class="form-control" 
						value="{{ $mission->fahrer }}"
						name="submit" 
						style="background-color: grey; color: white">
							<b>Gutschrift erstellen</b>
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