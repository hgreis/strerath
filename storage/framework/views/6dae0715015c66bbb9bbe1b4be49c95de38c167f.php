<?php $__env->startSection('content'); ?>
	<div class="redbox">
		<h1 style="text-align: center">Übersicht Fahrtenauflistungen</h1>
		<table class="table"  align="center">
			<tr>
				<th class="myth">Datum</th>
				<th class="myth">Auftraggeber</th>
				<th class="myth"></th>
				<th class="myth">Netto</th>
				<th class="myth">Brutto</th>
				<th class="myth">Details</th>
			</tr>
			<?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
					<td style="text-align: center;"><?php echo e(date_format(date_create($listing->date), 'd.m.Y')); ?></td>
					<td><?php echo e($listing->customer->name); ?></td>
					<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/listing/<?php echo e($listing->id); ?>/edit'">
								<b>edit</b>
							</button>
					</td>
					<td style="text-align: right; padding-right: 20px"><?php echo e(number_format($listing->priceNet,2)); ?> €</td>
					<td style="text-align: right"><?php echo e(number_format($listing->priceGross, 2)); ?> €</td>
					<td style="text-align: center; width: 120px">
							<a class="button" target="_blank" href="/Fahrtenauflistungen/Strerath Transporte Liste-<?php echo e($listing->id); ?>.pdf">Details</a>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/listingsList.blade.php ENDPATH**/ ?>