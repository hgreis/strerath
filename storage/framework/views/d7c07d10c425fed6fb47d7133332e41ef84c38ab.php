<?php echo $__env->make('pages.datepicker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('content'); ?>
            
            <?php if($choice == 'Touren-Start'): ?>
            	<?php echo $__env->make('pages.forms.mission_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif($choice == 'Touren-Ziel'): ?>
            	<?php echo $__env->make('pages.forms.mission_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif($choice == 'Kunde'): ?>
                <?php echo $__env->make('pages.forms.mission_customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif($choice == 'Fahrer/Unternehmer'): ?>
                <?php echo $__env->make('pages.forms.mission_driver', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif($choice == 'Auftrag Löschen'): ?>
                <?php echo $__env->make('pages.forms.mission_delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif($choice == 'Tour aufteilen'): ?>
                <?php echo $__env->make('pages.forms.mission_split', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php echo $__env->make('pages.forms.mission_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo e(Form::close()); ?>

<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>          
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/mission.blade.php ENDPATH**/ ?>