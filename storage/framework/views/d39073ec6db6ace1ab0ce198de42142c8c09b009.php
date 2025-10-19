<div style="width: 600px; float: left">
<?php if(isset($input->id)): ?>
    <h1>Auftrag <?php echo e($input->id); ?>: Touren-Start</h1>
<?php else: ?>
    <h1>Auftrag anlegen: Touren-Start</h1>
<?php endif; ?>
    <?php echo e(Form::open(['/mission/new'])); ?>

    <?php echo e(csrf_field()); ?>


    <div class="form-group">
        <?php echo e(Form::label('startDatum', 'Datum:')); ?>

        <?php echo e(Form::text('startDatum', $input->startDatum, ['class' => 'date form-control', 'required'])); ?>

        <?php echo e(Form::text('id', $input->id, ['hidden' => 'true'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('startName', 'Name:')); ?>

        <?php echo e(Form::text('startName', $input->startName, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('startStrasse', 'Strasse und Hausnummer:')); ?>

        <?php echo e(Form::text('startStrasse', $input->startStrasse, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('startOrt', 'Länderkennung - PLZ und Stadt:')); ?>

        <?php echo e(Form::text('startOrt', $input->startOrt, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('startBemerkung', 'Bemerkung:')); ?>

        <?php echo e(Form::text('startBemerkung', $input->startBemerkung, ['class' => 'form-control'])); ?>

    </div>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_start.blade.php ENDPATH**/ ?>