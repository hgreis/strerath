<div style="width: 600px; float: left">
    <h1>Auftrag <?php echo e($input->id); ?>: Fahrer zuweisen</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

    <div class="form-group">
        <?php echo e(Form::label('fahrer', 'Name:')); ?>

        <select name='fahrer' class='form-control'">
                <?php if(isset($input->fahrer)): ?>
                    <option value="<?php echo e($input->fahrer); ?>"><?php echo e($input->fahrer); ?></option>
                <?php endif; ?>
                <option value="">---Bitte Auswählen---</option>
                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->name); ?>"><?php echo e($driver->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <?php echo e(Form::hidden('id', $input->id)); ?>

        <?php echo e(Form::hidden('customer', 1)); ?>

        <?php echo e(Form::label('preisFahrer', 'Preis:')); ?>

        <?php echo e(Form::text('preisFahrer', $input->preisFahrer, ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group">
        <?php if(isset($input->deliveryNote)): ?>
                 <a target="_blank" href="/uploads/<?php echo e($input->id); ?> Lieferschein.pdf"><?php echo e($input->id); ?> Lieferschein.pdf </a> 
        <?php else: ?>
                <label>Ablieferbeleg: </label>
        <?php endif; ?>
        <?php echo e(Form::file('deliveryNote')); ?>

    </div>
    <div class="whitebox2">        
        <?php echo $__env->make('pages.forms.mission_driver_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_driver.blade.php ENDPATH**/ ?>