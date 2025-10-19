<?php $__env->startSection('content'); ?>
	<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<h1 style="text-align: center">Fahrten quittieren</h1>
	<?php $__currentLoopData = $missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php if($missions->company == 1): ?>
			<div class="redbox">
		<?php else: ?>
			<div class="pinkbox">
		<?php endif; ?>
			<div class="flip">
				<h3> <?php echo e($customer[0]->kunde); ?> </h3>
			</div>
				<div class="panel">
					<table class="table">
						<tr class="my1000">
							<th>#</th>
							<th>Datum</th>
							<th>Beschreibung</th>
							<th>Bemerkung</th>
							<th>Netto</th>
							<th></th>
						</tr>
						<?php $__currentLoopData = $customer->sortBy('startDatum'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="my1001">
								<?php if( $mission->deliveryNote != null): ?>
									<td style="width: 130px">
										<a class="button" 
											target="_blank" 
											href="/mission_overview/<?php echo e($mission->id); ?>"
											style="color: black; background-color: green;">Tour-Nr.: <?php echo e($mission->id); ?>

										</a>
									</td>
								<?php else: ?>
									<td style="width: 130px">
										<a class="button" 
											target="_blank" 
											href="/mission_overview/<?php echo e($mission->id); ?>"
											style="color: black; background-color: red;">Tour-Nr.: <?php echo e($mission->id); ?>

										</a>
									</td>
								<?php endif; ?>
								<td style="text-align: center">
									<?php echo e(date_format(date_create($mission->startDatum), 'd.m.Y')); ?>

								</td>
								<td><?php echo e($mission->startOrt); ?> -> <?php echo e($mission->zielOrt); ?> </td>
								<td> <?php echo e($mission->kundeBemerkung); ?> </td>
								<td style="text-align: right; padding-right: 15px"> <?php echo e(number_format($mission->preisKunde,2)); ?> </td>
								<td>
									<button class="form-control" onclick="window.location.href='/payMission/<?php echo e($mission->id); ?>'">BEZAHLT</button>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/missionsPaid.blade.php ENDPATH**/ ?>