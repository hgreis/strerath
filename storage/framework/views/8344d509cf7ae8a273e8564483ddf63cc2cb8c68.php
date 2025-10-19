<?php $__env->startSection('content'); ?>
	<div class="my1003">
		<h1 style="text-align: center">Fahrtenauflistung <?php echo e($list->id); ?> - <?php echo e($list->kunde->name); ?> </h1>
		<button class="form-control" 
				onclick="window.location.href=
					'/listing/<?php echo e($list->id); ?>/printPDF'">
			<b>Eine neue PDF erzeugen !!!</b>
		</button><br>
		<table class="table">
			<tr class="my1000">
				<th style="text-align: center">Listen-Nr.</th>
				<th style="text-align: center">Liefer-Datum</th>
				<th colspan="3">Tourenbeschreibung</th>
				<th style="text-align: center">Bemerkung</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center"></th>
			</tr>
			<?php $__currentLoopData = $list->missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
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
					<td style="width: 120px; text-align: center">
						<?php echo e(date_format(date_create($mission->zielDatum), 'd.m.Y')); ?>

					</td>
					<td><?php echo e($mission->startOrt); ?></td>
					<td> &rarr; </td>
					<td><?php echo e($mission->zielOrt); ?></td>
					<td><?php echo e($mission->kundeBemerkung); ?></td>
					<td style="text-align: right; 
							width: 110px"><?php echo e(number_format($mission->preisFahrer, 2, ',', ' ')); ?> €
					</td>
					<td style="text-align: center">
						<button class="form-control" 
								onclick="window.location.href=
									'/listing/<?php echo e($list->id); ?>/delete/<?php echo e($mission->id); ?>'">
							<b>-</b>
						</button>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
		<h3>Auftrag hinzufügen</h3>
		<table class="table">
			<tr class="my1000">
				<th style="text-align: center">Listen-Nr.</th>
				<th style="text-align: center">Liefer-Datum</th>
				<th colspan="3">Tourenbeschreibung</th>
				<th style="text-align: center">Bemerkung</th>
				<th style="text-align: center">Netto</th>
				<th style="text-align: center"></th>
			</tr>
			<?php $__currentLoopData = $missions->sortBy('zielDatum'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
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
					<td style="width: 120px; text-align: center">
						<?php echo e(date_format(date_create($mission->zielDatum), 'd.m.Y')); ?>

					</td>
					<td><?php echo e($mission->startOrt); ?></td>
					<td> &rarr; </td>
					<td><?php echo e($mission->zielOrt); ?></td>
					<td><?php echo e($mission->kundeBemerkung); ?></td>
					<td style="text-align: right; 
							width: 150px"><?php echo e(number_format($mission->preisFahrer, 2, ',', ' ')); ?> €
					</td>
					<td style="text-align: center">
						<button class="form-control" 
								onclick="window.location.href=
									'/listing/<?php echo e($list->id); ?>/add/<?php echo e($mission->id); ?>'">
							<b>+</b>
						</button>
					</td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
		</table>
	</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/listings/edit.blade.php ENDPATH**/ ?>