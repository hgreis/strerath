<div style="float: right; width: 30%; padding-top: 20px ">
    <div class="form-group">
        <?php if($input->company == 2): ?>
            <p style="margin-left: 20px">
                <?php echo e(Form::radio('company', 1)); ?> STRERATH Transporte<br>
                <?php echo e(Form::radio('company', 2, true)); ?> Sabine Heinrichs Transporte<br>
            </p>
        <?php else: ?>
            <p style="margin-left: 20px">
                <?php echo e(Form::radio('company', 1, true)); ?> STRERATH Transporte<br>
                <?php echo e(Form::radio('company', 2)); ?> Sabine Heinrichs Transporte<br>
            </p>
        <?php endif; ?>
        

        <?php echo e(Form::submit('Touren-Start', [
            'class' => 'blackButton', 
        	'name' => 'submit'])); ?>

        <?php echo e(Form::submit('Touren-Ziel', [
        	'class' => 'blackButton', 
        	'name' => 'submit'])); ?>

        <?php echo e(Form::submit('Kunde', [
        	'class' => 'blackButton',
        	'name' => 'submit'])); ?> 
        <?php echo e(Form::submit('Fahrer/Unternehmer', [
        	'class' => 'blackButton', 
        	'name' => 'submit'])); ?>

        <?php if($choice != 'Tour aufteilen'): ?>
            <?php echo e(Form::submit('Tour aufteilen', [
                'class' => 'blackButton', 
                'name' => 'submit'])); ?>

        <?php endif; ?>
        <?php echo e(Form::submit('Auftrag Löschen', [
        	'class' => 'redButton', 
        	'name' => 'submit'])); ?>

        <?php echo e(Form::submit('Speichern/Menu', [
            'class' => 'blackButton', 
            'name' => 'submit'])); ?>

    </div>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_menu.blade.php ENDPATH**/ ?>