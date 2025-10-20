<?php $__env->startSection('content'); ?>
<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

	<h1>
		Auftrags-Übersicht &nbsp;&nbsp;&nbsp;
	</h1>
	
	<div style="width: 60%; margin-left: 20%" >
		<form method="get" action="/mission/view" >
			<select name='driver' class='form-control'>
				<option value="">--- Fahrer auswählen ---</option>
				<?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($driver->fahrer); ?> "><?php echo e($driver->fahrer); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			<select name='customer' class='form-control'>
				<option value="">--- Kunde auswählen ---</option>
				<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($customer->kunde); ?> "><?php echo e($customer->kunde); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			<select name='date' class='form-control'>
				<option value="">--- Datum auswählen ---</option>
				<?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($date->zielDatum); ?> "><?php echo e($date->zielDatum); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			<input type="submit" name="submit" value="FILTERN" class="form-control">
		</form>
	</div>
	<hr><?php echo e($missions->count()); ?> Aufträge
		<?php $__currentLoopData = $missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="greybox"> 
				<div class="flip">
					<table style="width: 100%">
						<tr>
							<th style="width: 8%">#<?php echo e($mission->id); ?></th>
							<th style="width: 10%"><?php echo e($mission->zielDatum); ?></th>
							<th style="width: 40%">
								<?php echo e($mission->startOrt); ?> -> <?php echo e($mission->zielOrt); ?>

							</th>
							<th><?php echo e($mission->kundeBemerkung); ?></th>
						</tr>
					</table>
				</div>
				<div class="panel">
					<?php $input = $mission; ?>
					<?php echo $__env->make('pages.forms.mission_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<button type="button" class="form-control" onclick="window.location.href='/mission/view/<?php echo e($mission->id); ?>/customer'">EDIT</button>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/view.blade.php ENDPATH**/ ?>