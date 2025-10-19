<?php if($mission->company == 1): ?>
    <h2>STRERATH TRANSPORTE - Auftragsübersicht #<?php echo e($mission->id); ?></h2>
<?php else: ?>
    <h2>SABINE HEINRICHS TRANSPORTE - Auftragsübersicht #<?php echo e($mission->id); ?></h2>
<?php endif; ?>
    <h3>Touren-Details</h3>
        <table style="width: 100%">
            <tr>
                <th style="width: 50%">Abholung</th>
                <th style="width: 50%">Auslieferung</th>
            </tr>
            <tr>
                <td style="padding-right: 30px">
                    Datum: <?php echo e($mission->startDatum); ?><br>
                    Name: <?php echo e($mission->startName); ?><br>
                    Strasse: <?php echo e($mission->startStrasse); ?><br>
                    Ort: <?php echo e($mission->startOrt); ?><br>
                    Bemerkung: <?php echo e($mission->startBemerkung); ?>

                </td>
                <td>
                    Datum: <?php echo e($mission->zielDatum); ?><br>
                    Name: <?php echo e($mission->zielName); ?><br>
                    Strasse: <?php echo e($mission->zielStrasse); ?><br>
                    Ort: <?php echo e($mission->zielOrt); ?><br>
                    Bemerkung: <?php echo e($mission->zielBemerkung); ?>

                </td>
            </tr><tr><td>&nbsp;</td></tr>
            <tr>
                <td>Auftragsbestätigung: 
                    <?php if($mission->missionConfirmation == null): ?>
                        <b style="color: red">KEINE AUFTRAGSBESTÄTIGUNG HINTERLEGT</b>
                    <?php else: ?>
                        <a href="/uploads/<?php echo e($mission->id); ?> Auftragsbestaetigung.pdf" target="_blank"><?php echo e($mission->id); ?> Auftragsbestätigung.pdf </a>
                    <?php endif; ?>
                </td>
                <td>Ablieferbeleg: 
                    <?php if($mission->deliveryNote == null): ?>
                        <b style="color: red">KEIN ABLIEFERBELEG HINTERLEGT</b>
                    <?php else: ?>
                        <a href="/uploads/<?php echo e($mission->id); ?> Lieferschein.pdf" target="_blank"><?php echo e($mission->id); ?> Ablieferbeleg.pdf </a>
                    <?php endif; ?>
                </td>
            </tr>
        </table><hr>
    <h3>Fahrer-Details</h3>
        <table style="width: 100%">
            <tr>
                <th><b>Fahrer</b></th>
                <th><b>Unternehmer</b></th>
                <th><b>Vergütung</b></th>
            </tr>
            <tr>
                <?php if(isset($mission->driver)): ?>
                    <td>
                        Name: <?php echo e($mission->driver->name); ?><br>
                        Telefon: <?php echo e($mission->driver->phone); ?><br>
                        Nummernschild: <?php echo e($mission->driver->number_plate); ?>

                    </td>
                    <td>
                        Firma: <?php echo e($mission->driver->contractor); ?><br>
                        Anschrift: <?php echo e($mission->driver->street); ?>, <?php echo e($mission->driver->city); ?><br>
                        Emailadresse: <?php echo e($mission->driver->email); ?>

                    </td>
                <?php else: ?>
                    <td>KEIN FAHRER AUSGEWÄHLT</td>
                    <td></td>
                <?php endif; ?>
                <td>
                    Vereinbarter Preis: <?php echo e(number_format($mission->preisFahrer, 2)); ?> €<br>
                    Gutschrift-Nr.: <?php echo e($mission->credit); ?> <br>
                    Bezahlt am: <?php echo e($mission->credit_paid); ?>

                </td>
            </tr>
        </table><hr>
    <h3>Auftraggeber</h3>
        <table style="width: 100%">
            <tr>
                <td>
                    <b><?php echo e($mission->customer->name); ?></b><br>
                    <?php echo e($mission->customer->street); ?><br>
                    <?php echo e($mission->customer->city); ?><br>
                </td>
                <td>
                    <b>Kontaktdaten:</b><br>
                    Telefon: <?php echo e($mission->customer->phone); ?><br>
                    Email: <?php echo e($mission->customer->email); ?>

                </td>
                <td>
                    Tourenpreis: <?php echo e(number_format($mission->preisKunde, 2)); ?> €<br>
                        <?php if(isset($mission->bill_id)): ?>
                            Rechnungsnummer: RE-<?php echo e($mission->bill_number); ?><br>
                        <?php else: ?>
                            <b style="color: red"> ES WURDE NOCH KEINE RECHNUNG ERSTELLT</b><br>
                        <?php endif; ?>
                    Rechnungsbetrag: <?php echo e(number_format($mission->bill_price,2)); ?>€<br>
                    Zahlungseingang: <?php echo e($mission->bill_paid); ?><br>
                </td>
            </tr>
        </table>
<?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_details.blade.php ENDPATH**/ ?>