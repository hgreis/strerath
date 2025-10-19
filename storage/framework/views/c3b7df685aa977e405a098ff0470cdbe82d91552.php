<?php $__env->startSection('content'); ?>
<?php if($id == 2): ?>
	<div class="pinkbox">
<?php else: ?> 
	<div class="redbox">
<?php endif; ?>
		<h1 style="text-align: center">Übersicht aller offenen Rechnungen</h1>
			<table class="table">
				<tr class="my1000">
					<th style="text-align: center">#</th>
					<th style="text-align: center">Datum</th>
					<th>Kunde</th>
					<th style="text-align: center">Brutto</th>
					<th style="text-align: center">Bezahlt</th>
				</tr>
				<?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="my1001">
						<td style="text-align: center; width: 150px">
							<a class="button" target="_blank" href="/bill/<?php echo e($bill->id); ?>">
								Rechn.Nr.: <?php echo e($bill->number); ?>

							</a>
						</td>
						<td style="text-align: center"><?php echo e($bill->date); ?></td>
						<td><?php echo e($bill->customer); ?></td>
						<td style="text-align: right; 
								width: 150px"><?php echo e(number_format($bill->priceGross, 2, ',', ' ')); ?> €
						</td>
						<td style="text-align: center">
							<button class="form-control" onclick="window.location.href='/payBill/<?php echo e($bill->id); ?>'">BEZAHLT</button>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
	</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/invoicesPaid.blade.php ENDPATH**/ ?>