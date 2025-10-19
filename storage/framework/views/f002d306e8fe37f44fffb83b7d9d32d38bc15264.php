<div style="width: 600px; float: left">
<h1>Auftrag <?php echo e($input->id); ?>: Touren-Ziel</h1>
    <?php echo e(Form::open(['/mission/new'])); ?>

    <?php echo e(csrf_field()); ?>

    <div class="form-group">
        <?php echo e(Form::label('zielDatum', 'Datum:')); ?>

        <?php echo e(Form::text('zielDatum', $input->zielDatum, ['class' => 'date form-control'])); ?>

        <?php echo e(Form::hidden('id', $input->id)); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('zielName', 'Name:')); ?>

        <?php echo e(Form::text('zielName', $input->zielName, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('zielStrasse', 'Strasse und Hausnummer:')); ?>

        <?php echo e(Form::text('zielStrasse', $input->zielStrasse, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('zielOrt', 'PLZ und Stadt:')); ?>

        <?php echo e(Form::text('zielOrt', $input->zielOrt, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('zielBemerkung', 'Bemerkung:')); ?>

        <?php echo e(Form::text('zielBemerkung', $input->zielBemerkung, ['class' => 'form-control'])); ?>

    </div>
    
</div> <?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_end.blade.php ENDPATH**/ ?>