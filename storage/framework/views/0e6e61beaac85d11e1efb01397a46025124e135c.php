<?php $__env->startSection('content'); ?>
	<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<h1>Unternehmer-Gutschrift erstellen</h1>
	<form action="/saveCredit" method="post">
				<?php echo e(csrf_field()); ?>

        <nobr><?php echo e(Form::radio('taxes', 19, true)); ?> 19% Mehrwertsteuer &emsp;</nobr>
        <nobr><?php echo e(Form::radio('taxes', 300)); ?> Mehrwertsteuerbefreit nach §3a &emsp;</nobr>
        <nobr><?php echo e(Form::radio('taxes', 305)); ?> Mehrwertsteuerbefreit nach §4 &emsp;</nobr>				
	
<?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($company == 2): ?>
		<div class="pinkbox"> 
		<input type="hidden" name="company" value="2">
	<?php else: ?>
		<div class="redbox"> 
		<input type="hidden" name="company" value="1">
	<?php endif; ?>
			<div class="flip">
				<h3><?php echo e($driver->name); ?></h3>
			</div>
			<div class='panel'>
				<?php $__currentLoopData = $driver->missions->sortBy('startDatum'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<table>
						<tr>
							<td>
								<input type="checkbox" name="<?php echo e($mission->id); ?>">
							</td>
							<?php if( $mission->deliveryNote != null): ?>
								<td style="width: 100px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/<?php echo e($mission->id); ?>"
										style="color: black; background-color: green;">Tour-Nr.: <?php echo e($mission->id); ?>

									</a>
								</td>

							<?php else: ?>
								<td style="width: 100px">
									<a class="button" 
										target="_blank" 
										href="/mission_overview/<?php echo e($mission->id); ?>"
										style="color: black; background-color: red;">Tour-Nr.: <?php echo e($mission->id); ?>

									</a>
								</td>
							<?php endif; ?>
							<td style="width: 100px"><?php echo e($mission->startDatum); ?></td>
							<td style="width: 300px"><?php echo e($mission->kunde); ?></td>
							<td style="width: 200px"><?php echo e($mission->startOrt); ?></td>
							<td style="width: 200px"><?php echo e($mission->zielOrt); ?></td>
							<td><?php echo e($mission->preisFahrer); ?> €</td>
						</tr>
					</table>	
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
				<button class="form-control" 
						value="<?php echo e($mission->fahrer); ?>"
						name="submit" 
						style="background-color: grey; color: white">
							<b>Gutschrift erstellen</b>
				</button>	
			</div>
		</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	</form>


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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/creditsGenerate.blade.php ENDPATH**/ ?>