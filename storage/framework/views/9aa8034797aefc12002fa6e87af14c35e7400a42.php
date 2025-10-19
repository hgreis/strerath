<div class="whitebox">
    <?php echo e(Form::hidden('id', $input->id)); ?><br>
    <p class="my1012">
        <?php echo e(Form::label('parts', 'Wie viele Teilstrecken sollen angelegt werden', ['class' => 'form-control'])); ?>

    </p>
    <p class="my1011">
        <?php echo e(Form::text('parts', '', ['class' => 'form-control'])); ?>

    </p>

    <?php echo e(Form::submit('Tour aufteilen', [
            'class' => 'form-control', 
            'name' => 'submit'])); ?>

    <br>
</div><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_splitquest.blade.php ENDPATH**/ ?>