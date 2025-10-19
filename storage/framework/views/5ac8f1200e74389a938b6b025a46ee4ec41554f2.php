<?php $__env->startSection('content'); ?>
<?php if($id == 2): ?>
	<div class="pinkbox">
<?php else: ?> 
	<div class="redbox">
<?php endif; ?>
		<h1 style="text-align: center">Übersicht aller Rechnungen</h1>
		<table class="table">
			<tr class="my1000">
				<th style="padding: 3px; text-align: center">#</th>
				<th style="padding: 3px; text-align: center">Datum</th>
				<th style="padding: 3px">Kunde</th>
				<th style="padding: 3px; text-align: center">Netto</th>
				<th style="padding: 3px; text-align: center">Brutto</th>
				<th style="padding: 3px; text-align: center">Bezahlt</th>
			</tr>
			<?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
					<td style="padding: 3px; text-align: center">
						<a class="button" target="_blank" href="/bill/<?php echo e($bill->id); ?>">
							Rechn.Nr.: <?php echo e($bill->number); ?>

						</a>
					</td>
					<td style="text-align: center"><?php echo e($bill->date); ?></td>
					<td style="padding: 3px"><?php echo e($bill->customer); ?></td>
					<td style="padding: 3px; text-align: right">
						<?php echo e(number_format($bill->priceNet, 2, ',', ' ')); ?> €
					</td>
					<td style="padding: 3px; text-align: right">
						<?php echo e(number_format($bill->priceGross, 2, ',', ' ')); ?> €
						</td>
						<?php if($bill->paid == null): ?>
							<td></td>
						<?php else: ?>
							<td style="padding: 3px; text-align: center"><?php echo e(date_format($bill->paid, 'd.m.Y')); ?> </td>
						<?php endif; ?>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/invoices.blade.php ENDPATH**/ ?>