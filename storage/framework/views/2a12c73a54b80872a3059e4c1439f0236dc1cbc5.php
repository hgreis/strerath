<?php $__env->startSection('content'); ?>
	<div class="my1003">
		<h1 style="text-align: center">Gutschrift <?php echo e($credit->number); ?> - <?php echo e($credit->fahrer->name); ?> </h1>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/<?php echo e($credit->id); ?>/printPDF/19'">
				<b>19% MwSt. PDF erzeugen !!!</b>
			</button><br>
		</div>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/<?php echo e($credit->id); ?>/printPDF/300'">
				<b>§3 PDF erzeugen !!!</b>
			</button><br>
		</div>
		<div class="my1014">
			<button class="form-control" 
					onclick="window.location.href=
						'/credit/<?php echo e($credit->id); ?>/printPDF/305'">
				<b>§4 PDF erzeugen !!!</b>
			</button><br>
		</div>

			<table class="table">
				<tr class="my1000">
					<th style="text-align: center">Tour-Nr.</th>
					<th style="text-align: center">Liefer-Datum</th>
					<th>Auftraggeber</th>
					<th colspan="3">Tourenbeschreibung</th>
					<th style="text-align: center">Netto</th>
					<th style="text-align: center"></th>
				</tr>
				<?php $__currentLoopData = $credit->missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
						<td><?php echo e($mission->customer->name); ?> </td>
						<td><?php echo e($mission->startOrt); ?></td>
						<td> &rarr; </td>
						<td><?php echo e($mission->zielOrt); ?></td>
						<td style="text-align: right; 
								width: 110px"><?php echo e(number_format($mission->preisFahrer, 2, ',', ' ')); ?> €
						</td>
						<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/credit/<?php echo e($credit->id); ?>/delete/<?php echo e($mission->id); ?>'">
								<b>-</b>
							</button>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr class="my1001">
					<td colspan="6" style="text-align: right"><b>Summe: </td>
					<td style="text-align: right; width: 100px">
						<b><?php echo e(number_format($credit->missions->sum('preisFahrer'), 2, ',', ' ')); ?> €
					</td><td></td>
				</tr>
			</table>
			<h3>Auftrag hinzufügen</h3>
			<table class="table">
				<tr class="my1000">
					<th style="text-align: center">Tour-Nr.</th>
					<th style="text-align: center">Liefer-Datum</th>
					<th>Auftraggeber</th>
					<th colspan="3">Tourenbeschreibung</th>
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
						<td><?php echo e($mission->customer->name); ?> </td>
						<td><?php echo e($mission->startOrt); ?></td>
						<td> &rarr; </td>
						<td><?php echo e($mission->zielOrt); ?></td>
						<td style="text-align: right; 
								width: 150px"><?php echo e(number_format($mission->preisFahrer, 2, ',', ' ')); ?> €
						</td>
						<td style="text-align: center">
							<button class="form-control" 
									onclick="window.location.href=
										'/credit/<?php echo e($credit->id); ?>/add/<?php echo e($mission->id); ?>'">
								<b> + </b>
							</button>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
			</table>
	</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/credit/edit.blade.php ENDPATH**/ ?>