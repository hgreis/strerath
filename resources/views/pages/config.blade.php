@extends('layouts.main')
@section('content')
	<h1>Konfiguration</h1>
	<form action="/config" method="post" enctype="multipart/form-date"> {{ csrf_field() }}
		<div style="width: 400px; float: left"> 
			<label>Firmenname</label>
			<input list="nameCompany" 
					name="nameCompany"
					@isset($company) 
						value="{{$company->nameCompany}}"
					@endisset
					class="form-control"
					required>
			@isset ($companies)
				<datalist id="nameCompany">
					@foreach ($companies as $company)
						<option>{{ $company->nameCompany  }}</option>o
						<?php $company = null; ?>
					@endforeach
				</datalist>
			@endisset
			<label>Inhaber</label>
			<input type="text" 
					name="nameOwner" 
					value="{{$company->nameOwner}}"
					class="form-control">
			<label>Strasse & Hausnummer</label>
			<input type="text" 
					name="street" 
					value="{{$company->street}}"
					class="form-control">
			<label>Postleitzahl & Stadt</label>
			<input type="text" 
					name="city" 
					value="{{$company->city}}"
					class="form-control">
			<label>Land</label>
			<input type="text" 
					name="country" 
					value="{{$company->country}}"
					class="form-control">
			<label>Telefon - Festnetz</label>
			<input type="text" 
					name="phone" 
					value="{{$company->phone}}"
					class="form-control">
			<label>Telefon - Mobil</label>
			<input type="text" 
					name="cellphone" 
					value="{{$company->cellphone}}"
					class="form-control">
			<label>Emailadresse</label>
			<input type="text" 
					name="email" 
					value="{{$company->email}}"
					class="form-control">
			<label>Homepage</label>
			<input type="text" 
					name="url" 
					value="{{$company->url}}"
					class="form-control">
			<label>Steuernummer</label>
			<input type="text" 
					name="taxNumber" 
					value="{{$company->taxNumber}}"
					class="form-control">
			<label>Gerichtsstand</label>
			<input type="text" 
					name="venue" 
					value="{{$company->venue}}"
					class="form-control">
		</div>
		<div style="width: 400px;float: right">
			<label>Bank</label>
			<input type="text" 
					name="bank" 
					value="{{$company->bank}}"
					class="form-control">
			<label>IBAN - Nummer</label>
			<input type="text" 
					name="iban" 
					value="{{$company->iban}}"
					class="form-control">
			<label>BIC - Nummer</label>
			<input type="text" 
					name="bic" 
					value="{{$company->bic}}"
					class="form-control"><br>
			<br><br><h3 style="text-align: center">Logo</h3>
			<input type="file" name="logo">
		</div>
		@isset($company->id)
			<input type="text" name="saved" value="{{$company->id}}">
		@endisset
		<input type="submit" name="submit" value="Speichern" class="form-control">
	</form>
@endsection