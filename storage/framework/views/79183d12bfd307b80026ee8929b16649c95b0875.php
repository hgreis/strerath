<?php $__env->startSection('content'); ?>
	<h1>Rechnung generieren</h1>
	<form action="/saveBill" method="post">
		<?php echo e(csrf_field()); ?>

        <nobr><?php echo e(Form::radio('taxes', 19, true)); ?> 19% Mehrwertsteuer &emsp;</nobr>
        <nobr><?php echo e(Form::radio('taxes', 300)); ?> Mehrwertsteuerbefreit nach §3a &emsp;</nobr>
        <nobr><?php echo e(Form::radio('taxes', 305)); ?> Mehrwertsteuerbefreit nach §4 &emsp;</nobr>

		<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($customer->missions->count() != 0): ?>
			<?php if($customers[0]->missions[0]->company == 2): ?>
					<div class="pinkbox">
			<?php else: ?>
				<div class="redbox">
			<?php endif; ?>
				<h3><?php echo e($customer->name); ?></h3>
				<table class="table">
					<?php $__currentLoopData = $customer->missions->sortBy('startDatum'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="my1001">
							<td style="width: 50px; text-align: center">
								<input type="checkbox" name="<?php echo e($mission->id); ?>"> &nbsp;
							</td>
							<?php if( $mission->deliveryNote != null): ?>
								<td style="width: 110px">
									<a class="missionOK" 
										target="_blank" 
										href="/mission/<?php echo e($mission->id); ?>/details">Tour-Nr.: <?php echo e($mission->id); ?>

									</a>
								</td>
							<?php else: ?>
								<td style="width: 110px">
									<a class="missionNotOK" 
										target="_blank" 
										href="/mission/<?php echo e($mission->id); ?>/details">Tour-Nr.: <?php echo e($mission->id); ?>

									</a>
								</td>
							<?php endif; ?>
							<td style="width: 100px">
								<?php echo e(date_format(date_create($mission->startDatum), 'd.m.Y')); ?>

							</td>
							<td><?php echo e($mission->startOrt); ?> -> <?php echo e($mission->zielOrt); ?></td>
							<td><?php echo e($mission->kundeBemerkung); ?></td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
			</div>
	<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<input type="submit" name="submit" class="form-control">
	</form>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/bill.blade.php ENDPATH**/ ?>