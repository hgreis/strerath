@extends('layouts.main')

@section('content')
<script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

<div style="float: left; width: 50%; min-width: 400px">
    <h1 style="text-align: left">Strerath Transporte</h1><hr>
    <div class="redbox" style="width: 90%">
        <div class="flip">
            <h3>Auftraggeber</h3>
        </div>
        <div class="panel">
            <label>Rechnungen</label>
            <button class="form-control" onclick="window.location.href='/bill1'" >Rechnung generieren</button>
            <button class="form-control" onclick="window.location.href='/invoices/1'" >Rechnung - Übersicht</button>
            <button class="form-control" onclick="window.location.href='/invoicesPaid/1'" >Zahlungseingang</button>
            <br><label>Gutschriften</label>
            <button class="form-control" onclick="window.location.href='/unpaidMissions/1'" >
                eingereichte Gutschrift
            </button>
            <button class="form-control" onclick="window.location.href='/listing'" >
                Fahrtenauflistung erstellen
            </button>
            <button class="form-control" onclick="window.location.href='/listings'" >Fahrtenauflistungen</button>
        </div>
    </div>
    <div class="redbox" style="width: 90%">
        <div class="flip">
            <h3>Unternehmer</h3>
        </div>
        <div class="panel">
            <label>Gutschriften</label>
            <button class="form-control" onclick="window.location.href='/credits/1'" >Gutschrift erstellen</button>
            <button class="form-control" onclick="window.location.href='/listCredits/1'" >
                Gutschriften Übersicht
            </button>
            <button class="form-control" onclick="window.location.href='/payCredits/1'" >
                Überweisung bestätigen
            </button>
            <br><label>Rechnungen</label>
            <button class="form-control" onclick="window.location.href='/rechnung/new/1'" >eingereichte Rechnung</button>
            <button class="form-control" onclick="window.location.href='/rechnung/list/1'" >Rechnungen Übersicht</button>
            <button class="form-control" onclick="window.location.href='/rechnung/payList/1'" >Überweisung bestätigen</button>
        </div>
    </div>
</div>

<div style="float: left; width: 50%; min-width: 400px">
    <h1 style="text-align: left">Sabine Heinrichs Transporte</h1><hr>
    <div class="pinkbox" style="width: 90%">
        <div class="flip">
            <h3>Auftraggeber</h3>
        </div>
        <div class="panel">
            <label>Rechnungen</label>
            <button class="form-control" onclick="window.location.href='/bill2'" >Rechnung generieren</button>
            <button class="form-control" onclick="window.location.href='/invoices/2'" >Rechnung - Übersicht</button>
            <button class="form-control" onclick="window.location.href='/invoicesPaid/2'" >Zahlungseingang</button>
            <br><label>Gutschriften</label>
            <button class="form-control" onclick="window.location.href='/unpaidMissions/2'" >
                eingereichte Gutschrift
            </button>
        </div>
    </div>
    <div class="pinkbox" style="width: 90%">
        <div class="flip">
            <h3>Unternehmer</h3>
        </div>
        <div class="panel">
            <label>Rechnungen</label>
            <button class="form-control" onclick="window.location.href='/rechnung/new/2'" >eingereichte Rechnung</button>
            <button class="form-control" onclick="window.location.href='/rechnung/list/2'" >Rechnungen Übersicht</button>
            <button class="form-control" onclick="window.location.href='/rechnung/payList/2'" >Überweisung bestätigen</button>
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