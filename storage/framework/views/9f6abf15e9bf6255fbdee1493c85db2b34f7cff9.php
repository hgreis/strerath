<?php $__env->startSection('content'); ?>
    <h1><?php echo e($company->nameCompany); ?> - Finanzreport</h1>
    <div class="whitebox" style="text-align: center">
    		INFO: für die Berechnung relevant sind das Rechnungsdatum, Gutschriftsdatum und der Tag, an dem eine Fahrt quittiert wird.

    </div>
    
    <?php if($company->id == 1): ?>
    	<div class="redbox" style="padding-top: 30px">
    <?php else: ?>
    	<div class="pinkbox" style="padding-top: 30px">
    <?php endif; ?>
    		<table class="table" style="width: 90%;" align="center">
    			<tr class="my1000">
    				<th rowspan="2"></th>
                    <th colspan="2" class="my1000" style="border-bottom: black !important">Rechnungen</th>
    				<th class="my1000" rowspan="2" style="border-bottom: black !important">Gutschriften</th>
    				<th colspan="2" class="my1000" style="border-bottom: black !important;">
                        Unternehmer-Gutschriften
                    </th>
    				<th rowspan="2" class="my1000" style="border-left: white !important">Unternehmer-<br>Rechnungen</th>
    			</tr>
    			<tr class="my1000">
    				<th class="my1000" style="border-top: black !important">Netto</th>
    				<th class="my1000" style="border-top: black !important">Brutto</th>
    				<th class="my1000" style="border-top: black !important">Netto</th>
    				<th class="my1000" style="border-top: black !important">Brutto</th>
    			</tr>
    		<?php $__currentLoopData = $company->year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    			<tr class="my1001">
    				<th class="my1000"><?php echo e($month['month']); ?></th>
    				<td class="my1007">
    					<?php echo e(number_format($month['billsPriceNet'], 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1007">
    					<?php echo e(number_format($month['billsPriceGross'], 2, ',', '. ')); ?> €
    				</td>
                    <td class="my1007">
                        <?php echo e(number_format($month['missionsPaid'], 2, ',', '. ')); ?> €
                    </td>
    				<td class="my1008">
    					<?php echo e(number_format($month['creditsPriceNet'], 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1008">
    					<?php echo e(number_format($month['creditsPriceGross'], 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1008">
    					<?php echo e(number_format($month['driversPaid'], 2, ',', '. ')); ?> €
    				</td>
    			</tr>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    			<tr class="my1001">
    				<th class="my1000">Summe</th>
    				<td class="my1007">
    					<?php echo e(number_format($company->yearBillNet, 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1007">
    					<?php echo e(number_format($company->yearBillGross, 2, ',', '. ')); ?> €
    				</td>
                    <td class="my1007">
                        <?php echo e(number_format($company->yearMissionsPaid, 2, ',', '. ')); ?> €
                    </td>
    				<td class="my1008">
    					<?php echo e(number_format($company->yearCreditNet, 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1008">
    					<?php echo e(number_format($company->yearCreditGross, 2, ',', '. ')); ?> €
    				</td>
    				<td class="my1008">
    					<?php echo e(number_format($company->yearDriverPaid, 2, ',', '. ')); ?> €
    				</td>
    			</tr>
    		</table>
    	</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/strerath/resources/views/pages/chart/bilance.blade.php ENDPATH**/ ?>