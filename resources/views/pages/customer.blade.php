@extends('layouts.main')
@section('content') 
<div class="container">
	<div class="row">
		<div class="col-sm-6">
					@include ('pages.forms.customer')
		</div>
		
		<div class="col-sm-6">
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
	</div>
</div>
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