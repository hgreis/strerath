<div style="width: 600px; float: left">
<h1>Auftrag <?php echo e($input->id); ?>: LÖSCHEN</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

    <div class="form-group">
        <?php echo e(Form::hidden('id', $input->id)); ?>

        <?php echo e(Form::submit('LÖSCHEN', [
            'class' => 'form-control',
            'class' => 'redButton', 
            'name' => 'delete'])); ?>

    </div>
</div>
<?php /**PATH /var/www/StrerathTransporte/resources/views/pages/forms/mission_delete.blade.php ENDPATH**/ ?>