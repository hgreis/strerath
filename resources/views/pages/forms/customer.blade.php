<div>
@if (isset($id))
	<h1>Kunde bearbeiten</h1><hr>
@else 
	<h1>Einen neuen Kunden anlegen</h1><hr>
@endif
	<form action="/dekra/save_customer" method="post">
		{{ csrf_field() }}
		<label>Firmenname / Name des Kunden</label>
		@if (isset($id))
			<input type="hidden" name="id" value="{{$id}}">
		@endif
		<input type="text" name="name" value="{{$customerToEdit->name}}" class="form-control" required>
		<label>Strasse & Hausnummer</label>
		<input type="text" name="street" value="{{$customerToEdit->street}}" class="form-control">
		<label>Postleitzahl & Stadt</label>
		<input type="text" name="city" value="{{$customerToEdit->city}}" class="form-control">
		<label>Land</label>
		<input type="text" name="country" value="{{$customerToEdit->country}}" class="form-control">
		<label>Steuer-Nummer</label>
		<input type="text" name="steuernr" value="{{$customerToEdit->steuernr}}" class="form-control">
		<label>Telefon / Mobiltelefon</label>
		<input type="text" name="phone" value="{{$customerToEdit->phone}}" class="form-control">
		<label>Emailadresse</label>
		<input type="text" name="email" value="{{$customerToEdit->email}}" class="form-control">
		<label>Bemerkungen</label>
		<textarea class="form-control" name="notice">{{$customerToEdit->notice}}</textarea><br>
		<label>Zahlungsziel: &nbsp;</label>
		<select name="duration" style="color: black">
			<option value="30">30 Tage</option>
			<option value="14">14 Tage</option>
			<option value="7">7 Tage</option>
		</select>´<br><br>
		{{ Form::submit('Senden', ['class' => 'form-control']) }}
	</form><hr>
</div>