<?php $__env->startSection('content'); ?>
<form action="/drivers" method="post">
			<?php echo e(csrf_field()); ?>

	<table style="width: 100%">
		<tr>
			<td style="padding-right: 10px">
				<div class="form-group">
					<label>Fahrer-Name: </label>
					<input type="text" class="form-control" name="name" value="<?php echo e($drivers->driver->name); ?>" required>
					<input type="hidden" name="id" value="<?php echo e($drivers->driver->id); ?>">
				</div>	
				<div class="form-group">
					<label>Telefon:</label>
					<input type="text" name="phone" class="form-control" value="<?php echo e($drivers->driver->phone); ?>">
				</div>
				<div class="form-group">
					<label>Steuer-Nummer:</label>
					<input type="text" name="steuernr" class="form-control" value="<?php echo e($drivers->driver->steuernr); ?>">
				</div>				
				<div class="form-group">
					<label>KFZ-Kennzeichen:</label>
						<input type="text" 
							name="number_plate" 
							class="form-control" 
							value="<?php echo e($drivers->driver->number_plate); ?>">
				</div>
			</td>
			<td>
				<div class="form-group">
					<label>Unternehmer:</label>
					<input type="text" 
						name="contractor" 
						class="form-control" 
						value="<?php echo e($drivers->driver->contractor); ?>">	
				</div>
				<div class="form-group">
					<label>Strasse:</label>
					<input type="text" name="street" class="form-control" value="<?php echo e($drivers->driver->street); ?>">
				</div>
				<div class="form-group">
					<label>Stadt:</label>
					<input type="text" name="city" class="form-control" value="<?php echo e($drivers->driver->city); ?>" >
				</div>
				<div class="form-group">
					<label>Emailadresse:</label>
					<input type="text" name="email" class="form-control" value="<?php echo e($drivers->driver->email); ?>">
				</div>
				</td>
		</tr>
	</table>
	<input type="Submit" class="form-control" style="margin-top: 20px" name="submit" value="Speichern">
</form><br>

<div class="whitebox">
	<h3>Übersicht aller Fahrer</h3>
	<table width="100%">
		<tr>
			<th style="padding: 5px">Name</th>
			<th>Fahrzeug-Typ</th>
			<th>KFZ-Kennzeichen</th>
			<th>Telefon</th>
			<th>Unternehmer</th>
		</tr>
		<?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	 		 <tr>
	 		 	<td><a href="/drivers/<?php echo e($driver->id); ?>"><?php echo e($driver->name); ?></a></td>
	 		 	<td><?php echo e($driver->car_brand); ?></td>
	 		 	<td><?php echo e($driver->number_plate); ?></td>
	 		 	<td><?php echo e($driver->phone); ?></td>
	 		 	<td><?php echo e($driver->contractor); ?></td>
	 		 </tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/drivers.blade.php ENDPATH**/ ?>