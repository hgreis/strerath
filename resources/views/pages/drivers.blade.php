@extends('layouts.main')
@section('content')
<form action="/drivers" method="post">
			{{ csrf_field() }}
	<table style="width: 100%">
		<tr>
			<td style="padding-right: 10px">
				<label>Fahrer-Name: </label>
				<input type="text" class="form-control" name="name" value="{{$drivers->driver->name}}" required>
				<input type="hidden" name="id" value="{{ $drivers->driver->id }}">
				<label>Telefon:</label>
				<input type="text" name="phone" class="form-control" value="{{ $drivers->driver->phone }}">
				<label>Steuer-Nummer:</label>
				<input type="text" name="steuernr" class="form-control" value="{{ $drivers->driver->steuernr }}">
				<label>KFZ-Kennzeichen:</label>
				<input type="text" 
						name="number_plate" 
						class="form-control" 
						value="{{ $drivers->driver->number_plate }}">
			</td>
			<td>
				<label>Unternehmer:</label>
				<input type="text" 
						name="contractor" 
						class="form-control" 
						value="{{ $drivers->driver->contractor }}">	
				<label>Strasse:</label>
				<input type="text" name="street" class="form-control" value="{{ $drivers->driver->street }}">
				<label>Stadt:</label>
				<input type="text" name="city" class="form-control" value="{{ $drivers->driver->city }}" >
				<label>Emailadresse:</label>
				<input type="text" name="email" class="form-control" value="{{ $drivers->driver->email }}">
			</td>
		</tr>
	</table>
	<input type="Submit" class="form-control" style="margin-top: 20px" name="submit" value="Speichern">
</form><br>

<div class="whitebox">
	<h3>Übersicht aller Fahrer</h3>
	<table width="100%">
		<tr>
			<th style="padding: 5px">Name</th>
			<th>Fahrzeug-Typ</th>
			<th>KFZ-Kennzeichen</th>
			<th>Telefon</th>
			<th>Unternehmer</th>
		</tr>
		@foreach ($drivers as $driver)
	 		 <tr>
	 		 	<td><a href="/drivers/{{ $driver->id }}">{{ $driver->name }}</a></td>
	 		 	<td>{{ $driver->car_brand }}</td>
	 		 	<td>{{ $driver->number_plate }}</td>
	 		 	<td>{{$driver->phone}}</td>
	 		 	<td>{{ $driver->contractor }}</td>
	 		 </tr>
		@endforeach
	</table>
</div>

@endsection