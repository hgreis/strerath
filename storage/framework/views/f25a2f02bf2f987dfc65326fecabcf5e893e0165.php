<?php if($input->company == 1): ?>
	<h3>Strerath Transporte #<?php echo e($input->id); ?></h3>
<?php elseif($input->company == 2): ?>
	<h3>Sabine Heinrichs Transporte #<?php echo e($input->id); ?></h3>
<?php else: ?>
	<h3>Fahrer - Informationen</h3>
<?php endif; ?>
<p>
    <hr><b>Abholung: <?php echo e($input->startDatum); ?></b><br>
    <?php echo e($input->startName); ?> <br>
    <?php echo e($input->startStrasse); ?>, <?php echo e($input->startOrt); ?>, <?php echo e($input->startLand); ?><br>
    Hinweis: <?php echo e($input->startBemerkung); ?>

    <hr><b>Auslieferung: <?php echo e($input->zielDatum); ?></b><br>
    <?php echo e($input->zielName); ?> <br>
    <?php echo e($input->zielStrasse); ?>, <?php echo e($input->zielOrt); ?>, <?php echo e($input->zielLand); ?><br>
    Hinweis: <?php echo e($input->zielBemerkung); ?>

</p><?php /**PATH /var/www/strerath/resources/views/pages/forms/mission_driver_info.blade.php ENDPATH**/ ?>