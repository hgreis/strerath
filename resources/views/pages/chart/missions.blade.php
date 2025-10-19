@extends('layouts.main')
@include('pages.datepicker')
@section('content')
    <h1>Auswertung: {{ $companies->start }} bis {{ $companies->end }}</h1>
    <div class="whitebox" style="text-align: center">
    	INFO: zur Berechnung werden alle Aufträge/Fahrten tagesgenau ausgewertet, unabhähngig ob eine Rechung bereits erstellt wurde oder nicht.
    </div>
    <div>
	    <div class="my1004">
	    	<h3> {{ $companies[0]->nameCompany }} </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr>
	    			<th>Umsatz</th>
	    			<td style="text-align: right;">{{ number_format($companies[0]->umsatz, 2) }} €</td>
	    		</tr>
	    		<tr>
	    			<th>Kosten</th>
	    			<td style="text-align: right;">{{ number_format($companies[0]->kosten, 2) }} €</td>
	    		</tr>
	    		<tr>
	    			<th>Gewinn</th>
	    			<td style="text-align: right;">{{ number_format($companies[0]->gewinn, 2) }} €</td>
	    		</tr>
	    	</table>
	    </div>
	    <div class="my1005">
	    	<h3 style="text-align: center"> {{ $companies[1]->nameCompany }} </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr style="color: black">
	    			<th>Umsatz</th>
	    			<td style="text-align: right;">{{ number_format($companies[1]->umsatz, 2) }} €</td>
	    		</tr>
	    		<tr style="color: black">
	    			<th>Kosten</th>
	    			<td style="text-align: right;">{{ number_format($companies[1]->kosten, 2) }} €</td>
	    		</tr>
	    		<tr style="color: black">
	    			<th>Gewinn</th>
	    			<td style="text-align: right;">{{ number_format($companies[1]->gewinn, 2) }} €</td>
	    		</tr>
	    	</table>
	    </div>
	    <div class="my1006">
	    	<h3 style="text-align: center"> {{ $companies[2]->nameCompany }} </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr>
	    			<th>Umsatz</th>
	    			<td style="text-align: right;">{{ number_format($companies[2]->umsatz, 2) }} €</td>
	    		</tr>
	    		<tr>
	    			<th>Kosten</th>
	    			<td style="text-align: right;">{{ number_format($companies[2]->kosten, 2) }} €</td>
	    		</tr>
	    		<tr>
	    			<th>Gewinn</th>
	    			<td style="text-align: right;">{{ number_format($companies[2]->gewinn, 2) }} €</td>
	    		</tr>
	    	</table>
	    </div>
    </div>
    <div style="clear: both; margin-top: 300px" >
		<h3>Berechnungszeitraum wählen</h3>    	
    	{{ Form::open(array('url' => 'chart', 'enctype' => 'multipart/form-data')) }}
            {{ csrf_field() }}
            <div style="float: left; margin: 10px">
	            {{ Form::label('startDatum', 'VON:') }}
	            {{ Form::text('startDatum', null, [
	            	'class' => 'date form-control', 'id' => 'datepicker']) }}
            </div>
            <div style="float: left; margin: 10px">
	            {{ Form::label('endDatum', 'BIS:') }}
	            {{ Form::text('endDatum', null, [
	            	'class' => 'date form-control']) }}
            </div>
            <div style="float: left; margin: 10px; padding-top: 30px">
	            {{ Form::submit('Anzeigen', [
	                    'class' => 'form-control',
	                    'name' => 'submit',
	                    'style' => 'width: 300px' ])}}
            </div>
		{{ Form::close() }}
    </div>



<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>  

@endsection

