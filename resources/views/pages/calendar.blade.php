@extends('layouts.main')

@section('content')
<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

<?php
	$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
?>

	<h1>Kalender-Ansicht - alle Aufträge</h1>
	@foreach($missions as $date)
		<?php
			$tag = date_format(date_create($date[0]->startDatum), 'w');
		?>
		<div class="greybox">
			<div class="flip">
				<h3>{{ date_format(date_create($date[0]->startDatum), 'd.m.Y') }} {{ $tage[$tag] }}</h3>
			</div>
			<div class="panel">
				<table style="width: 100%">
					<tr class="myth">
						<th>#</th>
						<th>Fahrer</th>
						<th>Auftraggeber</th>
						<th>Beschreibung</th>
						<th style="text-align: center">Kosten</th>
						<th style="text-align: center">Umsatz</th>
						<th style="text-align: center">Gewinn</th>
					</tr>
					@foreach($date->sortBy('fahrer') as $mission)
						@if($mission->company == 2)
							<tr style="background-color: yellow">
						@else
							<tr>
						@endif
							@if( $mission->deliveryNote != null)
									<td style="width: 100px">
										<a class="missionOK" 
											target="_blank" 
											href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
										</a>
									</td>
							@else
									<td style="width: 100px">
										<a class="missionNotOK" 
											target="_blank" 
											href="/mission/{{ $mission->id }}/details">Tour-Nr.: {{ $mission->id }}
										</a>
									</td>
							@endif
							<td>
								<a href="/mission/view/{{$mission->id}}/driver">
									{{ $mission->fahrer }}
								</a>
							</td>
							<td>
								<a href="/mission/view/{{$mission->id}}/customer">
									{{ $mission->kunde }}
								</td>
							<td style="max-width: 300px">
								{{ $mission->startOrt }} &rarr; {{ $mission->zielOrt }}
							</td>
							<td style="text-align: right">{{ number_format($mission->preisFahrer, 2) }} € </td>
							<td style="text-align: right">{{ number_format($mission->preisKunde, 2) }} € </td>
							<td style="text-align: right">
								{{ number_format($mission->preisKunde-$mission->preisFahrer, 2) }} € 
							</td>
						</tr>
					@endforeach
					<tr>
						<td colspan="7">
							<button class="form-control" 
									onclick="window.location.href='/mission/new/{{ $mission->startDatum }}'">
								Auftrag Hinzufügen
							</bu	tton>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right"><b>Summe:</b></td>
						<td style="text-align: right">
							<b>{{ number_format($date->sum('preisFahrer'), 2) }} €</b>
						</td>
						<td style="text-align: right">
							<b>{{ number_format($date->sum('preisKunde'), 2) }} €</b>
						</td>
						<td style="text-align: right">
							<b>{{ number_format($date->sum('preisKunde')-$date->sum('preisFahrer'), 2) }} €</b>
						</td>
					</tr>
				</table>
			</div>
		</div>
	@endforeach





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