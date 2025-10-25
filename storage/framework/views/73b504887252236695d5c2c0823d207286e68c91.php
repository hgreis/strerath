<?php $__env->startSection('content'); ?>
<script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

<div>
    <h1 style="text-align: left">Strerath Transporte</h1><hr>
    <div class="row">
        <div class="col-sm-6">
            <div class="redbox">
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
        </div>
        <div class="col-sm-6">
                <div class="redbox">
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
        </div>
    </div>
</div>



<script>
    // Hole alle Elemente mit der Klasse "flip"
    var acc = document.getElementsByClassName("flip");
    var i;

    // Öffne alle Panels beim Start
    for (i = 0; i < acc.length; i++) {
        acc[i].classList.add("active");
        var panel = acc[i].nextElementSibling;
        panel.style.display = "block";

        // Toggle-Funktion aktivieren
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/menu_invoices.blade.php ENDPATH**/ ?>