<?php $__env->startSection('content'); ?>

<?php if($rechnungen->company == 2): ?>
	<div class="pinkbox">
<?php else: ?>
	<div class="redbox">
<?php endif; ?>

	<h1 style="text-align: center">Übersicht aller Unternehmer-Rechnungen</h1>
		<table class="table" align="center">
			<tr class="my1000">
				<th style="width: 90px">Datum</th>
				<th style="width: 90px">Bezahlt</th>
				<th>Unternehmer</th>
				<th>Rechnungsnummer</th>
				<th></th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center">Brutto</th>
			</tr>
			<?php $__currentLoopData = $rechnungen->sortBy('date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rechnung): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr class="my1001">
					<td><?php echo e(date_format(date_create($rechnung->date), 'd.m.Y')); ?></td>
					<?php if($rechnung->paid != null): ?>
						<td><?php echo e(date_format(date_create($rechnung->paid), 'd.m.Y')); ?></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>
					<td> <?php echo e($rechnung->driver->name); ?> </td>
					<td> <?php echo e($rechnung->name); ?> </td>
					<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/rechnung/edit/<?php echo e($rechnung->id); ?>'">
								<b>edit</b>
							</button>
					</td>
					<td style="text-align: right; width: 100px"><?php echo e(number_format($rechnung->priceNet, 2, ',', ' ')); ?> €</td>
					<td style="text-align: right; width: 100px"><?php echo e(number_format($rechnung->priceGross, 2, ',', ' ')); ?> €</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/rechnung/list.blade.php ENDPATH**/ ?>