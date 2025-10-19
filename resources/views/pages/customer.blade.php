@extends('layouts.main')
@section('content') 
<div style="width: 45%; float: left">
		<h1>Kundenübersicht</h1><hr>
		@foreach ($customers as $customer)
				<div class="greybox">
					<div class="flip">
						<h3>{{ $customer->name }}</h3>
					</div>
					<div class="panel">
						{{ $customer->street }}<br>
						{{ $customer->city }} <br> 
						{{ $customer->country }}<br><br>
						Telefon: {{ $customer->phone }} <br>
						Email: {{$customer->email}}<br>
						Steuersatz: {{ $customer->taxes }} %<br>
						Notiz: {{$customer->notice}}<br>
						<button type="button" class="form-control" 
						onclick="window.location.href='/edit_customer/{{$customer->id}}'">
							EDIT
						</button>
					</div>
				</div>
			</a>
		@endforeach
</div>

<div style="width: 45%; float: right;">
	@include ('pages.forms.customer')
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