@if ($input->company == 1)
	<h3>Strerath Transporte #{{ $input->id }}</h3>
@elseif ($input->company == 2)
	<h3>Sabine Heinrichs Transporte #{{ $input->id }}</h3>
@else
	<h3>Fahrer - Informationen</h3>
@endif
<p>
    <hr><b>Abholung: {{$input->startDatum}}</b><br>
    {{ $input->startName }} <br>
    {{ $input->startStrasse }}, {{ $input->startOrt }}, {{ $input->startLand }}<br>
    Hinweis: {{$input->startBemerkung }}
    <hr><b>Auslieferung: {{$input->zielDatum}}</b><br>
    {{ $input->zielName }} <br>
    {{ $input->zielStrasse }}, {{ $input->zielOrt }}, {{ $input->zielLand }}<br>
    Hinweis: {{$input->zielBemerkung }}
</p>