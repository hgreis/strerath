<div class="whitebox">
<?php echo e(Form::hidden('id', $input->id)); ?>

<?php $__currentLoopData = $input->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e(Form::hidden('original', $sub->original)); ?>

    <?php echo e(Form::hidden('sub'.$sub->part, $sub->sub)); ?>

    <div class="flip">
        <b>Teilstrecke <?php echo e($sub->part); ?>: </b> <?php echo e($sub->mission->startOrt); ?> &rarr; <?php echo e($sub->mission->zielOrt); ?>

    </div>
    <div class="panel">
        <div class="my1013">
            <p class="my1011">
                <?php echo e(Form::label('zielOrt', 'bis', ['class' => 'form-control'])); ?>

            </p>
            <p class="my1012">
                <?php echo e(Form::text('zielOrt'.$sub->part, $sub->mission->zielOrt, ['class' => 'form-control'])); ?>

            </p>
        </div>

        <div class="my1013">
            <p class="my1011">
                <?php echo e(Form::label('fahrer'.$sub->part, 'Fahrer', [
                        'class' => 'form-control'])); ?>

            </p>
            <p class="my1012">
                <select name='fahrer<?php echo e($sub->part); ?>' class='form-control'">
                        <?php if(isset($sub->mission->fahrer)): ?>
                            <option value="<?php echo e($sub->mission->fahrer); ?>"><?php echo e($sub->mission->fahrer); ?></option>
                        <?php endif; ?>
                        <option value="">---Bitte Auswählen---</option>
                        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->name); ?>"><?php echo e($driver->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </p>
        </div>

        <div class="my1013">
            <p class="my1011">
                <?php echo e(Form::label('preisFahrer'.$sub->part, 'Preis', [
                        'class' => 'form-control'])); ?>

            </p>
            <p class="my1012">
                <?php echo e(Form::text('preisFahrer'.$sub->part, $sub->mission->preisFahrer, [
                    'class' => 'form-control'])); ?>

            </p><br>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<br><?php echo e(Form::submit('Aktualisieren', [
            'class' => 'form-control', 
            'name' => 'submit'])); ?><br>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_split_form.blade.php ENDPATH**/ ?>