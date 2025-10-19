@extends('layouts.main')

@section('content')
<script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<div style="max-width: 50%; min-width: 300px; margin: auto"> 
    <div>
        <div class="greybox">
            <h3>Auftrags - Menü</h3>
        </div>
        <div class="panel"  style="display: block">
            <button class="form-control" onclick="window.location.href='/mission/calendar '" >KALENDER </button>
            <button class="form-control" onclick="window.location.href='/mission/new '" >Auftrag anlegen </button>
            <button class="form-control" onclick="window.location.href='/mission/view'" >Auftrags Übersicht</button>
            <button class="form-control" onclick="window.location.href='/mission/viewNoDriver'" >Fahrer zuweisen</button>
            <button class="form-control" onclick="window.location.href='/mission/viewNoDeliveryNote '" >Lieferschein eingeben </button>
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