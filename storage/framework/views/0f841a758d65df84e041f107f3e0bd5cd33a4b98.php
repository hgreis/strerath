<?php $__env->startSection('content'); ?> 
<div style="width: 45%; float: left">
		<h1>Kundenübersicht</h1><hr>
		<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="greybox">
					<div class="flip">
						<h3><?php echo e($customer->name); ?></h3>
					</div>
					<div class="panel">
						<?php echo e($customer->street); ?><br>
						<?php echo e($customer->city); ?> <br> 
						<?php echo e($customer->country); ?><br><br>
						Telefon: <?php echo e($customer->phone); ?> <br>
						Email: <?php echo e($customer->email); ?><br>
						Steuersatz: <?php echo e($customer->taxes); ?> %<br>
						Notiz: <?php echo e($customer->notice); ?><br>
						<button type="button" class="form-control" onclick="window.location.href='/dekra/new_customer/<?php echo e($customer->id); ?>'">
							EDIT
						</button>

					</div>
				</div>
			</a>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div style="width: 45%; float: right;">
	<?php echo $__env->make('pages.forms.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/StrerathTransporte/resources/views/pages/customer.blade.php ENDPATH**/ ?>