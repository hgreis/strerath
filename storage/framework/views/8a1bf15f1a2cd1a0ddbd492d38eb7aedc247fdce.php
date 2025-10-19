<div>
<?php if(isset($id)): ?>
	<h1>Kunde bearbeiten</h1><hr>
<?php else: ?> 
	<h1>Einen neuen Kunden anlegen</h1><hr>
<?php endif; ?>
	<form action="/dekra/save_customer" method="post">
		<?php echo e(csrf_field()); ?>

		<label>Firmenname / Name des Kunden</label>
		<?php if(isset($id)): ?>
			<input type="hidden" name="id" value="<?php echo e($id); ?>">
		<?php endif; ?>
		<input type="text" name="name" value="<?php echo e($customerToEdit->name); ?>" class="form-control" required>
		<label>Strasse & Hausnummer</label>
		<input type="text" name="street" value="<?php echo e($customerToEdit->street); ?>" class="form-control">
		<label>Postleitzahl & Stadt</label>
		<input type="text" name="city" value="<?php echo e($customerToEdit->city); ?>" class="form-control">
		<label>Land</label>
		<input type="text" name="country" value="<?php echo e($customerToEdit->country); ?>" class="form-control">
		<label>Steuer-Nummer</label>
		<input type="text" name="steuernr" value="<?php echo e($customerToEdit->steuernr); ?>" class="form-control">
		<label>Telefon / Mobiltelefon</label>
		<input type="text" name="phone" value="<?php echo e($customerToEdit->phone); ?>" class="form-control">
		<label>Emailadresse</label>
		<input type="text" name="email" value="<?php echo e($customerToEdit->email); ?>" class="form-control">
		<label>Bemerkungen</label>
		<textarea class="form-control" name="notice"><?php echo e($customerToEdit->notice); ?></textarea><br>
		<label>Zahlungsziel: &nbsp;</label>
		<select name="duration" style="color: black">
			<option value="30">30 Tage</option>
			<option value="14">14 Tage</option>
			<option value="7">7 Tage</option>
		</select>´<br><br>
		<?php echo e(Form::submit('Senden', ['class' => 'form-control'])); ?>

	</form><hr>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/customer.blade.php ENDPATH**/ ?>