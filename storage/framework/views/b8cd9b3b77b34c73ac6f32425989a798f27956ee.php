<?php echo $__env->make('pages.datepicker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('content'); ?>
    <h1>Auswertung: <?php echo e($companies->start); ?> bis <?php echo e($companies->end); ?></h1>
    <div class="whitebox" style="text-align: center">
    	INFO: zur Berechnung werden alle Aufträge/Fahrten tagesgenau ausgewertet, unabhähngig ob eine Rechung bereits erstellt wurde oder nicht.
    </div>
    <div>
	    <div class="my1004">
	    	<h3> <?php echo e($companies[0]->nameCompany); ?> </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr>
	    			<th>Umsatz</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[0]->umsatz, 2)); ?> €</td>
	    		</tr>
	    		<tr>
	    			<th>Kosten</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[0]->kosten, 2)); ?> €</td>
	    		</tr>
	    		<tr>
	    			<th>Gewinn</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[0]->gewinn, 2)); ?> €</td>
	    		</tr>
	    	</table>
	    </div>
	    <div class="my1005">
	    	<h3 style="text-align: center"> <?php echo e($companies[1]->nameCompany); ?> </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr style="color: black">
	    			<th>Umsatz</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[1]->umsatz, 2)); ?> €</td>
	    		</tr>
	    		<tr style="color: black">
	    			<th>Kosten</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[1]->kosten, 2)); ?> €</td>
	    		</tr>
	    		<tr style="color: black">
	    			<th>Gewinn</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[1]->gewinn, 2)); ?> €</td>
	    		</tr>
	    	</table>
	    </div>
	    <div class="my1006">
	    	<h3 style="text-align: center"> <?php echo e($companies[2]->nameCompany); ?> </h3>
	    	<table class="table" style="max-width: 250px" align="center">
	    		<tr>
	    			<th>Umsatz</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[2]->umsatz, 2)); ?> €</td>
	    		</tr>
	    		<tr>
	    			<th>Kosten</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[2]->kosten, 2)); ?> €</td>
	    		</tr>
	    		<tr>
	    			<th>Gewinn</th>
	    			<td style="text-align: right;"><?php echo e(number_format($companies[2]->gewinn, 2)); ?> €</td>
	    		</tr>
	    	</table>
	    </div>
    </div>
    <div style="clear: both; margin-top: 300px" >
		<h3>Berechnungszeitraum wählen</h3>    	
    	<?php echo e(Form::open(array('url' => 'chart', 'enctype' => 'multipart/form-data'))); ?>

            <?php echo e(csrf_field()); ?>

            <div style="float: left; margin: 10px">
	            <?php echo e(Form::label('startDatum', 'VON:')); ?>

	            <?php echo e(Form::text('startDatum', null, [
	            	'class' => 'date form-control', 'id' => 'datepicker'])); ?>

            </div>
            <div style="float: left; margin: 10px">
	            <?php echo e(Form::label('endDatum', 'BIS:')); ?>

	            <?php echo e(Form::text('endDatum', null, [
	            	'class' => 'date form-control'])); ?>

            </div>
            <div style="float: left; margin: 10px; padding-top: 30px">
	            <?php echo e(Form::submit('Anzeigen', [
	                    'class' => 'form-control',
	                    'name' => 'submit',
	                    'style' => 'width: 300px' ])); ?>

            </div>
		<?php echo e(Form::close()); ?>

    </div>



<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>  

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/chart/missions.blade.php ENDPATH**/ ?>