<div style="width: 600px; float: left">
<h1>Auftrag <?php echo e($input->id); ?>: Kunde zuweisen</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

    <div class="form-group">
        <?php echo e(Form::label('zielName', 'Name:')); ?>

        <select name='kunde' class='form-control'">
                <?php if(isset($input->kunde)): ?>
                    <option value="<?php echo e($input->kunde); ?>"><?php echo e($input->kunde); ?></option>
                <?php endif; ?>
                <option value="">---Bitte Auswählen---</option>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->name); ?>"><?php echo e($customer->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <?php echo e(Form::label('kundeBemerkung', 'Bemerkung: dieser Hinweis erscheint auch auf der Rechnung')); ?>

        <?php echo e(Form::text('kundeBemerkung', $input->kundeBemerkung, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::hidden('id', $input->id)); ?>

        <?php echo e(Form::hidden('customer', 1)); ?>

        <?php echo e(Form::label('preisKunde', 'Preis:')); ?>

        <?php echo e(Form::text('preisKunde', $input->preisKunde, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php if(isset($input->missionConfirmation)): ?>
                 <a target="_blank" href="/uploads/<?php echo e($input->id); ?> Auftragsbestaetigung.pdf"><?php echo e($input->id); ?> Auftragsbestätigung.pdf </a> 
            <?php else: ?>
                <label>Auftragsbestätigung:</label>
            <?php endif; ?>
            <input type="file" name="missionConfirmation"><br>

    </div>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_customer.blade.php ENDPATH**/ ?>