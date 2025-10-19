<?php echo $__env->make('pages.datepicker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('content'); ?>
    <h1>Neuen Auftrag anlegen</h1>
        <form action="/mission/new" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

        <h3>
            
            <?php if($input->company == 2): ?>
                <input type="radio" name="company" value="1"> Strerath Transporte &nbsp &nbsp &nbsp
                <input type="radio" name="company" value="2" checked> <nobr> Sabine Heinrichs Transporte</nobr><br>
            <?php else: ?>
                <input type="radio" name="company" value="1" checked> Strerath Transporte &nbsp &nbsp &nbsp
                <input type="radio" name="company" value="2"> Sabine Heinrichs Transporte<br>
            <?php endif; ?>
        </h3>
        <div style="width: 45%; min-width: 400px; float: left" class="whitebox">
            <h3>Touren - Start</h3>
                        <?php echo e(Form::text('id', $input->id, ['hidden' => 'true'])); ?>

                        <?php echo e(Form::label('startDatum', 'Datum:')); ?>

                        <?php echo e(Form::text('startDatum', $input->startDatum, ['class' => 'date form-control', 'required'])); ?><br>
                        <?php echo e(Form::label('startOrt', 'PLZ und Stadt:')); ?>

                        <?php echo e(Form::text('startOrt', $input->startOrt, ['class' => 'form-control', 'required'])); ?>

        </div>

        <div style="width: 45%; min-width: 400px; float: right" class="whitebox">
            <h3>Touren - Ziel</h3>
                        <?php echo e(Form::label('zielDatum', 'Datum:')); ?>

                        <?php echo e(Form::text('zielDatum', $input->zielDatum, ['class' => 'date form-control', 'required'])); ?><br>
                        <?php echo e(Form::label('zielOrt', 'PLZ und Stadt:')); ?>

                        <?php echo e(Form::text('zielOrt', $input->zielOrt, ['class' => 'form-control', 'required'])); ?>

        </div>

        <div style="width: 45%; min-width: 400px; float: left" class="whitebox">
            <h3>Auftraggeber</h3>
            <?php echo e(Form::label('zielName', 'Name:')); ?>

            <select name='kunde' class='form-control'">
                <?php if(isset($input->kunde)): ?>
                    <option value="<?php echo e($input->kunde); ?>"><?php echo e($input->kunde); ?></option>
                <?php endif; ?>
                <option value="">---Bitte Auswählen---</option>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->name); ?>"><?php echo e($customer->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select><br>
            <?php echo e(Form::label('preisKunde', 'Preis (Euro):')); ?>

            <?php echo e(Form::text('preisKunde', $input->preisKunde, ['class' => 'form-control'])); ?><br>
            <?php if(isset($input->missionConfirmation)): ?>
                 <a target="_blank" href="/uploads/<?php echo e($input->id); ?> Auftragsbestaetigung.pdf"><?php echo e($input->id); ?> Auftragsbestätigung.pdf </a> 
            <?php else: ?>
                <label>Auftragsbestätigung:</label>
            <?php endif; ?>
            <input type="file" name="missionConfirmation"><br>
            <?php echo e(Form::label('kundeBemerkung', 'Bemerkung (Auftragsnummer, erscheint auf der Rechnung): ')); ?>

            <?php echo e(Form::text('kundeBemerkung', $input->kundeBemerkung, ['class' => 'form-control'])); ?><br>
        </div>    
        
        <div style="width: 45%; min-width: 400px; float: right" class="whitebox">
            <h3>Fahrer / Unternehmer</h3>
            <?php echo e(Form::label('fahrer', 'Name:')); ?>

            <select name='fahrer' class='form-control'>
                <?php if(isset($input->fahrer)): ?>
                    <option value="<?php echo e($input->fahrer); ?>"><?php echo e($input->fahrer); ?></option>
                <?php endif; ?>
                <option value="">---Bitte Auswählen---</option>
                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->name); ?>"><?php echo e($driver->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select><br>
            <?php echo e(Form::label('preisFahrer', 'Preis (Euro):')); ?>

            <?php echo e(Form::text('preisFahrer', $input->preisFahrer, ['class' => 'form-control'])); ?><br>
            <?php if(isset($input->deliveryNote)): ?>
                 <a target="_blank" href="/uploads/<?php echo e($input->id); ?> Lieferschein.pdf"><?php echo e($input->id); ?> Lieferschein.pdf </a> 
            <?php else: ?>
                    <label>Ablieferbeleg: </label>
            <?php endif; ?>
            <?php echo e(Form::file('deliveryNote')); ?><br>
            <?php echo e(Form::submit('Speichern/Menu', [
                    'class' => 'form-control',
                    'class' => 'blackButton', 
                    'name' => 'submit',
                    'style' => 'width: 100%' ])); ?>

        </div>
    </form>
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>  
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/missionNew.blade.php ENDPATH**/ ?>