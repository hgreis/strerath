<?php $__env->startSection('content'); ?>
<?php if($credits->company == 2): ?>
	<div class="pinkbox">
<?php else: ?>
	<div class="redbox">
<?php endif; ?>

		<h1 style="text-align: center">Gutschriften - Überweisung bestätigen</h1>
		<table class="table" align="center" style="width: 80%">
			<tr class="my1000">
				<th style="text-align: center">#</th>
				<th style="width: 90px">Datum</th>
				<th>Unternehmer</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center">Brutto</th>
				<th></th>
			</tr>
			<?php $__currentLoopData = $credits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
					<td style="text-align: center; width: 80px">
						<?php if($credits->company == 2): ?>
							<a class="button" target="_blank" href="/Gutschriften/Sabine Heinrichs Transporte GS-<?php echo e($credit->number); ?>.pdf">GS-<?php echo e($credit->number); ?></a>
						<?php else: ?>
							<a class="button" target="_blank" href="/Gutschriften/Strerath Transporte GS-<?php echo e($credit->number); ?>.pdf">GS-<?php echo e($credit->number); ?></a>
						<?php endif; ?>
					</td>
					<td><?php echo e(date_format(date_create($credit->date), 'd.m.Y')); ?></td>
					<td><?php echo e($credit->driver->name); ?></td>
					<td style="text-align: right; width: 100px"><?php echo e(number_format($credit->priceNet, 2, ',', ' ')); ?> €</td>
					<td style="text-align: right; width: 100px"><?php echo e(number_format($credit->priceGross, 2, ',', ' ')); ?> €</td>
					<td style="text-align: center">
							<button type="button" onclick="window.location.href='/payCredit/<?php echo e($credit->id); ?>'">BEZAHLT</button>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/payCredits.blade.php ENDPATH**/ ?>