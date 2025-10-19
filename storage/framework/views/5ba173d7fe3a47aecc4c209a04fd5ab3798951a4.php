<?php $__env->startSection('content'); ?>
<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

<?php
	$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
?>

	<h1>Kalender-Ansicht - alle Aufträge</h1>
	<?php $__currentLoopData = $missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$tag = date_format(date_create($date[0]->startDatum), 'w');
		?>
		<div class="greybox">
			<div class="flip">
				<h3><?php echo e(date_format(date_create($date[0]->startDatum), 'd.m.Y')); ?> <?php echo e($tage[$tag]); ?></h3>
			</div>
			<div class="panel">
				<table style="width: 100%">
					<tr class="myth">
						<th>#</th>
						<th>Fahrer</th>
						<th>Auftraggeber</th>
						<th>Beschreibung</th>
						<th style="text-align: center">Kosten</th>
						<th style="text-align: center">Umsatz</th>
						<th style="text-align: center">Gewinn</th>
					</tr>
					<?php $__currentLoopData = $date->sortBy('fahrer'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($mission->company == 2): ?>
							<tr style="background-color: yellow">
						<?php else: ?>
							<tr>
						<?php endif; ?>
							<?php if( $mission->deliveryNote != null): ?>
									<td style="width: 100px">
										<a class="missionOK" 
											target="_blank" 
											href="/mission/<?php echo e($mission->id); ?>/details">Tour-Nr.: <?php echo e($mission->id); ?>

										</a>
									</td>
							<?php else: ?>
									<td style="width: 100px">
										<a class="missionNotOK" 
											target="_blank" 
											href="/mission/<?php echo e($mission->id); ?>/details">Tour-Nr.: <?php echo e($mission->id); ?>

										</a>
									</td>
							<?php endif; ?>
							<td>
								<a href="/mission/view/<?php echo e($mission->id); ?>/driver">
									<?php echo e($mission->fahrer); ?>

								</a>
							</td>
							<td>
								<a href="/mission/view/<?php echo e($mission->id); ?>/customer">
									<?php echo e($mission->kunde); ?>

								</td>
							<td style="max-width: 300px">
								<?php echo e($mission->startOrt); ?> &rarr; <?php echo e($mission->zielOrt); ?>

							</td>
							<td style="text-align: right"><?php echo e(number_format($mission->preisFahrer, 2)); ?> € </td>
							<td style="text-align: right"><?php echo e(number_format($mission->preisKunde, 2)); ?> € </td>
							<td style="text-align: right">
								<?php echo e(number_format($mission->preisKunde-$mission->preisFahrer, 2)); ?> € 
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td colspan="7">
							<button class="form-control" 
									onclick="window.location.href='/mission/new/<?php echo e($mission->startDatum); ?>'">
								Auftrag Hinzufügen
							</bu	tton>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right"><b>Summe:</b></td>
						<td style="text-align: right">
							<b><?php echo e(number_format($date->sum('preisFahrer'), 2)); ?> €</b>
						</td>
						<td style="text-align: right">
							<b><?php echo e(number_format($date->sum('preisKunde'), 2)); ?> €</b>
						</td>
						<td style="text-align: right">
							<b><?php echo e(number_format($date->sum('preisKunde')-$date->sum('preisFahrer'), 2)); ?> €</b>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





<script>
	var acc = document.getElementsByClassName("flip");
	var i;

	for (i = 0; i < acc.length; i++) {
	    acc[i].addEventListener("click", function() {
	        this.classList.toggle("active");
	        var panel = this.nextElementSibling;
	        if (panel.style.display === "block") {
	            panel.style.display = "none";
	        } else {
	            panel.style.display = "block";
	        }
	    });
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/calendar.blade.php ENDPATH**/ ?>