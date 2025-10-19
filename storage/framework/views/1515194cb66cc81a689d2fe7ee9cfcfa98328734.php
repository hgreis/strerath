<?php $__env->startSection('content'); ?>
    <h1>Auftrag anlegen - Abholung</h1>
    <form route="tutorial_save" method="post">
        <?php echo e(Form::open(['route' => 'tutorial_save'])); ?>

            <?php echo e(csrf_field()); ?>

            <div style="width: 600px; float: left">
                <div class="form-group">
                    <?php echo e(Form::label('startDatum', 'Datum:')); ?>

                    <?php echo e(Form::text('startDatum', null, ['class' => 'form-control'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('startName', 'Name:')); ?>

                    <?php echo e(Form::text('startName', null, ['class' => 'form-control'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('startStrasse', 'Strasse und Hausnummer:')); ?>

                    <?php echo e(Form::text('startStrasse', null, ['class' => 'form-control'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('startOrt', 'PLZ und Stadt:')); ?>

                    <?php echo e(Form::text('city', null, ['class' => 'form-control'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('startLand', 'Land:')); ?>

                    <?php echo e(Form::text('startLand', 'Deutschland', ['class' => 'form-control'])); ?>

                </div>
                <div class="form-group">
                    <?php echo e(Form::label('startBemerkung', 'Bemerkung:')); ?>

                    <?php echo e(Form::textarea('startBemerkung', null, ['class' => 'form-control'])); ?>

                </div>
            </div>
            <div style="float: right; width: 300px; padding-top: 100px">
                <div class="form-group">
                    <?php echo e(Form::submit('Speichern', ['class' => 'form-control', 'name' => 'submit'])); ?>


                </div>
            </div>
        <?php echo e(Form::close()); ?>

    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/tutorial.blade.php ENDPATH**/ ?>